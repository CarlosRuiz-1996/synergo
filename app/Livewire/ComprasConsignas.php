<?php

namespace App\Livewire;

use App\Exports\ComprasConsignas as ExportsComprasConsignas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ComprasConsignas extends Component
{

    use WithPagination;
    public $fechainicio;
    public $fechafin;
    public function render()
    {
         // Obtiene las fechas de inicio y fin de los filtros del formulario o valores predeterminados
         $despachos=$this->buscar();
         // Retorna la vista con los resultados de la consulta
         return view('livewire.compras-consignas', compact('despachos'));
    }
    public function buscar(){
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
        // Realiza la consulta a la base de datos utilizando los filtros
        return $despachos = DB::table('comgasolina')
        ->join('CatTanques', 'CatTanques.NuTanque', '=', 'comgasolina.NuTanque')
        ->join('CatCombustibles', 'CatCombustibles.NuCombustible', '=', 'CatTanques.NuCombustible')
        ->select('comgasolina.NuRec', 'comgasolina.Fecha', 'comgasolina.NuFactura', 'comgasolina.NuTanque', 'comgasolina.Cantidad', 'comgasolina.Importe', 'CatCombustibles.Descripcion')
        ->where('comgasolina.NuCamion', '1111')
        ->whereBetween('comgasolina.Fecha', [$startDate->toDateString(), $endDate->toDateString()])
        ->orderBy('comgasolina.Fecha', 'asc')
        ->paginate(10);
                       
    
    }
    public function exportarExcel()
    {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
        // Realiza la consulta a la base de datos utilizando los filtros
        $despachos =  DB::table('comgasolina')
        ->join('CatTanques', 'CatTanques.NuTanque', '=', 'comgasolina.NuTanque')
        ->join('CatCombustibles', 'CatCombustibles.NuCombustible', '=', 'CatTanques.NuCombustible')
        ->select('comgasolina.NuRec', 'comgasolina.Fecha', 'comgasolina.NuFactura', 'comgasolina.NuTanque', 'comgasolina.Cantidad', 'comgasolina.Importe', 'CatCombustibles.Descripcion')
        ->where('comgasolina.NuCamion', '1111')
        ->whereBetween('comgasolina.Fecha', [$startDate->toDateString(), $endDate->toDateString()])
        ->orderBy('comgasolina.Fecha', 'asc')
        ->get();

        return Excel::download(new ExportsComprasConsignas($despachos, $startDate->toDateString(), $endDate->toDateString()), 'ComprasConsignacion.xlsx');
                        
    }
    public function exportarTxt()
    {
        // Verificar si el archivo JSON existe
        if (!Storage::disk('public')->exists('datos.json')) {
            abort(404, 'El archivo JSON no existe.');
        }
    
        // Obtener el contenido del archivo JSON
        $contenidoJson = Storage::disk('public')->get('datos.json');
        $data = json_decode($contenidoJson, true);
    
        // Función anónima para comparar fechas y ordenar por FechaTimbrado
        usort($data, function($a, $b) {
            $fechaA = isset($a['PagosPago']['@attributes']['FechaPago']) ? strtotime($a['PagosPago']['@attributes']['FechaPago']) : strtotime($a['TimbreFiscalDigital']['@attributes']['FechaTimbrado']);
            $fechaB = isset($b['PagosPago']['@attributes']['FechaPago']) ? strtotime($b['PagosPago']['@attributes']['FechaPago']) : strtotime($b['TimbreFiscalDigital']['@attributes']['FechaTimbrado']);
            return $fechaA <=> $fechaB;
        });
    
        // Inicializar arrays para almacenar cantidades y fechas
        $premiumData = [];
        $dieselData = [];
        $magnaData = [];
    
        // Recorrer los conceptos y sumar los importes según la descripción y la unidad
        foreach ($data as $elemento) {
            // Validar que el receptor sea "GASOLINERIA DEL FUTURO"
            if (isset($elemento['Receptor']['@attributes']) &&
                $elemento['Receptor']['@attributes']['Nombre'] === 'GASOLINERIA DEL FUTURO') {
    
                if (isset($elemento['Conceptos']['@attributes'])) {
                    $concepto = $elemento['Conceptos']['@attributes'];
                    $descripcion = $concepto['Descripcion'];
                    $unidad = $concepto['ClaveUnidad'];
                    $cantidad = floatval($concepto['Cantidad']);
                    $fecha = isset($elemento['PagosPago']['@attributes']['FechaPago']) ? $elemento['PagosPago']['@attributes']['FechaPago'] : $elemento['TimbreFiscalDigital']['@attributes']['FechaTimbrado'];
    
                    if ($unidad === 'LTR') {
                        switch ($descripcion) {
                            case 'PEMEX PREMIUM':
                                $premiumData[] = ['cantidad' => $cantidad, 'fecha' => $fecha];
                                break;
                            case 'PEMEX DIESEL':
                                $dieselData[] = ['cantidad' => $cantidad, 'fecha' => $fecha];
                                break;
                            case 'PEMEX MAGNA':
                                $magnaData[] = ['cantidad' => $cantidad, 'fecha' => $fecha];
                                break;
                            default:
                                // No hacer nada si la descripción no coincide con las esperadas
                                break;
                        }
                    }
                }
            }
        }
    
        // Generar el contenido del archivo TXT con los totales por descripción
        $contenido = "Total de ventas consigna (Unidad: LTR):\n";
    
        $contenido .= "PEMEX PREMIUM:\n";
        foreach ($premiumData as $data) {
            $contenido .= "Cantidad: {$data['cantidad']}, Fecha: {$data['fecha']}\n";
        }
        $contenido .= "Total: " . array_sum(array_column($premiumData, 'cantidad')) . "\n\n";
    
        $contenido .= "PEMEX DIESEL:\n";
        foreach ($dieselData as $data) {
            $contenido .= "Cantidad: {$data['cantidad']}, Fecha: {$data['fecha']}\n";
        }
        $contenido .= "Total: " . array_sum(array_column($dieselData, 'cantidad')) . "\n\n";
    
        $contenido .= "PEMEX MAGNA:\n";
        foreach ($magnaData as $data) {
            $contenido .= "Cantidad: {$data['cantidad']}, Fecha: {$data['fecha']}\n";
        }
        $contenido .= "Total: " . array_sum(array_column($magnaData, 'cantidad')) . "\n\n";
    
        // Descargar el archivo TXT
        $fileName = 'total_ventas_por_producto.txt';
        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];
    
        return response()->streamDownload(function () use ($contenido) {
            echo $contenido;
        }, $fileName, $headers);
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
    
                // Iniciar la transacción para garantizar la integridad de los datos
                DB::beginTransaction();
    
                try {
                    // Insertar en la tabla COMPROBANTE
                    $fechaISO8601 = $comprobante['Comprobante']['@attributes']['Fecha'] ?? null;

                    // Parsear la fecha ISO 8601 utilizando Carbon
                    $fechaCarbon = $fechaISO8601 ? Carbon::parse($fechaISO8601) : null;
                    
                    // Obtener la fecha formateada en Y-m-d H:i:s
                    $fechaFormateada = $fechaCarbon ? $fechaCarbon->format('Y-m-d H:i:s') : null;
                    
                    // Insertar en la base de datos y obtener el ID insertado
                    $comprobanteId = DB::table('COMPROBANTE')->insertGetId([
                        'Version' => $comprobante['Comprobante']['@attributes']['Version'] ?? null,
                        'Serie' => $comprobante['Comprobante']['@attributes']['Serie'] ?? null,
                        'folio' => $comprobante['Comprobante']['@attributes']['Folio'] ?? null,
                        'Fecha' => $fechaFormateada, // Aquí se guarda la fecha formateada
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
                            'baseP' => $comprobante['ImpuestosP']['@attributes']['BaseP'] ?? null,
                            'importeP' => $comprobante['ImpuestosP']['@attributes']['ImporteP'] ?? null,
                            'impuestoP' => $comprobante['ImpuestosP']['@attributes']['ImpuestoP'] ?? null,
                            'tasaOCuotaP' => $comprobante['ImpuestosP']['@attributes']['TasaOCuotaP'] ?? null,
                            'tipoFactorP' => $comprobante['ImpuestosP']['@attributes']['TipoFactorP'] ?? null,
                            'idcomprobante' => $comprobanteId,
                        ]);
                    }
    
                    // Insertar en la tabla TOTALES (si existe y no está vacío)
                    if (isset($comprobante['Totales']['@attributes']) && !empty($comprobante['Totales']['@attributes'])) {
                        DB::table('TOTALES')->insert([
                            'totalTrasladosBaseIVA16' => $comprobante['Totales']['@attributes']['TotalTrasladosBaseIVA16'] ?? null,
                            'totalTrasladosImpuestoIVA16' => $comprobante['Totales']['@attributes']['TotalTrasladosImpuestoIVA16'] ?? null,
                            'montoTotalPagos' => $comprobante['Totales']['@attributes']['MontoTotalPagos'] ?? null,
                            'idcomprobante' => $comprobanteId,
                        ]);
                    }
    
                    // Insertar en la tabla TIMBRE_FISCAL_DIGITAL (si existe y no está vacío)
                    if (isset($comprobante['TimbreFiscalDigital']['@attributes']) && !empty($comprobante['TimbreFiscalDigital']['@attributes'])) {
                        DB::table('TIMBRE_FISCAL_DIGITAL')->insert([
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
    
                    // Confirmar la transacción
                    DB::commit();
                } catch (\Exception $e) {
                    // En caso de error, deshacer la transacción
                    DB::rollback();
                    throw $e;
                }
            } else {
                // Si el objeto COMPROBANTE está vacío o no tiene atributos, continuar con el siguiente registro
                continue;
            }
        }
    }
    

}
