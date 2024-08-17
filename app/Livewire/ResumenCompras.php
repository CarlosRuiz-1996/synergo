<?php

namespace App\Livewire;

use App\Exports\ExportResumenCompras;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ResumenCompras extends Component
{
use WithPagination;
public $fechainicio='2024-04-01';
public $fechafin='2024-04-30';
public $TipoCombustible;
public $totalesValores;
public $reportesSeleccion=0;
public $EstacionSeleccionada="";
public $valorParaPasar=0;
public $showModal = false;
public $showModal2 = false;
public $showModal3 = false;
public $showModalventaConsigna= false;
public $showModalventaConsigna2= false;
public $showModalventaConsigna3= false;
public $showModalInventarioCombustible=false;
public $showModalInventarioCombustibletotal = false; 
public $showModalInventarioCombustibleconsigna = false; 
public $showModalResumen = false;
public $novisible=false;

//variables de tabla
public $datos;
public $fechaInicio;
public $fechaFin;
public $invInicial;
public $ventas;
public $CostoPromedio;
public $nombreProducto;


public function abrirModal($valor)
{
    if($valor==1){
        $this->showModal = true; 
    }elseif($valor==3){
        $this->showModal2 = true;  
    }elseif($valor==2){
        $this->showModal3 = true; 
    }else{
        $this->showModal = false; 
        $this->showModal2 = false; 
        $this->showModal3 = false;  
    }
   
}
public function abrirModalResumen($valor)
{
        $this->fechainicio='2024-04-01';
        $this->fechafin='2024-04-30';
        $this->showModalResumen = true; 
}


public function abrirModalVentasConsignas($valor)
{
    if($valor==1){
        $this->showModalventaConsigna = true; 
    }elseif($valor==3){
        $this->showModalventaConsigna2 = true;  
    }elseif($valor==2){
        $this->showModalventaConsigna3 = true; 
    }else{
        $this->showModalventaConsigna = false; 
        $this->showModalventaConsigna2 = false; 
        $this->showModalventaConsigna3 = false;  
    }
   
}

public function abrirmodalInventarioCom($valor){
    $this->showModalInventarioCombustible = true;  
}
public function abrirModaltotal($valor){
    $this->showModalInventarioCombustibletotal = true;  
}
public function abrirModaltotalCon($valor){
    $this->showModalInventarioCombustibleconsigna = true;  
}




public function render()
{
    $estaciones=DB::table('EstacionesExcel')->get();
    $despachos=$this->buscar();
    $ventas=$this->ventasResumen();
    if($this->TipoCombustible=='PEMEX MAGNA'){
        $this->reportesSeleccion=1;   
    }elseif($this->TipoCombustible=='PEMEX DIESEL'){
        $this->reportesSeleccion=3;   
    }elseif($this->TipoCombustible=='PEMEX PREMIUM'){
        $this->reportesSeleccion=2;   
    }else{
        $this->reportesSeleccion=0;   
    }
    $this->totalesValores=$this->totales();
    

    return view('livewire.resumen-compras', compact('despachos','ventas','estaciones'),[
        'databaseMessages' => session('database_messages', []),
    ]);
    //return view('livewire.resumen-compras');
}

public function buscar()
{

    // 143 ecue
    // 141 coral
    // Verifica la estación seleccionada
    if ($this->EstacionSeleccionada == "" ) {
        return null;
    }
    switch ($this->EstacionSeleccionada) {
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
            return null; // Si no es ninguna de las estaciones, retorna null
    }

    // Establece las fechas de inicio y fin
    $combustible = !empty($this->TipoCombustible) ? (array)$this->TipoCombustible : ['PEMEX MAGNA', 'PEMEX DIESEL', 'PEMEX PREMIUM'];
    $fechareal = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();

    // Obtiene la fecha un día antes de startDate
    $startDate = $fechareal->copy()->subDay();

    $nuCombustibles = [];
    $CostoPromedio = 0.0;
    $nombreProducto = "";
    foreach ($combustible as $tipo) {
        switch ($tipo) {
            case 'PEMEX MAGNA':
                $nuCombustibles[] = 1;
                $CostoPromedio = 16.801917;
                $nombreProducto = 'PEMEX MAGNA';
                break;
            case 'PEMEX PREMIUM':
                $nuCombustibles[] = 2;
                $nombreProducto = 'PEMEX PREMIUM';
                $CostoPromedio = 19.920347;
                break;
            case 'PEMEX DIESEL':
                $nuCombustibles[] = 3;
                $CostoPromedio = 18.412003;
                $nombreProducto = 'PEMEX DIESEL';
                break;
        }
    }

    $despachos = DB::connection($connection)->table('COMPROBANTE as comp')
    ->select(
        'comp.id AS comp_id',
        DB::raw("CASE 
                    WHEN CAST(comp.Fecha AS DATE) = '2024-03-31' THEN CAST('2024-04-01' AS DATE)
                    ELSE CAST(comp.Fecha AS DATE)
                END AS Fecha"),
        'concPE.idcomprobante',
        'concPE.valorUnitario',
        'concPE.cantidad',
        'concPE.descripcion',
        DB::raw('(concSI.valorUnitario / concPE.cantidad) AS FLETE_SERVICIO'),
        DB::raw('ROUND(((concPE.valorUnitario + (concSI.valorUnitario / concPE.cantidad)) * concPE.cantidad), 2) AS TOTAL_CON_FLETE'),
        DB::raw('ISNULL(cp.ComprasCantidad, 0) AS ComprasCantidad'),
        DB::raw("(SELECT TOP 1 c.NuFactura 
                  FROM ComGasolina c 
                  WHERE CAST(c.Fecha AS DATE) = CASE 
                                                WHEN CAST(comp.Fecha AS DATE) = '2024-03-31' THEN '2024-04-01'
                                                ELSE CAST(comp.Fecha AS DATE)
                                              END
                  AND c.Cantidad = concPE.cantidad
                 ) AS NuFactura")
    )
    ->join('CONCEPTOS as concPE', 'concPE.idcomprobante', '=', 'comp.id')
    ->leftJoin('CONCEPTOS as concSI', function ($join) {
        $join->on('concSI.idcomprobante', '=', 'comp.id')
            ->whereRaw("CAST(concSI.descripcion AS nvarchar(max)) = 'Servicio de intermediacion de productos'");
    })
    ->leftJoin(DB::raw("(SELECT 
                            cc.Fecha,
                            c.NuFactura,
                            cc.NuFactura AS NuFacturaAjustada,
                            c.Cantidad,
                            ISNULL(cc.Cantidad, 0) AS ComprasCantidad,
                            c.NuCamion
                        FROM ComGasolina cc
                        INNER JOIN ComGasolina c ON 
                            LEFT(CAST(cc.NuFactura AS nvarchar(max)), 
                                 CASE 
                                    WHEN LEN(CAST(cc.NuFactura AS nvarchar(max))) > 2 THEN 
                                        LEN(CAST(cc.NuFactura AS nvarchar(max))) - 2 
                                    ELSE 
                                        0 
                                 END) = CAST(c.NuFactura AS nvarchar(max))
                            AND c.NuTanque IN ('" . implode("','", $nuCombustibles) . "')
                            AND cc.NuCamion = '1111'
                        ) AS cp"), function ($join) {
        $join->on(DB::raw("CASE 
                                WHEN cp.NuCamion = '1111' AND CAST(cp.Fecha AS DATE) = '2024-03-31' THEN CAST('2024-04-01' AS DATE)
                                WHEN cp.NuCamion = '1111' THEN CAST(cp.Fecha AS DATE)
                                ELSE CAST(cp.Fecha AS DATE)
                            END"), '=', DB::raw("CASE 
                                                    WHEN CAST(comp.Fecha AS DATE) = '2024-03-31' THEN CAST('2024-04-01' AS DATE)
                                                    ELSE CAST(comp.Fecha AS DATE)
                                                END"))
             ->on('cp.Cantidad', '=', 'concPE.cantidad');
    })
    ->leftJoin(DB::raw("(SELECT 
                            comp.id AS comp_id,
                            CAST(comp.Fecha AS DATE) AS Fecha,
                            concPE.idcomprobante,
                            concPE.valorUnitario,
                            concPE.cantidad,
                            ROW_NUMBER() OVER(PARTITION BY CAST(comp.Fecha AS DATE) ORDER BY comp.Fecha) AS RowNumber
                        FROM COMPROBANTE AS comp
                        INNER JOIN CONCEPTOS AS concPE ON concPE.idcomprobante = comp.id
                        WHERE CAST(concPE.descripcion AS nvarchar(max)) IN ('" . implode("','", $combustible) . "')
                          AND comp.Fecha >= '2024-03-31' AND comp.Fecha <= '2024-05-01'
                        ) AS CompConRowNumber"), function ($join) {
        $join->on('CompConRowNumber.comp_id', '=', 'comp.id');
    })
    ->whereRaw("CAST(concPE.descripcion AS nvarchar(max)) IN ('" . implode("','", $combustible) . "')")
    ->whereBetween('comp.Fecha', [$startDate, $endDate])
    ->orderBy('comp.Fecha')
    ->orderBy('concPE.idcomprobante')
    ->get();

    $ventas = DB::connection($connection)->table('ERGVentasGasolina_View as er')
        ->join('CatCombustibles as ct', 'ct.NuCombustible', '=', 'er.NuCombustible')
        ->select('er.*', 'ct.Descripcion')
        ->whereBetween('er.Fecha', ['2024-04-01', $endDate])
        ->whereIn('er.NuCombustible', $nuCombustibles)
        ->orderByRaw("er.Fecha ASC")
        ->get();

    $results = null;

    if ($fechareal->day == 1 && $endDate->day == $endDate->daysInMonth) {
        // Consulta a ERInventarioCombustibleReglaxEStablaVentas_View cuando es el primer y último día del mes
        $results = DB::connection($connection)->table('ERInventarioCombustibleReglaxEStablaVentas_View')
            ->whereIn('NuCombustible', $nuCombustibles)
            ->whereBetween('Fecha', ['2024-04-01', $endDate->toDateTimeString()])
            ->first();
    } else {
        // Obtiene el valor de litros del día anterior al primer día del mes seleccionado
        $litrosAnterior = DB::connection($connection)->table('ERCalculaRegla_View')
            ->select('Litros')
            ->whereDate('Fecha', $startDate->toDateString())
            ->whereIn('NuCombustible', $nuCombustibles)
            ->first();

        // Asigna los valores de inv_inicial e inv_final
        if ($litrosAnterior) {
            $results = (object) [
                'Inv_Inicial' => $litrosAnterior->Litros,
                'Inv_Final' => 0
            ];
        }
    }

    // Verificar si alguna de las variables es null
    if (is_null($results) || $ventas->isEmpty() || $despachos->isEmpty()) {
        $this->novisible=false;
        Session::flash('error', 'Ingrese el Primer dia y el ultimo dia del mes.');
        return redirect()->back();
    } else {
        $this->novisible=true;
        $this->datos = $despachos;
        $this->fechaInicio = $fechareal;
        $this->fechaFin = $endDate->toDateString();
        $this->invInicial = $results;
        $this->ventas = $ventas;
        $this->CostoPromedio = $CostoPromedio;
        $this->nombreProducto = $nombreProducto;
    }
}




public function buscarInventarioInicial(){
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
   return $results = DB::table('ERInventarioCombustibleReglaxEStablaVentas_View')->whereBetween('Fecha', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])->where('NuCombustible',1)->get();
}
public function exportarExcel()
{
    $combustible = !empty($this->TipoCombustible) ? (array)$this->TipoCombustible : ['PEMEX MAGNA', 'PEMEX DIESEL', 'PEMEX PREMIUM'];  
    $fechareal = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    // Obtiene la fecha un día antes de startDate
    $startDate = $fechareal->copy()->subDay();
    $nuCombustibles = [];
    $CostoPromedio =0.0;
    $nombreProducto ="";
    foreach ($combustible as $tipo) {
        switch ($tipo) {
            case 'PEMEX MAGNA':
                $nuCombustibles[] = 1;
                $CostoPromedio =16.801917;
                $nombreProducto ='PEMEX MAGNA';
                break;
            case 'PEMEX PREMIUM':
                $nuCombustibles[] = 2;
                $nombreProducto ='PEMEX PREMIUM';
                $CostoPromedio =19.920347;
                break;
            case 'PEMEX DIESEL':
                $nuCombustibles[] = 3;
                $CostoPromedio =18.412003;
                $nombreProducto='PEMEX DIESEL';
                break;
            // Agregar más casos según sea necesario
        }
    }
    $despachos = DB::table('COMPROBANTE as comp')
    ->select(
        'comp.id AS comp_id',
        DB::raw("CASE 
                    WHEN CAST(comp.Fecha AS DATE) = '2024-03-31' THEN CAST('2024-04-01' AS DATE)
                    ELSE CAST(comp.Fecha AS DATE)
                END AS Fecha"),
        'concPE.idcomprobante',
        'concPE.valorUnitario',
        'concPE.cantidad',
        'concPE.descripcion',
        DB::raw('(concSI.valorUnitario / concPE.cantidad) AS FLETE_SERVICIO'),
        DB::raw('ROUND(((concPE.valorUnitario + (concSI.valorUnitario / concPE.cantidad)) * concPE.cantidad), 2) AS TOTAL_CON_FLETE'),
        DB::raw('ISNULL(cp.ComprasCantidad, 0) AS ComprasCantidad'),
        DB::raw("(SELECT TOP 1 c.NuFactura 
                  FROM ComGasolina c 
                  WHERE CAST(c.Fecha AS DATE) = CASE 
                                                WHEN CAST(comp.Fecha AS DATE) = '2024-03-31' THEN '2024-04-01'
                                                ELSE CAST(comp.Fecha AS DATE)
                                              END
                  AND c.Cantidad = concPE.cantidad
                 ) AS NuFactura")
    )
    ->join('CONCEPTOS as concPE', 'concPE.idcomprobante', '=', 'comp.id')
    ->leftJoin('CONCEPTOS as concSI', function ($join) {
        $join->on('concSI.idcomprobante', '=', 'comp.id')
            ->whereRaw("CAST(concSI.descripcion AS nvarchar(max)) = 'Servicio de intermediacion de productos'");
    })
    ->leftJoin(DB::raw("(SELECT 
                            cc.Fecha,
                            c.NuFactura,
                            cc.NuFactura AS NuFacturaAjustada,
                            c.Cantidad,
                            ISNULL(cc.Cantidad, 0) AS ComprasCantidad,
                            c.NuCamion
                        FROM ComGasolina cc
                        INNER JOIN ComGasolina c ON 
                            LEFT(CAST(cc.NuFactura AS nvarchar(max)), LEN(CAST(cc.NuFactura AS nvarchar(max))) - 2) = CAST(c.NuFactura AS nvarchar(max))
                             AND c.NuTanque IN ('" . implode("','", $nuCombustibles) . "')
                            AND cc.NuCamion = '1111'
                        ) AS cp"), function ($join) {
        $join->on(DB::raw("CASE 
                                WHEN cp.NuCamion = '1111' AND CAST(cp.Fecha AS DATE) = '2024-03-31' THEN CAST('2024-04-01' AS DATE)
                                WHEN cp.NuCamion = '1111' THEN CAST(cp.Fecha AS DATE)
                                ELSE CAST(cp.Fecha AS DATE)
                            END"), '=', DB::raw("CASE 
                                                    WHEN CAST(comp.Fecha AS DATE) = '2024-03-31' THEN CAST('2024-04-01' AS DATE)
                                                    ELSE CAST(comp.Fecha AS DATE)
                                                END"))
             ->on('cp.Cantidad', '=', 'concPE.cantidad');
    })
    ->leftJoin(DB::raw("(SELECT 
                            comp.id AS comp_id,
                            CAST(comp.Fecha AS DATE) AS Fecha,
                            concPE.idcomprobante,
                            concPE.valorUnitario,
                            concPE.cantidad,
                            ROW_NUMBER() OVER(PARTITION BY CAST(comp.Fecha AS DATE) ORDER BY comp.Fecha) AS RowNumber
                        FROM COMPROBANTE AS comp
                        INNER JOIN CONCEPTOS AS concPE ON concPE.idcomprobante = comp.id
                        WHERE CAST(concPE.descripcion AS nvarchar(max)) IN ('" . implode("','", $combustible) . "')
                          AND comp.Fecha >= '2024-03-31' AND comp.Fecha <= '2024-05-01'
                        ) AS CompConRowNumber"), function ($join) {
        $join->on('CompConRowNumber.comp_id', '=', 'comp.id');
    })
    ->whereRaw("CAST(concPE.descripcion AS nvarchar(max)) IN ('" . implode("','", $combustible) . "')")
    ->whereBetween('comp.Fecha', [$startDate, $endDate])
    ->orderBy('comp.Fecha')
    ->orderBy('concPE.idcomprobante')
    ->get();
//dd($despachos);



        $ventas = DB::table('ERGVentasGasolina_View as er')
        ->join('CatCombustibles as ct', 'ct.NuCombustible', '=', 'er.NuCombustible')
        ->select('er.*', 'ct.Descripcion')
        ->whereBetween('er.Fecha', ['2024-04-01', $endDate])
        ->whereIn('er.NuCombustible', $nuCombustibles)
        ->orderByRaw("er.Fecha ASC")
        ->get();

        if ($fechareal->day == 1 && $endDate->day == $endDate->daysInMonth) {
            // Consulta a ERInventarioCombustibleReglaxEStablaVentas_View cuando es el primer y último día del mes
            $results = DB::table('ERInventarioCombustibleReglaxEStablaVentas_View')
                ->whereIn('NuCombustible', $nuCombustibles)
                ->whereBetween('Fecha', ['2024-04-01', $endDate->toDateTimeString()])
                ->first();
        } else {
            // Obtiene el valor de litros del día anterior al primer día del mes seleccionado
            $litrosAnterior = DB::table('ERCalculaRegla_View')
                ->select('Litros')
                ->whereDate('Fecha', $startDate->toDateString())
                ->whereIn('NuCombustible', $nuCombustibles)
                ->first();
    
            // Asigna los valores de inv_inicial e inv_final
            if ($litrosAnterior) {
                $results = (object) [
                    'Inv_Inicial' => $litrosAnterior->Litros,
                    'Inv_Final' => 0
                ];
            }
        }

         // Verificar si alguna de las variables es null
        if ($despachos->isEmpty() || $ventas->isEmpty() || is_null($results)) {
            Session::flash('error', 'Ingrese el Primer dia y el ultimo dia del mes.');
            return redirect()->back();
        }

        $nombredoc = 'Resumen_del_' . $startDate->format('d-m-Y') . '_a_' . $endDate->format('d-m-Y') .'_'. $nombreProducto.''. '.xlsx';
    return Excel::download(new ExportResumenCompras($despachos, $fechareal, $endDate->toDateString(), $results,$ventas,$CostoPromedio,$nombreProducto), $nombredoc);
}


public function ventasResumen() {
    if($this->EstacionSeleccionada=="" ||  $this->EstacionSeleccionada != 153){
        return null;
    }else{
    // Define combustible types or use provided ones
    $combustible = !empty($this->TipoCombustible) ? (array)$this->TipoCombustible : ['PEMEX MAGNA', 'PEMEX DIESEL', 'PEMEX PREMIUM'];
    
    // Define start and end dates
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
    // Map fuel types to numeric codes
    $nuCombustibles = [];
    foreach ($combustible as $tipo) {
        switch ($tipo) {
            case 'PEMEX MAGNA':
                $nuCombustibles[] = 1;
                break;
            case 'PEMEX PREMIUM':
                $nuCombustibles[] = 2;
                break;
            case 'PEMEX DIESEL':
                $nuCombustibles[] = 3;
                break;
            // Add more cases as necessary
        }
    }

    // Perform the query
    $results = DB::table('ERGVentasGasolina_View as er')
        ->join('CatCombustibles as ct', 'ct.NuCombustible', '=', 'er.NuCombustible')
        ->select('er.*', 'ct.Descripcion')
        ->whereBetween('er.Fecha', [$startDate, $endDate])
        ->whereIn('er.NuCombustible', $nuCombustibles)
        ->orderByRaw("er.Fecha ASC")
        ->paginate(10);
        
    return $results;
}
}

public function totales()
{
    $fechareal = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    $startDate = $fechareal->copy()->subDay();

    // Definir las conexiones
    $connections = ['sqlsrv', 'sqlsrv2', 'sqlsrv3'];
    
    // Inicializar una colección para almacenar los resultados combinados
    $combinedResults = collect();
    
    // Consulta SQL
    $query = "DECLARE @startDate DATE = ?;
              DECLARE @endDate DATE = ?;

              SELECT 
                  CAST(con.descripcion AS NVARCHAR(MAX)) AS descripcion, 
                  AVG(con.valorUnitario) AS valorUnitario, -- Cambié el nombre del alias a 'valorUnitario' para evitar conflicto
                  ISNULL(MAX(comgas.TotalCantidad), 0) AS TotalCantidad,
                  ISNULL((
                      SELECT SUM(vta.entregue - vta.recibi)
                      FROM vtaGasolina vta
                      INNER JOIN CatMangueras catm ON vta.NuManguera = catm.NuManguera
                      INNER JOIN CatCombustibles ctcomb ON ctcomb.NuCombustible = catm.NuCombustible
                      WHERE CAST(ctcomb.Descripcion AS NVARCHAR(MAX)) = CAST(con.descripcion AS NVARCHAR(MAX))
                        AND CONVERT(DATE, vta.Fecha) BETWEEN @startDate AND @endDate
                  ), 0) AS SumaEntregueRecibi
              FROM 
                  COMPROBANTE com
              INNER JOIN 
                  CONCEPTOS con ON con.idcomprobante = com.id
              LEFT JOIN 
                  (
                      SELECT 
                          SUM(com.Cantidad) AS TotalCantidad,
                          ctcom.Descripcion 
                      FROM 
                          ComGasolina com 
                      INNER JOIN 
                          CatTanques ctta ON ctta.NuTanque = com.NuTanque 
                      INNER JOIN 
                          CatCombustibles ctcom ON ctcom.NuCombustible = ctta.NuCombustible
                      GROUP BY 
                          ctcom.Descripcion
                  ) comgas ON CAST(con.descripcion AS NVARCHAR(MAX)) = comgas.Descripcion
              WHERE 
                  con.claveUnidad LIKE 'LTR'
                  AND CONVERT(DATE, com.Fecha) BETWEEN @startDate AND @endDate
                  AND CAST(con.descripcion AS NVARCHAR(MAX)) IN ('PEMEX MAGNA', 'PEMEX PREMIUM', 'PEMEX DIESEL')
              GROUP BY 
                  CAST(con.descripcion AS NVARCHAR(MAX));";

    // Ejecutar la consulta en cada conexión
    foreach ($connections as $connection) {
        $results = DB::connection($connection)->select($query, [$startDate, $endDate]);
        // Combinar los resultados
        $combinedResults = $combinedResults->merge(collect($results));
    }

    // Realizar las agregaciones sobre los resultados combinados
    $aggregatedResults = $combinedResults->groupBy('descripcion')->map(function ($group) {
        return [
            'descripcion' => $group->first()->descripcion,
            'PromedioValorUnitario' => $group->avg('valorUnitario'),
            'TotalCantidad' => $group->sum('TotalCantidad'),
            'SumaEntregueRecibi' => $group->sum('SumaEntregueRecibi'),
        ];
    });

    // Devolver el resultado combinado y agregado
    return $aggregatedResults;
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
                $comprobanteId = DB::table('COMPROBANTE')->insertGetId([
                    'Version' => $comprobante['Comprobante']['@attributes']['Version'] ?? null,
                    'Serie' => $comprobante['Comprobante']['@attributes']['Serie'] ?? null,
                    'folio' => $comprobante['Comprobante']['@attributes']['Folio'] ?? null,
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

public function mount()
    {
        $this->checkDatabaseConnections();
    }

    public function checkDatabaseConnections()
    {
        $databases = ['sqlsrv', 'sqlsrv2', 'sqlsrv3'];
        $messages = [];

        foreach ($databases as $database) {
            try {
                DB::connection($database)->getPdo();
                $messages[] = "Conectado a la base de datos: $database";
            } catch (\Exception $e) {
                $messages[] = "Error al conectar a la base de datos: $database - " . $e->getMessage();
            }
        }

        session()->flash('database_messages', $messages);
    }






}