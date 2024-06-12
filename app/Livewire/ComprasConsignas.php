<?php

namespace App\Livewire;

use App\Exports\ComprasConsignas as ExportsComprasConsignas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
}
