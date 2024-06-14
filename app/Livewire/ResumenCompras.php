<?php

namespace App\Livewire;

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
     // Retorna la vista con los resultados de la consulta
     return view('livewire.resumen-compras', compact('despachos'));
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
}