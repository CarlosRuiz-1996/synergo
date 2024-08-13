<?php

namespace App\Livewire\Tesoreria;

use Livewire\Component;

use App\Exports\reportes\ExcelreporteFacturascargas;
use App\Exports\reportes\Excelreportepagos;
use App\Jobs\ProcesarArchivosXml;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\WithPagination;
use App\Livewire\DescargarComprobateXmloPDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
class Tesoreria extends Component
{

    public DescargarComprobateXmloPDF $export;
    use WithPagination, WithoutUrlPagination; 
    use WithFileUploads;
    public $estacionSeleccionada=[];
    public $fechainicio = '2024-04-01';
    public $fechafin = '2024-04-30';
    public $TipoCombustible;
    public $estacion_detalle;
    protected $detalles = [];
    public $readyToLoad = false;
    public $monto_pagado;
    public $estaciond=[];
    public $valor1=false;
    public $showModal=false;
    public $connection;
    public $proveedor;
    public $nombre_reporte;
    #[Validate('required', message: 'El archivo es requerdo para procesar la información.')]
    #[Validate('mimes:zip', message: 'El documento debe ser un achivo ".ZIP".')]
    #[Validate('max:102400', message: 'El documento NO debe pesar más de "100MB".')]
    public $archivo_zip;
    public $facturas = [];
    public $showModalFacturas=false;
    public $ArchivosFallados;
    public $ArchivosAceptados;
    public $showModalFacturaspdf=false;
    public $pdfPath;
    public $estatusproducto=2;
    public $sinseleccionarestacion=false;
    public $estaciondtodos=[];

    public function mount()
    {
        $this->estatusproducto=2;
        $this->ArchivosFallados = collect();
        $this->ArchivosAceptados = collect();
    }

    public function render()
    {
        $connections = ['sqlsrv', 'sqlsrv2', 'sqlsrv3'];
        $combinedData = collect();

        foreach ($connections as $connection) {
            $data = DB::connection($connection)
                ->table('EMISOR')
                ->pluck('nombre_emisor'); // Esto ya devuelve una colección de strings
            $combinedData = $combinedData->merge($data);
        }

        // Asegúrate de que $combinedData es una colección de strings y usa unique
        $uniqueEmisors = $combinedData->unique()->values(); 

        $estaciones =  DB::table('EstacionesExcel')->orderBy('NombreEstacion', 'ASC')->get();
        $datos = $this->showModal ? $this->obtenerDatos() : collect(); // Si el modal está abierto, obtenemos los datos paginados
        return view('livewire.tesoreria.tesoreria', compact('estaciones','datos','uniqueEmisors'));
    }
    
    public function buscar()
    {
        $this->estaciond = [];
        $this->estaciondtodos = [];
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
        $nombreEmisor = $this->proveedor;
        $estatus = $this->estatusproducto;
        if (empty($this->estacionSeleccionada)) {
            if (!empty($nombreEmisor)) {
                // Si no hay estaciones seleccionadas pero hay proveedor, busca en las tres conexiones
                $connections = ['sqlsrv', 'sqlsrv2', 'sqlsrv3'];
                foreach ($connections as $connection) {
                    $results = DB::connection($connection)
                        ->table('COMPROBANTE as c')
                        ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
                        ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
                        ->join('EMISOR as e', 'e.idcomprobante', '=', 'c.id')
                        ->whereBetween('c.Fecha', [$startDate, $endDate])
                        ->where('c.TipoDeComprobante', 'LIKE', 'I')
                        ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                            $query->where('e.nombre_emisor', 'LIKE', "%{$nombreEmisor}%");
                        })
                        ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                            $query->where('c.estatus', $estatus);
                        })
                        ->select(
                            'c.id',
                            'c.Fecha',
                            DB::raw("CONCAT(c.Serie, '-', c.folio) as n_factura"),
                            'conc.descripcion as combustible',
                            'conc.cantidad as litros',
                            'c.SubTotal',
                            'c.Total',
                            't.UUID as uuid',
                            'c.TipoDeComprobante',
                            'e.nombre_emisor',
                            'c.estatus'
                        )
                        ->orderBy('c.Fecha', 'DESC')->get();
    
