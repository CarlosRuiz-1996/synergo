<?php

namespace App\Livewire;

use App\Exports\ExportResumenCompras;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    
    //dd($ventas);
     //$inicial=$this->buscarInventarioInicial();
     // Retorna la vista con los resultados de la consulta
     //dd($despachos);
    return view('livewire.resumen-compras', compact('despachos','ventas','estaciones'));
    //return view('livewire.resumen-compras');
}
public function buscar(){
     
    // Realiza la consulta a la base de datos utilizando los filtros
   if($this->EstacionSeleccionada=="" ||  $this->EstacionSeleccionada != 153){
    return null;
   }else{
    // Establece las fechas de inicio y fin
    // Establece las fechas de inicio y fin
    $combustible = !empty($this->TipoCombustible) ? (array)$this->TipoCombustible : ['PEMEX MAGNA', 'PEMEX DIESEL', 'PEMEX PREMIUM'];  
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
    // Realiza la consulta a la base de datos utilizando los filtros y paginación
    $despachos = DB::table('COMPROBANTE as comp')
        ->join('CONCEPTOS as concPE', 'concPE.idcomprobante', '=', 'comp.id')
        ->leftJoin('CONCEPTOS as concSI', function($join) {
            $join->on('concSI.idcomprobante', '=', 'comp.id')
                 ->whereRaw("CAST(concSI.descripcion AS nvarchar(max)) = 'Servicio de intermediacion de productos'");
        })
        ->selectRaw('comp.*, 
                    concPE.*, 
                    concSI.valorUnitario / concPE.cantidad AS FLETE_SERVICIO,
                    (concPE.valorUnitario + (concSI.valorUnitario / concPE.cantidad)) * concPE.cantidad AS TOTAL_CON_FLETE')
        ->whereIn(DB::raw("CAST(concPE.descripcion AS nvarchar(max))"), $combustible)
        ->whereBetween('comp.Fecha', [$startDate, $endDate])
        ->orderByRaw("CAST(comp.Fecha AS nvarchar(max)) ASC")
        ->orderByRaw("CAST(concPE.descripcion AS nvarchar(max)) ASC")
        ->paginate(10);

    // Retornar la vista o los datos paginados
    return $despachos;
// Retornar la vista o los datos paginados
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
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    $nuCombustibles = [];
    $CostoPromedio =0.0;
    foreach ($combustible as $tipo) {
        switch ($tipo) {
            case 'PEMEX MAGNA':
                $nuCombustibles[] = 1;
                $CostoPromedio =16.8019;
                break;
            case 'PEMEX PREMIUM':
                $nuCombustibles[] = 2;
                $CostoPromedio =19.9203;
                break;
            case 'PEMEX DIESEL':
                $nuCombustibles[] = 3;
                $CostoPromedio =18.4120;
                break;
            // Agregar más casos según sea necesario
        }
    }
    $despachos = DB::table('COMPROBANTE as comp')
        ->select('comp.id AS comp_id',
                 'comp.Fecha',
                 'concPE.idcomprobante',
                 'concPE.valorUnitario',
                 'concPE.cantidad',
                 'concPE.descripcion',
                 DB::raw('(CASE WHEN CompConRowNumber.RowNumber = 1 THEN cp.ComprasCantidad ELSE 0 END) AS ComprasCantidad'),
                 DB::raw('(concSI.valorUnitario / concPE.cantidad) AS FLETE_SERVICIO'),
                 DB::raw('((concPE.valorUnitario + (concSI.valorUnitario / concPE.cantidad)) * concPE.cantidad) AS TOTAL_CON_FLETE'))
        ->from('COMPROBANTE as comp')
        ->join('CONCEPTOS as concPE', 'concPE.idcomprobante', '=', 'comp.id')
        ->leftJoin('CONCEPTOS as concSI', function($join) {
            $join->on('concSI.idcomprobante', '=', 'comp.id')
                 ->whereRaw("CAST(concSI.descripcion AS nvarchar(max)) = 'Servicio de intermediacion de productos'");
        })
        ->leftJoin(DB::raw("(SELECT 
                                comp.id AS comp_id,
                                comp.Fecha,
                                concPE.idcomprobante,
                                concPE.valorUnitario,
                                concPE.cantidad,
                                ROW_NUMBER() OVER(PARTITION BY CAST(comp.Fecha AS DATE) ORDER BY comp.Fecha) AS RowNumber
                            FROM COMPROBANTE AS comp
                            INNER JOIN CONCEPTOS AS concPE ON concPE.idcomprobante = comp.id
                            WHERE CAST(concPE.descripcion AS nvarchar(max)) IN ('" . implode("','", $combustible) . "')
                              AND comp.Fecha BETWEEN '{$startDate}' AND '{$endDate}') AS CompConRowNumber"), function($join) {
            $join->on('CompConRowNumber.comp_id', '=', 'comp.id');
        })
        ->leftJoin(DB::raw("(SELECT 
                                Fecha,
                                SUM(cantidad) AS ComprasCantidad
                            FROM ComGasolina
                            WHERE Fecha BETWEEN '{$startDate}' AND '{$endDate}'
                              AND NuCamion = '1111'
                              AND NuTanque IN (" . implode(',', $nuCombustibles) . ")
                            GROUP BY Fecha) AS cp"), 'cp.Fecha', '=', DB::raw("CAST(comp.Fecha AS DATE)"))
        ->whereRaw("CAST(concPE.descripcion AS nvarchar(max)) IN ('" . implode("','", $combustible) . "')")
        ->whereBetween('comp.Fecha', [$startDate, $endDate])
        ->orderByRaw("comp.Fecha ASC")
        ->orderByRaw("concPE.idcomprobante ASC")
        ->get();

        $ventas = DB::table('ERGVentasGasolina_View as er')
        ->join('CatCombustibles as ct', 'ct.NuCombustible', '=', 'er.NuCombustible')
        ->select('er.*', 'ct.Descripcion')
        ->whereBetween('er.Fecha', [$startDate, $endDate])
        ->whereIn('er.NuCombustible', $nuCombustibles)
        ->orderByRaw("er.Fecha ASC")
        ->get();

        $results = DB::table('ERInventarioCombustibleReglaxEStablaVentas_View')
        ->whereIn('NuCombustible', $nuCombustibles)
        ->whereBetween('Fecha', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
        ->first();
        if (is_null($results)) {
            $results = (object) [
                'Inv_Inicial' => 1,
                // agrega aquí otras columnas que necesites con valores por defecto
            ];
        }
        $nombredoc = 'Resumen_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.xlsx';
    return Excel::download(new ExportResumenCompras($despachos, $startDate->toDateString(), $endDate->toDateString(), $results,$ventas,$CostoPromedio), $nombredoc);
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
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    // Consulta SQL
    $query = "DECLARE @startDate DATE = ?;
              DECLARE @endDate DATE = ?;

              SELECT 
                  CAST(con.descripcion AS NVARCHAR(MAX)) AS descripcion, 
                  AVG(con.valorUnitario) AS PromedioValorUnitario,
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
              GROUP BY 
                  CAST(con.descripcion AS NVARCHAR(MAX));";

    // Ejecutar la consulta SQL
    $resultados = DB::select($query, [$startDate, $endDate]);

    // Retorna los resultados
    return $resultados;
}





}