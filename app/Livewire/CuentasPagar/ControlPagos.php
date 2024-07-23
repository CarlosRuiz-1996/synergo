<?php

namespace App\Livewire\CuentasPagar;

use App\Jobs\ProcesarArchivosXml;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use App\Livewire\DescargarComprobateXmloPDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ControlPagos extends Component
{

    public DescargarComprobateXmloPDF $export;
    use WithPagination;
    public $estacionSeleccionada;
    public $fechainicio = '2024-04-01';
    public $fechafin = '2024-04-30';
    public $TipoCombustible;
    public $estacion_detalle;
    protected $detalles = [];
    public $readyToLoad = false;
    public $monto_pagado;
    public $estaciond;
    public $valor1=false;

    protected $rules = [
        'fechainicio' => 'date|before_or_equal:fechafin',
        'fechafin' => 'date|after_or_equal:fechainicio',
    ];

    protected $messages = [
        'fechainicio.before_or_equal' => 'Fecha incorrecta.',
        'fechafin.after_or_equal' => 'Fecha incorrecta.',
    ];
    public function render()
    {
        if ($this->readyToLoad) {

            $estaciones = DB::table('EstacionesExcel')->orderBy('NombreEstacion', 'ASC')->get();
            // $detalles = $this->filtrar();
           
            // $this->monto();
            if ($this->TipoCombustible == 'Pagada' || $this->TipoCombustible == 0) {

                $this->monto();
                $detalles = $this->filtrar();
            }else{
                $detalles = [];
                $this->monto_pagado=0;
                $this->total_facturas = 0;
    
            }

        } else {
           
            $estaciones =  DB::table('EstacionesExcel')->orderBy('NombreEstacion', 'ASC')->get();
            $detalles = [];
            $this->valor1=true;
        }
        return view('livewire.cuentas-pagar.control-pagos', compact('estaciones', 'detalles'));
    }
    public function loadEstaciones()
    {
        $this->readyToLoad = true;
    }
    public function buscar()
    {

        $this->validate();
        if ($this->estacionSeleccionada !='153') {
            $this->valor1=true;
            $this->estaciond = [];
            $this->estacion_detalle = [];
        }else{
            $this->valor1=false;
        $this->estaciond = DB::table('EMISOR')->first();
        $this->estacion_detalle = DB::table('EstacionesExcel')->where('IdEstacion', $this->estacionSeleccionada)->first();
        }
        
    }


    public function filtrar()
    {
        if ($this->estacionSeleccionada =='153') {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();

        //dr.impPagado
        return DB::table('COMPROBANTE as c')
        ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
        ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
        ->join('DOCTO_RELACIONADO as dr', DB::raw('CAST(dr.idDocumento AS VARCHAR(MAX))'), '=', DB::raw('CAST(t.UUID AS VARCHAR(MAX))'))
        ->whereBetween('c.Fecha', [$startDate, $endDate])
        ->where('c.TipoDeComprobante', 'LIKE', 'I')
        ->where(function ($query) {
            $query->where('conc.descripcion', 'LIKE', 'PEMEX MAGNA')
                  ->orWhere('conc.descripcion', 'LIKE', 'PEMEX PREMIUM')
                  ->orWhere('conc.descripcion', 'LIKE', 'PEMEX DIESEL');
        })
        ->select(
            'c.id',
            'c.Fecha',
            DB::raw("CONCAT(c.Serie, '-', c.folio) as n_factura"),
            'conc.descripcion as combustible',
            'conc.cantidad as litros',
            'c.SubTotal',
            'c.Total',
            't.UUID as estatus',
            'c.TipoDeComprobante'
        )
        ->orderBy('c.Fecha', 'DESC')
        ->paginate(10);
    }else{
        $this->valor1=true;
       return [];
    }
}
    public $total_facturas;
    public function monto()
    {
        if ($this->estacionSeleccionada =='153') {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
        $this->monto_pagado = DB::table('COMPROBANTE as c')
        ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
        ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
        ->join('DOCTO_RELACIONADO as dr', DB::raw('CAST(dr.idDocumento AS NVARCHAR(MAX))'), '=', DB::raw('CAST(t.UUID AS NVARCHAR(MAX))'))
        ->whereBetween('c.Fecha', [$startDate, $endDate])
        ->where('c.TipoDeComprobante', 'LIKE', 'I')
        ->where(function ($query) {
            $query->where('conc.descripcion', 'LIKE', 'PEMEX MAGNA')
                  ->orWhere('conc.descripcion', 'LIKE', 'PEMEX PREMIUM')
                  ->orWhere('conc.descripcion', 'LIKE', 'PEMEX DIESEL');
        })
        ->sum('c.Total');
    
    $this->total_facturas = DB::table('COMPROBANTE as c')
        ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
        ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
        ->join('DOCTO_RELACIONADO as dr', DB::raw('CAST(dr.idDocumento AS NVARCHAR(MAX))'), '=', DB::raw('CAST(t.UUID AS NVARCHAR(MAX))'))
        ->whereBetween('c.Fecha', [$startDate, $endDate])
        ->where('c.TipoDeComprobante', 'LIKE', 'I')
        ->where(function ($query) {
            $query->where('conc.descripcion', 'LIKE', 'PEMEX MAGNA')
                  ->orWhere('conc.descripcion', 'LIKE', 'PEMEX PREMIUM')
                  ->orWhere('conc.descripcion', 'LIKE', 'PEMEX DIESEL');
        })
        ->count();
        $this->valor1=false;
        }else{
            $this->total_facturas=0;
            $this->monto_pagado=0;
            $this->valor1=true;
        }
    
    }

    public $isOpen = false;
    public $pdfUrl;
    public function mostrarPdf($pdfPath)
    {
        $this->pdfUrl = $pdfPath;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->pdfUrl = null;
    }


    //xml

    public function descargarXML($id)
    {

        $comprobante = DB::table('TIMBRE_FISCAL_DIGITAL')
            ->where('idcomprobante', $id) // Aquí reemplaza 'id' por el campo que quieras filtrar y $id por el valor deseado
            ->first();

        $files = [];

        $filenameXML = strtoupper($comprobante->UUID) . '@1000000000XX0.xml';

        $pathXML = storage_path('app/archivos_descomprimidos/' . $filenameXML);
        if (file_exists($pathXML)) {
            $files[] = $pathXML;
        }

        if (count($files) === 1) {
            return response()->download($files[0]);
        } else {
            return response()->json(['error' => 'No files selected or files do not exist.'], 404);
        }
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
    public function procesarArchivos(Request $request)
    {
        // Validar el archivo ZIP
        $request->validate([
            'archivo_zip' => 'required|mimes:zip|max:10240', // Max 10MB
        ]);
    
        // Guardar el archivo ZIP en el servidor
        $archivoZip = $request->file('archivo_zip');
        $rutaArchivoZip = $archivoZip->store('archivos');
    
        // Verificar si se guardó correctamente el archivo ZIP
        if ($rutaArchivoZip) {
            $rutaAbsolutaArchivoZip = Storage::disk('local')->path($rutaArchivoZip);

            // Asignar permisos de lectura y escritura al archivo
            chmod($rutaAbsolutaArchivoZip, 0644);
            // Encolar el trabajo para procesar los archivos XML
            ProcesarArchivosXml::dispatch($rutaArchivoZip);
    
            // Redireccionar con un mensaje de éxito
            return redirect()->back()->with('success', 'El archivo ZIP se ha cargado correctamente y está encolado para procesamiento.');
        } else {
            // En caso de que ocurra un error al guardar el archivo ZIP
            return redirect()->back()->with('error', 'Hubo un problema al cargar el archivo ZIP. Por favor, inténtalo de nuevo.');
        }
    }   
    
    public function insertarBase()
{
    if (!Storage::disk('public')->exists('datos.json')) {
        abort(404, 'El archivo JSON no existe.');
    }

    // Obtener el contenido del archivo JSON
    $contenidoJson = Storage::disk('public')->get('datos.json');

    // Decodificar el JSON a un array asociativo de PHP
    $datos = json_decode($contenidoJson, true);

    foreach ($datos as $comprobante) {
        // Verificar si el objeto COMPROBANTE está presente y tiene atributos
        if (isset($comprobante['Comprobante']['@attributes']) && !empty($comprobante['Comprobante']['@attributes'])) {
            $folio = $comprobante['Comprobante']['@attributes']['Folio'] ?? null;

            // Verificar si el folio ya existe en la base de datos
            if ($folio) {
                $exists = DB::table('COMPROBANTE')->where('folio', $folio)->exists();
            
                if ($exists) {
                    // Si el folio ya existe, continuar con el siguiente registro
                    continue;
                }
            }

            // Iniciar la transacción para garantizar la integridad de los datos
            DB::beginTransaction();

            try {
                // Insertar en la tabla COMPROBANTE
                $comprobanteId = DB::table('COMPROBANTE')->insertGetId([
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

                // Insertar en la tabla EMISOR (si existe y no está vacío)
                if (isset($comprobante['Emisor']['@attributes']) && !empty($comprobante['Emisor']['@attributes'])) {
                    DB::table('EMISOR')->insert([
                        'rfc_emisor' => $comprobante['Emisor']['@attributes']['Rfc'] ?? null,
                        'nombre_emisor' => $comprobante['Emisor']['@attributes']['Nombre'] ?? null,
                        'regimenFiscal' => $comprobante['Emisor']['@attributes']['RegimenFiscal'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla RECEPTOR (si existe y no está vacío)
                if (isset($comprobante['Receptor']['@attributes']) && !empty($comprobante['Receptor']['@attributes'])) {
                    DB::table('RECEPTOR')->insert([
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
                        DB::table('CONCEPTOS')->insert([
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
                    DB::table('PAGOS_PAGO')->insert([
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
                    DB::table('DOCTO_RELACIONADO')->insert([
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
                    DB::table('DOCTO_RELACIONADO2')->insert([
                        'baseDR' => $comprobante['DoctoRelacionado2']['@attributes']['BaseDR'] ?? null,
                        'impuestoDR' => $comprobante['DoctoRelacionado2']['@attributes']['ImpuestoDR'] ?? null,
                        'tipoFactorDR' => $comprobante['DoctoRelacionado2']['@attributes']['TipoFactorDR'] ?? null,
                        'tasaOCuotaDR' => $comprobante['DoctoRelacionado2']['@attributes']['TasaOCuotaDR'] ?? null,
                        'importeDR' => $comprobante['DoctoRelacionado2']['@attributes']['ImporteDR'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Insertar en la tabla IMPUESTOS_P (si existe y no está vacío)
                if (isset($comprobante['ImpuestosP']['@attributes']) && !empty($comprobante['ImpuestosP']['@attributes'])) {
                    DB::table('IMPUESTOS_P')->insert([
                        'totalImpuestosRetenidos' => $comprobante['ImpuestosP']['@attributes']['TotalImpuestosRetenidos'] ?? null,
                        'totalImpuestosTrasladados' => $comprobante['ImpuestosP']['@attributes']['TotalImpuestosTrasladados'] ?? null,
                        'idcomprobante' => $comprobanteId,
                    ]);
                }

                // Confirmar la transacción
                DB::commit();
            } catch (\Exception $e) {
                // Revertir la transacción en caso de error
                DB::rollBack();
                // Manejar el error según sea necesario
            }
        }
    }
}

}
