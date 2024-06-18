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
public $fechainicio;
public $fechafin;
public function render()
{
     // Obtiene las fechas de inicio y fin de los filtros del formulario o valores predeterminados
     $despachos=$this->buscar();
     $inicial=$this->buscarInventarioInicial();
     // Retorna la vista con los resultados de la consulta
     return view('livewire.resumen-compras', compact('despachos','inicial'));
}
public function buscar(){

    // Realiza la consulta a la base de datos utilizando los filtros
   
// Establece las fechas de inicio y fin
$startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
$endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
// Realiza la consulta a la base de datos utilizando los filtros y paginación
return $despachos = DB::table('COMPROBANTE as comp')
    ->join('CONCEPTOS as concPE', 'concPE.idcomprobante', '=', 'comp.id')
    ->leftJoin('CONCEPTOS as concSI', function($join) {
        $join->on('concSI.idcomprobante', '=', 'comp.id')
             ->whereRaw("CAST(concSI.descripcion AS nvarchar(max)) = 'Servicio de intermediacion de productos'");
    })
    ->selectRaw('comp.*, 
                concPE.*, 
                concSI.valorUnitario / concPE.cantidad AS FLETE_SERVICIO,
                (concPE.valorUnitario + (concSI.valorUnitario / concPE.cantidad)) * concPE.cantidad AS TOTAL_CON_FLETE')
    ->whereRaw("CAST(concPE.descripcion AS nvarchar(max)) IN ('PEMEX MAGNA', 'PEMEX DIESEL','PEMEX PREMIUM')")
    ->whereBetween('comp.Fecha', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
    ->orderByRaw("CAST(comp.Fecha AS nvarchar(max)) ASC")
    ->orderByRaw("CAST(concPE.descripcion AS nvarchar(max)) ASC")
    ->paginate(10);

// Retornar la vista o los datos paginados


}


public function buscarInventarioInicial(){
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
   return $results = DB::table('ERInventarioCombustibleReglaxEStablaVentas_View')->whereBetween('Fecha', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])->where('NuCombustible',1)->get();
}
public function exportarExcel()
{
    $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
    $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();

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
                        WHERE CAST(concPE.descripcion AS nvarchar(max)) IN ('PEMEX MAGNA')
                          AND comp.Fecha BETWEEN '{$startDate}' AND '{$endDate}') AS CompConRowNumber"), function($join) {
        $join->on('CompConRowNumber.comp_id', '=', 'comp.id');
    })
    ->leftJoin(DB::raw("(SELECT 
                            Fecha,
                            SUM(cantidad) AS ComprasCantidad
                        FROM ComGasolina
                        WHERE Fecha BETWEEN '{$startDate}' AND '{$endDate}'
                          AND NuCamion = '1111'
                          AND NuTanque = 1
                        GROUP BY Fecha) AS cp"), 'cp.Fecha', '=', DB::raw("CAST(comp.Fecha AS DATE)"))
    ->whereRaw("CAST(concPE.descripcion AS nvarchar(max)) IN ('PEMEX MAGNA')")
    ->whereBetween('comp.Fecha', [$startDate, $endDate])
    ->orderByRaw("comp.Fecha ASC")
    ->orderByRaw("concPE.idcomprobante ASC")
    ->get();
    //dd($despachos);
    $results = DB::table('ERInventarioCombustibleReglaxEStablaVentas_View')->whereBetween('Fecha', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])->where('NuCombustible',1)->first();

    return Excel::download(new ExportResumenCompras($despachos, $startDate->toDateString(), $endDate->toDateString(),$results), 'ResumenCompras.xlsx');
                    
}
}