                    $this->estaciondtodos[$connection] = $results;
                    $this->sinseleccionarestacion = true;
                }
            } else {
                $this->sinseleccionarestacion = false;
                return null;
            }
        } else {
    
            $selectedStations = $this->estacionSeleccionada;
        foreach ($selectedStations as $station) {
            switch ($station) {
                case 153:
                    $connection = 'sqlsrv';
                    break;
                case 143:
                    $connection = 'sqlsrv3';
                    break;
                case 141:
                    $connection = 'sqlsrv2';
                    break;
                default:
                    continue 2; // Si no es ninguna de las estaciones especificadas, salta al siguiente
            }
    
            // Aquí puedes realizar las búsquedas y agregar los resultados al array estaciond
            $data = DB::connection($connection)->table('Estaciones')->get(); // Utiliza get() si esperas múltiples resultados
    
            // Calcular montos y total de facturas para cada estación
            $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
            $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
            $nombreEmisor = $this->proveedor;
            $estatus = $this->estatusproducto;
    
            // Suma del total pagado para la estación actual
            $monto_pagado = DB::connection($connection)->table('COMPROBANTE as c')
                ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
                ->join('EMISOR as e', 'e.idcomprobante', '=', 'c.id') // Unir con EMISOR
                ->whereBetween('c.Fecha', [$startDate, $endDate])
                ->where('c.TipoDeComprobante', 'LIKE', 'I')
                ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                    $query->where('e.nombre_emisor', 'LIKE', $nombreEmisor); // Filtro por nombre_emisor si está definido
                })
                ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                    $query->where('c.estatus', $estatus); // Filtro por estatus si está definido
                })
                ->sum('c.Total');
    
            // Contar el número de facturas para la estación actual
            $total_facturas = DB::connection($connection)->table('COMPROBANTE as c')
                ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
                ->join('EMISOR as e', 'e.idcomprobante', '=', 'c.id') // Unir con EMISOR
                ->whereBetween('c.Fecha', [$startDate, $endDate])
                ->where('c.TipoDeComprobante', 'LIKE', 'I')
                ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                    $query->where('e.nombre_emisor', 'LIKE', $nombreEmisor); // Filtro por nombre_emisor si está definido
                })
                ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                    $query->where('c.estatus', $estatus); // Filtro por estatus si está definido
                })
                ->count();
    
            // Agregar los montos y el total de facturas a los datos de la estación
            foreach ($data as $item) {
                $item->monto_pagado = $monto_pagado;
                $item->total_facturas = $total_facturas;
            }
            $this->sinseleccionarestacion = false;
            // Asignar los datos de la estación con los montos y total de facturas a la propiedad estaciond
            $this->estaciond[$station] = $data;
        }
        $this->sinseleccionarestacion = false;
    }
    }
    

    public $total_facturas;
    public function monto()
    {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
        $nombreEmisor = $this->proveedor; // o lo que corresponda según tu lógica
        $estatus=$this->estatusproducto;
        // Suma del total pagado
        $this->monto_pagado = DB::connection($this->connection)->table('COMPROBANTE as c')
            ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
            ->join('EMISOR as e', 'e.idcomprobante', '=', 'c.id') // Unir con EMISOR
            ->whereBetween('c.Fecha', [$startDate, $endDate])
            ->where('c.TipoDeComprobante', 'LIKE', 'I')
            ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                $query->where('e.nombre_emisor', 'LIKE', $nombreEmisor); // Filtro por nombre_emisor si está definido
            })
            ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                $query->where('c.estatus', $estatus); // Filtro por estatus si está definido
            })
            ->sum('c.Total');
    
        // Contar el número de facturas
        $this->total_facturas = DB::connection($this->connection)->table('COMPROBANTE as c')
            ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
            ->join('EMISOR as e', 'e.idcomprobante', '=', 'c.id') // Unir con EMISOR
            ->whereBetween('c.Fecha', [$startDate, $endDate])
            ->where('c.TipoDeComprobante', 'LIKE', 'I')
            ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                $query->where('e.nombre_emisor', 'LIKE', $nombreEmisor); // Filtro por nombre_emisor si está definido
            })
            ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                $query->where('c.estatus', $estatus); // Filtro por estatus si está definido
            })
            ->count();
    }
    



    public function abrirModal($valor)
    {
        // Reiniciar el estado del componente
        $this->nombre_reporte="";
        $this->resetPage();
        $this->reset(['fechainicio', 'fechafin','estatusproducto']);
        switch ($valor) {
            case 153:
                $this->connection = 'sqlsrv';
                $this->nombre_reporte=$this->proveedor.'  /  GASOLINERIA DEL FUTURO';
                break;
            case 143:
                $this->connection = 'sqlsrv3';
                $this->nombre_reporte=$this->proveedor.'  /  CORPORATIVO INMOBILIARIO ECUESTRE';
                break;
            case 141:
                $this->connection = 'sqlsrv2';
                $this->nombre_reporte=$this->proveedor.'  /  GASOLINERIA CORAL S.A. DE C.V.';
                break;
            default:
                return null; 
        }
        
        $this->showModal = true;
    }
    public function obtenerDatosdos(){
        $this->resetPage();
        $this->obtenerDatos();
        $this->monto();
    }

    public function obtenerDatos()
    {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
        // Asegúrate de definir $this->nombreEmisor si quieres filtrar por un nombre de emisor específico
        $nombreEmisor = $this->proveedor; 
        $estatus=$this->estatusproducto;
        $this->monto();
        return DB::connection($this->connection)
                ->table('COMPROBANTE as c')
                ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
                ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
                ->join('EMISOR as e', 'e.idcomprobante', '=', 'c.id') // Unir con EMISOR
                ->whereBetween('c.Fecha', [$startDate, $endDate])
                ->where('c.TipoDeComprobante', 'LIKE', 'I')
                ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                    $query->where('e.nombre_emisor', 'LIKE', "%{$nombreEmisor}%"); // Filtro por nombre_emisor si está definido
                })
                ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                    $query->where('c.estatus', $estatus); // Filtro por estatus si está definido
                })
                ->select(
                    'c.id',
                    'c.Fecha',
                    DB::raw("CONCAT(c.Serie, '-', c.folio) as n_factura"),
                    'conc.descripcion as combustible',
                    'conc.cantidad as litros',
                    'c.SubTotal',
                    'c.Total',
                    't.UUID as uuid',
                    'c.TipoDeComprobante',
                    'e.nombre_emisor',
                    'c.estatus'
                )
                ->orderBy('c.Fecha', 'DESC')
                ->paginate(5);
    }
    
    


    //xml

    public function descargarXML($id)
{
    // Cambiar la conexión de base de datos
    $comprobante = DB::connection($this->connection)
        ->table('TIMBRE_FISCAL_DIGITAL')
        ->where('idcomprobante', $id)
        ->first();

    if (!$comprobante) {
        return response()->json(['error' => 'Comprobante no encontrado.'], 404);
    }

    // Nombre del archivo XML basado en el UUID del comprobante
    $filenameXML = strtoupper($comprobante->UUID);

    // Ruta principal donde buscar
    $baseDir = storage_path('app/public/facturas_extraidas');

    // Llamar a la función para buscar el archivo en el directorio y subdirectorios
    $pathXML = $this->findFileInDirectory($baseDir, $filenameXML);

    if ($pathXML) {
        return response()->download($pathXML);
    } else {
        return response()->json(['error' => 'El archivo no se encontró.'], 404);
    }
}

