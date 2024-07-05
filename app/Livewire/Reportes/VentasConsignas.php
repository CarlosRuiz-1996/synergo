<?php

namespace App\Livewire\Reportes;
use App\Exports\ExportVentasConsignas;
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

    public function render()
    {
        $consignasventas = $this->ventasConsignas();
        return view('livewire.reportes.ventas-consignas', compact('consignasventas'));
    }

    public function mount($valorModal)
    {
    $this->tipoCombustible=$valorModal;
    }




    public function ventasConsignas()
    {
        // Convertir las fechas a objetos Carbon para asegurar que están en el formato correcto
        $fechainicio = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $fechafin = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();
        // Construir la consulta SQL
        $query = "
            SELECT * 
            FROM ERGVentasGasolina_View 
            WHERE Fecha >= :fechainicio
            AND Fecha <= :fechafin
            AND nucombustible = :tipoCombustible
        ";

        // Ejecutar la consulta
        $resultados = DB::select($query, [
            'fechainicio' => $fechainicio,
            'fechafin' => $fechafin,
            'tipoCombustible' => $this->tipoCombustible,
        ]);

        // Convertir los resultados a una colección
        $resultados = collect($resultados);

        // Obtener el número de página actual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Definir el número de elementos por página
        $perPage = 10;

        // Calcular el offset
        $offset = ($currentPage * $perPage) - $perPage;

        // Crear una colección paginada
         $paginatedResults = new LengthAwarePaginator(
            $resultados->slice($offset, $perPage)->values(),
            $resultados->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        
        return $paginatedResults;
    }

    public function exportarExcel()
    {
        // Convertir las fechas a objetos Carbon para asegurar que están en el formato correcto
        $fechainicio = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $fechafin = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();

        // Construir la consulta SQL
        $query = "
            SELECT * 
            FROM ERGVentasGasolina_View 
            WHERE Fecha >= :fechainicio
            AND Fecha <= :fechafin
            AND nucombustible = :tipoCombustible
        ";

        // Ejecutar la consulta
        $resultados = DB::select($query, [
            'fechainicio' => $fechainicio,
            'fechafin' => $fechafin,
            'tipoCombustible' => $this->tipoCombustible,
        ]);
        $despachos = collect($resultados);

        return Excel::download(new ExportVentasConsignas($despachos, $fechainicio->toDateString(), $fechafin->toDateString()), 'ventas_Consignacion.xlsx');
                        
    }
}
