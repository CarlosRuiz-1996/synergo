<?php

namespace App\Livewire\Reportes;
use App\Exports\ExportVentasConsignas;
use App\Exports\VentasReporte;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class VentasConsignas extends Component
{
    use WithPagination;

    public $fechainicio;
    public $fechafin;
    public $tipoCombustible;

    public function mount($valorModal)
    {
    $this->tipoCombustible=$valorModal;
    }
    public function render()
    {
         // Obtiene las fechas de inicio y fin de los filtros del formulario o valores predeterminados
         $despachos=$this->buscar();
         // Retorna la vista con los resultados de la consulta
         return view('livewire.reportes.ventas-consignas', compact('despachos'));
    }
    public function buscar(){
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
        // Realiza la consulta a la base de datos utilizando los filtros
        return $despachos = DB::table('Despachos')
                        ->join('CatCombustibles', 'Despachos.NuCombustible', '=', 'CatCombustibles.NuCombustible')
                        ->select('Despachos.*', 'CatCombustibles.Descripcion')
                        ->whereBetween('Despachos.FecIni', [$startDate, $endDate])
                        ->where('CatCombustibles.NuCombustible', $this->tipoCombustible)
                        ->orderBy('Despachos.FecIni', 'asc')->paginate(10); // Pagina de 10 registros por página
                       
    
    }
    public function exportarExcel()
    {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
    
        // Realiza la consulta a la base de datos utilizando los filtros
        $despachos = DB::table('Despachos')
                        ->join('CatCombustibles', 'Despachos.NuCombustible', '=', 'CatCombustibles.NuCombustible')
                        ->select('Despachos.*', 'CatCombustibles.Descripcion')
                        ->whereBetween('Despachos.FecIni', [$startDate, $endDate])
                        ->where('CatCombustibles.NuCombustible', $this->tipoCombustible)
                        ->orderBy('Despachos.FecIni', 'asc')->get(); // Pagina de 10 registros por página

                        return Excel::download(new VentasReporte($despachos, $startDate, $endDate), 'ventas.xlsx');
                        
    }
}