private function findFileInDirectory($directory, $searchTerm)
{
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

    // Convertir el término de búsqueda a minúsculas
    $searchTerm = strtolower($searchTerm);

    foreach ($files as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'xml') {
            // Convertir el nombre del archivo a minúsculas para comparación
            $filename = strtolower($file->getFilename());

            // Verificar si el nombre del archivo contiene el término de búsqueda
            if (strpos($filename, $searchTerm) !== false) {
                return $file->getPathname();
            }
        }
    }

    return null;
}

private function findFileInDirectorypdf($directory, $searchTerm)
{
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

    // Convertir el término de búsqueda a minúsculas
    $searchTerm = strtolower($searchTerm);

    foreach ($files as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'pdf') {
            // Convertir el nombre del archivo a minúsculas para comparación
            $filename = strtolower($file->getFilename());

            // Verificar si el nombre del archivo contiene el término de búsqueda
            if (strpos($filename, $searchTerm) !== false) {
                return $file->getPathname();
            }
        }
    }

    return null;
}





    //detalles
    public $open = false;
    public function openModal()
    {
        $this->open = true;
    }

    public function clean()
    {
        $this->reset('open');
    }

    public function updatedArchivoZip($value)
    {
        // Lógica para procesar el archivo zip
        // Puedes habilitar el botón aquí si deseas
    }

    public function procesarArchivos()
    {
        $this->validate();

        // Generar un nombre único usando la fecha y hora actual
        $timestamp = now()->format('Y-m-d_His'); // Formato: YYYYMMDD_HHMMSS
        $fileName = "archivo_{$timestamp}.zip";
        // Guardar el archivo en la carpeta 'facturas'
        $filePath = $this->archivo_zip->storeAs(path: 'public/facturas', name: $fileName);
        $this->descomprimirArchivo($filePath);
    }   
    private function descomprimirArchivo($filePath)
    {
        $fileName = basename($filePath);
        $localPath = storage_path("app/public/facturas/{$fileName}");
        $extractFolderName = pathinfo($fileName, PATHINFO_FILENAME); // Nombre de la carpeta basado en el nombre del archivo sin la extensión
        $extractPath = storage_path("app/public/facturas_extraidas/{$extractFolderName}");

        // Crear la carpeta específica para este archivo si no existe
        if (!File::exists($extractPath)) {
            File::makeDirectory($extractPath, 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($localPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();

            // Obtener la lista de archivos extraídos
            $this->facturas = array_diff(scandir($extractPath), array('.', '..'));

            // Generar el archivo JSON con los datos de los archivos XML
            $this->generarArchivoJson($extractPath, $extractFolderName);
        } else {
            session()->flash('error', 'No se pudo abrir el archivo ZIP.');
        }
    }

    private function generarArchivoJson($rutaDirectorioDescomprimido, $extractFolderName)
    {
        // Lista de archivos en el directorio descomprimido
        $archivosDescomprimidos = array_diff(scandir($rutaDirectorioDescomprimido), ['.', '..']);

        // Array para almacenar los datos de los archivos XML
        $datos = [];

        // Iterar sobre los archivos en el directorio descomprimido
        foreach ($archivosDescomprimidos as $archivo) {
            // Validar que el archivo sea un XML
            if (pathinfo($archivo, PATHINFO_EXTENSION) === 'xml') {
                // Ruta completa del archivo XML
                $rutaArchivoXml = $rutaDirectorioDescomprimido . DIRECTORY_SEPARATOR . $archivo;

                try {
                    // Cargar el archivo XML
                    $xml = simplexml_load_file($rutaArchivoXml);

                    if ($xml === false) {
                        throw new \Exception("No se pudo cargar el archivo XML '$archivo'");
                    }

                    // Verificar que el objeto XML se cargó correctamente
                    if ($xml !== false) {
                        $comprobante = $xml->attributes();
                        $emisor = isset($xml->children('cfdi', true)->Emisor) ? $xml->children('cfdi', true)->Emisor->attributes() : null;
                        $receptor = isset($xml->children('cfdi', true)->Receptor) ? $xml->children('cfdi', true)->Receptor->attributes() : null;
                        $conceptos = [];

                        // Iterar sobre todos los Conceptos dentro de Conceptos
                        foreach ($xml->children('cfdi', true)->Conceptos->Concepto as $concepto) {
                            $conceptos[] = $concepto->attributes();
                        }

                        $complemento = isset($xml->children('cfdi', true)->Complemento) ? $xml->children('cfdi', true)->Complemento : null;
                        $Pagospago = null;
                        $DoctoRelacionado = null;
                        $DoctoRelacionado2 = null;
                        $impuestosP = null;
                        $totales = null;
                        $TimbreFiscalDigital = null;

                        // Acceder a otros elementos como PagosPago, DoctoRelacionado, etc. según sea necesario
                        if ($complemento !== null) {
                            $complemento2 = $complemento->attributes();
                            if (isset($complemento->children('pago20', true)->Pagos->Pago)) {
                                $Pagospago = $complemento->children('pago20', true)->Pagos->Pago->attributes();
                                if (isset($complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado)) {
                                    $DoctoRelacionado = $complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado->attributes();
                                    if (isset($complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado->ImpuestosDR->TrasladosDR->TrasladoDR)) {
                                        $DoctoRelacionado2 = $complemento->children('pago20', true)->Pagos->Pago->DoctoRelacionado->ImpuestosDR->TrasladosDR->TrasladoDR->attributes();
                                    }
                                }
                                if (isset($complemento->children('pago20', true)->Pagos->Pago->ImpuestosP->TrasladosP->TrasladoP)) {
                                    $impuestosP = $complemento->children('pago20', true)->Pagos->Pago->ImpuestosP->TrasladosP->TrasladoP->attributes();
                                }
                            }
                            if (isset($complemento->children('pago20', true)->Pagos->Totales)) {
                                $totales = $complemento->children('pago20', true)->Pagos->Totales->attributes();
                            }
                            if (isset($complemento->children('tfd', true)->TimbreFiscalDigital)) {
                                $TimbreFiscalDigital = $complemento->children('tfd', true)->TimbreFiscalDigital->attributes();
                            }
                        }

                        // Convertir el objeto SimpleXMLElement a un array
                        $datosXml = [
                            'Comprobante' => $comprobante ? $comprobante : [],
                            'Emisor' => $emisor ? $emisor : [],
                            'Receptor' => $receptor ? $receptor : [],
                            'Conceptos' => $conceptos ? $conceptos : [],
                            'Complemento' => $complemento2 ? $complemento2 : [],
                            'PagosPago' => $Pagospago ? $Pagospago : [],
                            'DoctoRelacionado' => $DoctoRelacionado ? $DoctoRelacionado : [],
                            'DoctoRelacionado2' => $DoctoRelacionado2 ? $DoctoRelacionado2 : [],
                            'ImpuestosP' => $impuestosP ? $impuestosP : [],
                            'Totales' => $totales ? $totales : [],
                            'TimbreFiscalDigital' => $TimbreFiscalDigital ? $TimbreFiscalDigital : [],
                        ];

                        // Agregar el array de datos del XML al array principal de datos
                        $datos[] = $datosXml;
                    } else {
                        // Si no se pudo cargar el archivo XML, registra un error en el log
                        Log::error("No se pudo cargar el archivo XML '$archivo'");
                    }
                } catch (\Exception $e) {
                    // Si ocurre un error al procesar el archivo XML, registra el error en el registro y continúa con el siguiente archivo
                    Log::error("Error al procesar el archivo XML '$archivo': " . $e->getMessage());
                }
            }
        }

        // Crear la carpeta de json si no existe
        $jsonFolderPath = storage_path("app/public/json/{$extractFolderName}");
        if (!File::exists($jsonFolderPath)) {
            File::makeDirectory($jsonFolderPath, 0755, true);
        }

        // Convertir el array de datos a formato JSON y guardarlo en un archivo de texto
        $texto = json_encode($datos, JSON_PRETTY_PRINT);
        $rutaArchivoTexto = "{$jsonFolderPath}/{$extractFolderName}.json";

        try {
            // Intentar escribir el archivo de texto
            file_put_contents($rutaArchivoTexto, $texto);
            $this->insertarBase($rutaArchivoTexto);
            // Log para indicar que se ha generado el archivo de texto con los datos de los archivos XML
            Log::info('Archivo de texto generado con los datos de los archivos XML.');
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra al intentar escribir el archivo de texto
            Log::error('Error al escribir el archivo de texto: ' . $e->getMessage());
        }
    }



    
    public function insertarBase($rutaArchivoJson)
    {

        $this->ArchivosFallados = collect();
        $this->ArchivosAceptados = collect();
        if (!file_exists($rutaArchivoJson)) {
            abort(404, 'El archivo JSON no existe.');
        }
    
        // Obtener el contenido del archivo JSON
        $contenidoJson = file_get_contents($rutaArchivoJson);
    
        // Decodificar el JSON a un array asociativo de PHP
        $datos = json_decode($contenidoJson, true);
        $registrosExitosos = collect();
        $registrosFallidos = collect();
    foreach ($datos as $comprobante) {
        // Verificar si el objeto COMPROBANTE está presente y tiene atributos
        if (isset($comprobante['Comprobante']['@attributes']) && !empty($comprobante['Comprobante']['@attributes'])) {
            $folio = $comprobante['Comprobante']['@attributes']['Folio'] ?? null;

            // Obtener la conexión según el nombre del receptor
            $connection = 'default'; // Valor predeterminado
            if (isset($comprobante['Receptor']['@attributes']['Nombre'])) {
                $nombreReceptor = $comprobante['Receptor']['@attributes']['Nombre'];
                switch ($nombreReceptor) {
                    case 'GASOLINERIA DEL FUTURO':
                        $connection = 'sqlsrv';
                        break;
                    case 'GASOLINERIA CORAL':
                        $connection = 'sqlsrv2';
                        break;
                    case 'CORPORATIVO INMOBILIARIO ECUESTRE':
                        $connection = 'sqlsrv3';
                        break;
                }
            }

            // Verificar si el folio ya existe en la base de datos usando la conexión adecuada
            if ($folio) {
                $exists = DB::connection($connection)->table('COMPROBANTE')
                ->where('folio', 'LIKE', "%{$folio}%")
                ->exists();
            
                if ($exists) {
                    // Si el folio ya existe, agregar cada concepto individualmente a los registros fallidos
                    if (isset($comprobante['Conceptos'])) {
                        $conceptos = $comprobante['Conceptos'];
                        if (!is_array($conceptos)) {
                            $conceptos = [$conceptos];
                        }

                        foreach ($conceptos as $concepto) {
                            $registrosFallidos->push([
                                'folio' => $folio,
                                'descripcion' => $concepto['@attributes']['Descripcion'] ?? null,
                                'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? null
                            ]);
                        }
                    } else {
                        // Si no hay conceptos, solo agregar el folio y el nombre del emisor
                        $registrosFallidos->push([
                            'folio' => $folio,
                            'descripcion' => null,
                            'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? null
                        ]);
                    }
                    continue;
                }
            }

            // Iniciar la transacción para garantizar la integridad de los datos
            DB::connection($connection)->beginTransaction();

            try {
                // Insertar en la tabla COMPROBANTE
                $comprobanteId = DB::connection($connection)->table('COMPROBANTE')->insertGetId([
                    'Version' => $comprobante['Comprobante']['@attributes']['Version'] ?? null,
                    'Serie' => $comprobante['Comprobante']['@attributes']['Serie'] ?? null,
                    'folio' => $folio,
                    'Fecha' => $comprobante['Comprobante']['@attributes']['Fecha'] ?? null,
                    'SubTotal' => $comprobante['Comprobante']['@attributes']['SubTotal'] ?? null,
                    'Moneda' => $comprobante['Comprobante']['@attributes']['Moneda'] ?? null,
                    'Total' => $comprobante['Comprobante']['@attributes']['Total'] ?? null,
                    'TipoDeComprobante' => $comprobante['Comprobante']['@attributes']['TipoDeComprobante'] ?? null,
                    'LugarExpedicion' => $comprobante['Comprobante']['@attributes']['LugarExpedicion'] ?? null,
                    'Exportacion' => $comprobante['Comprobante']['@attributes']['Exportacion'] ?? null,
                    'NoCertificado' => $comprobante['Comprobante']['@attributes']['NoCertificado'] ?? null,
                ]);

                // Insertar en la tabla TIMBRE_FISCAL_DIGITAL (si existe y no está vacío)
                if (isset($comprobante['TimbreFiscalDigital']['@attributes']) && !empty($comprobante['TimbreFiscalDigital']['@attributes'])) {
                    DB::connection($connection)->table('TIMBRE_FISCAL_DIGITAL')->insert([
                        'version' => $comprobante['TimbreFiscalDigital']['@attributes']['Version'] ?? null,
                        'UUID' => $comprobante['TimbreFiscalDigital']['@attributes']['UUID'] ?? null,
                        'fechaTimbrado' => $comprobante['TimbreFiscalDigital']['@attributes']['FechaTimbrado'] ?? null,
                        'rfcProvCertif' => $comprobante['TimbreFiscalDigital']['@attributes']['RfcProvCertif'] ?? null,
                        'selloCFD' => $comprobante['TimbreFiscalDigital']['@attributes']['SelloCFD'] ?? null,
                        'noCertificadoSAT' => $comprobante['TimbreFiscalDigital']['@attributes']['NoCertificadoSAT'] ?? null,
                        'selloSAT' => $comprobante['TimbreFiscalDigital']['@attributes']['SelloSAT'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla EMISOR (si existe y no está vacío)
                if (isset($comprobante['Emisor']['@attributes']) && !empty($comprobante['Emisor']['@attributes'])) {
                    DB::connection($connection)->table('EMISOR')->insert([
                        'rfc_emisor' => $comprobante['Emisor']['@attributes']['Rfc'] ?? null,
                        'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? null,
                        'regimenFiscal' => $comprobante['Emisor']['@attributes']['RegimenFiscal'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla RECEPTOR (si existe y no está vacío)
                if (isset($comprobante['Receptor']['@attributes']) && !empty($comprobante['Receptor']['@attributes'])) {
                    DB::connection($connection)->table('RECEPTOR')->insert([
                        'rfc_receptor' => $comprobante['Receptor']['@attributes']['Rfc'] ?? null,
                        'nombre_receptor' => $comprobante['Receptor']['@attributes']['Nombre'] ?? null,
                        'usoCFDI' => $comprobante['Receptor']['@attributes']['UsoCFDI'] ?? null,
                        'regimenFiscalReceptor' => $comprobante['Receptor']['@attributes']['RegimenFiscalReceptor'] ?? null,
                        'domicilioFiscalReceptor' => $comprobante['Receptor']['@attributes']['DomicilioFiscalReceptor'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla CONCEPTOS (si existe y no está vacío)
                if (isset($comprobante['Conceptos'])) {
                    // Verificar si es un solo objeto o un arreglo de objetos
                    $conceptos = $comprobante['Conceptos'];
                    if (!is_array($conceptos)) {
                        // Si es un solo objeto, convertirlo en un arreglo de un solo elemento
                        $conceptos = [$conceptos];
                    }

                    // Iterar sobre cada objeto de conceptos
                    foreach ($conceptos as $concepto) {
                        DB::connection($connection)->table('CONCEPTOS')->insert([
                            'claveProdServ' => $concepto['@attributes']['ClaveProdServ'] ?? null,
                            'cantidad' => $concepto['@attributes']['Cantidad'] ?? null,
                            'claveUnidad' => $concepto['@attributes']['ClaveUnidad'] ?? null,
                            'descripcion' => $concepto['@attributes']['Descripcion'] ?? null,
                            'valorUnitario' => $concepto['@attributes']['ValorUnitario'] ?? null,
                            'importe' => $concepto['@attributes']['Importe'] ?? null,
                            'objetoImp' => $concepto['@attributes']['ObjetoImp'] ?? null,
                            'idcomprobante' => $comprobanteId,
                        ]);
                    }
                }

                // Insertar en la tabla PAGOS_PAGO (si existe y no está vacío)
                if (isset($comprobante['PagosPago']['@attributes']) && !empty($comprobante['PagosPago']['@attributes'])) {
                    DB::connection($connection)->table('PAGOS_PAGO')->insert([
                        'fechaPago' => $comprobante['PagosPago']['@attributes']['FechaPago'] ?? null,
                        'formaDePagoP' => $comprobante['PagosPago']['@attributes']['FormaDePagoP'] ?? null,
                        'monedaP' => $comprobante['PagosPago']['@attributes']['MonedaP'] ?? null,
                        'tipoCambioP' => $comprobante['PagosPago']['@attributes']['TipoCambioP'] ?? null,
                        'monto' => $comprobante['PagosPago']['@attributes']['Monto'] ?? null,
                        'numOperacion' => $comprobante['PagosPago']['@attributes']['NumOperacion'] ?? null,
                        'rfcEmisorCtaBen' => $comprobante['PagosPago']['@attributes']['RfcEmisorCtaBen'] ?? null,
                        'ctaBeneficiario' => $comprobante['PagosPago']['@attributes']['CtaBeneficiario'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla DOCTO_RELACIONADO (si existe y no está vacío)
                if (isset($comprobante['DoctoRelacionado']['@attributes']) && !empty($comprobante['DoctoRelacionado']['@attributes'])) {
                    DB::connection($connection)->table('DOCTO_RELACIONADO')->insert([
                        'idDocumento' => $comprobante['DoctoRelacionado']['@attributes']['IdDocumento'] ?? null,
                        'serie' => $comprobante['DoctoRelacionado']['@attributes']['Serie'] ?? null,
                        'folio' => $comprobante['DoctoRelacionado']['@attributes']['Folio'] ?? null,
                        'monedaDR' => $comprobante['DoctoRelacionado']['@attributes']['MonedaDR'] ?? null,
                        'equivalenciaDR' => $comprobante['DoctoRelacionado']['@attributes']['EquivalenciaDR'] ?? null,
                        'numParcialidad' => $comprobante['DoctoRelacionado']['@attributes']['NumParcialidad'] ?? null,
                        'impSaldoAnt' => $comprobante['DoctoRelacionado']['@attributes']['ImpSaldoAnt'] ?? null,
                        'impPagado' => $comprobante['DoctoRelacionado']['@attributes']['ImpPagado'] ?? null,
                        'impSaldoInsoluto' => $comprobante['DoctoRelacionado']['@attributes']['ImpSaldoInsoluto'] ?? null,
                        'objetoImpDR' => $comprobante['DoctoRelacionado']['@attributes']['ObjetoImpDR'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla DOCTO_RELACIONADO2 (si existe y no está vacío)
                if (isset($comprobante['DoctoRelacionado2']['@attributes']) && !empty($comprobante['DoctoRelacionado2']['@attributes'])) {
                    DB::connection($connection)->table('DOCTO_RELACIONADO2')->insert([
                        'idDocumento' => $comprobante['DoctoRelacionado2']['@attributes']['IdDocumento'] ?? null,
                        'serie' => $comprobante['DoctoRelacionado2']['@attributes']['Serie'] ?? null,
                        'folio' => $comprobante['DoctoRelacionado2']['@attributes']['Folio'] ?? null,
                        'monedaDR' => $comprobante['DoctoRelacionado2']['@attributes']['MonedaDR'] ?? null,
                        'equivalenciaDR' => $comprobante['DoctoRelacionado2']['@attributes']['EquivalenciaDR'] ?? null,
                        'numParcialidad' => $comprobante['DoctoRelacionado2']['@attributes']['NumParcialidad'] ?? null,
                        'impSaldoAnt' => $comprobante['DoctoRelacionado2']['@attributes']['ImpSaldoAnt'] ?? null,
                        'impPagado' => $comprobante['DoctoRelacionado2']['@attributes']['ImpPagado'] ?? null,
                        'impSaldoInsoluto' => $comprobante['DoctoRelacionado2']['@attributes']['ImpSaldoInsoluto'] ?? null,
                        'objetoImpDR' => $comprobante['DoctoRelacionado2']['@attributes']['ObjetoImpDR'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Si todo se ha insertado correctamente, confirmar la transacción
                    DB::connection($connection)->commit();

                    // Agregar el registro exitoso para cada concepto insertado
                    if (isset($comprobante['Conceptos'])) {
                        $conceptos = $comprobante['Conceptos'];
                        if (!is_array($conceptos)) {
                            $conceptos = [$conceptos];
                        }

                        foreach ($conceptos as $concepto) {
                            $registrosExitosos->push([
                                'folio' => $folio,
                                'descripcion' => $concepto['@attributes']['Descripcion'] ?? null,
                                'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? null
                            ]);
                        }
                    } else {
                        // Si no hay conceptos, agregar el folio y el nombre del emisor
                        $registrosExitosos->push([
                            'folio' => $folio,
                            'descripcion' => 'Sin conceptos disponibles',
                            'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? null
                        ]);
                    }

                } catch (\Exception $e) {
                    // Si ocurre un error, hacer rollback de la transacción
                    DB::connection($connection)->rollBack();
                    
                    // Agregar el registro fallido con el mensaje de error
                    if (isset($comprobante['Conceptos'])) {
                        $conceptos = $comprobante['Conceptos'];
                        if (!is_array($conceptos)) {
                            $conceptos = [$conceptos];
                        }
                
                        foreach ($conceptos as $concepto) {
                            $registrosFallidos->push([
                                'folio' => $folio,
                                'descripcion' => $concepto['@attributes']['Descripcion'] ?? 'Descripción no disponible',
                                'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? 'Nombre no disponible',
                                'error' => $e->getMessage() // Mensaje de error
                            ]);
                        }
                    } else {
                        // Si no hay conceptos, registrar el error con folio y nombre del emisor
                        $registrosFallidos->push([
                            'folio' => $folio,
                            'descripcion' => 'Datos del comprobante incompletos o no válidos',
                            'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? 'Nombre no disponible',
                            'error' => $e->getMessage() // Mensaje de error
                        ]);
                    }
                }
                
        }
    }
    $this->ArchivosFallados = collect($registrosFallidos);
    $this->ArchivosAceptados = collect($registrosExitosos);
    $this->showModalFacturas = true;

}
public function exportarExcelFacturas()
{
    return Excel::download(new ExcelreporteFacturascargas($this->ArchivosFallados, $this->ArchivosAceptados), 'facturas.xlsx');
}


public function exportarExcel()
{
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    $nombreEmisor = $this->proveedor;
    $estatus=$this->estatusproducto;
    $nombrereporte=$this->nombre_reporte;
    $info=DB::connection($this->connection)
            ->table('COMPROBANTE as c')
            ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
            ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
            ->Join('EMISOR as e', 'e.idcomprobante', '=', 'c.id') // Unir con EMISOR
            ->whereBetween('c.Fecha', [$startDate, $endDate])
            ->where('c.TipoDeComprobante', 'LIKE', 'I')
            ->when($nombreEmisor, function ($query) use ($nombreEmisor) {
                $query->where('e.nombre_emisor', 'LIKE',"%{$nombreEmisor}%"); // Filtro por nombre_emisor si está definido
            })
            ->when(!is_null($estatus) && $estatus !== '', function ($query) use ($estatus) {
                $query->where('c.estatus', $estatus); // Filtro por estatus si está definido
            })
            ->select(
                'c.id',
                'c.Fecha',
                DB::raw("CONCAT(c.Serie, '-', c.folio) as n_factura"),
                'conc.descripcion as combustible',
                'conc.cantidad as litros',
                'c.SubTotal',
                'c.Total',
                't.UUID as uuid',
                'c.TipoDeComprobante',
                'e.nombre_emisor',
                'c.estatus'
            )
            ->orderBy('c.Fecha', 'DESC')->get();

        $nombredoc = 'Resumen_del_' . $startDate->format('d-m-Y') . '_a_' . $endDate->format('d-m-Y') .'.xlsx';
    return Excel::download(new Excelreportepagos($info,$nombrereporte,$startDate->format('d-m-Y'),$endDate->format('d-m-Y')), $nombredoc);
}


public function abrirmodalpdf($value)
{
    $comprobante = DB::connection($this->connection)
        ->table('TIMBRE_FISCAL_DIGITAL')
        ->where('idcomprobante', $value)
        ->first();

    if (!$comprobante) {
        return response()->json(['error' => 'Comprobante no encontrado.'], 404);
    }

    // Nombre del archivo PDF basado en el UUID del comprobante
    $filenamePDF = strtoupper($comprobante->UUID);

    // Ruta principal donde buscar
    $baseDir = storage_path('app/public/facturas_extraidas');

    // Llamar a la función para buscar el archivo en el directorio y subdirectorios
    $pathPDF = $this->findFileInDirectorypdf($baseDir, $filenamePDF);

    if ($pathPDF) {
        $this->pdfPath = str_replace(storage_path('app/public'), 'storage', $pathPDF); // Ajustar la ruta para el acceso web
        $this->showModalFacturaspdf = true;
    } else {
        return response()->json(['error' => 'El archivo PDF no se encontró.'], 404);
    }
}

public function enviaraTesoreria($id){
    DB::connection($this->connection)
        ->table('COMPROBANTE')
        ->where('id', $id)
        ->update(['estatus' => 1]);
}
public function enviaraTesoreriaTodos($id,$coneccion){
    DB::connection($coneccion)
        ->table('COMPROBANTE')
        ->where('id', $id)
        ->update(['estatus' => 1]);
    $this->buscar();
}





}

