<?php

namespace App\Livewire\CuentasPagar;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use App\Livewire\DescargarComprobateXmloPDF;

class ControlPagos extends Component
{

    public DescargarComprobateXmloPDF $export;
    use WithPagination;
    public $estacionSeleccionada;
    public $fechainicio;
    public $fechafin;
    public $TipoCombustible;
    public $estacion_detalle;
    protected $detalles = [];
    public $readyToLoad = false;
    public $monto_pagado;
    public $estaciond;
    public function render()
    {
        if ($this->readyToLoad) {

            $estaciones = DB::table('EstacionesExcel')->orderBy('NombreEstacion', 'ASC')->get();
            $detalles = $this->filtrar();

            $this->monto();
        } else {
            $estaciones = [];
            $detalles = [];
        }
        return view('livewire.cuentas-pagar.control-pagos', compact('estaciones', 'detalles'));
    }
    public function loadEstaciones()
    {
        $this->readyToLoad = true;
    }
    public function buscar()
    {
        if ($this->estacionSeleccionada) {
            $this->estaciond = DB::table('EMISOR')->first();
            $this->estacion_detalle = DB::table('EstacionesExcel')->where('IdEstacion',$this->estacionSeleccionada)->first();
        }
        $this->monto();
        $this->detalles = $this->filtrar();
    }


    public function filtrar()
    {

        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();

        //dr.impPagado
        return DB::table('COMPROBANTE as c')
            ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
            ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
            ->join('DOCTO_RELACIONADO as dr', DB::raw('CAST(dr.idDocumento AS VARCHAR(MAX))'), '=', DB::raw('CAST(t.UUID AS VARCHAR(MAX))'))

            ->whereBetween('c.Fecha', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('c.TipoDeComprobante', 'LIKE', 'P')
                    ->orWhere('c.TipoDeComprobante', 'LIKE', 'I')
                    ;
            })->where('conc.descripcion','LIKE','PEMEX MAGNA')


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
            )->orderBy('c.Fecha', 'DESC')
            ->paginate(10);
    }
    public $total_facturas;
    public function monto()
    {
        $startDate = $this->fechainicio ? Carbon::createFromFormat('Y-m-d', $this->fechainicio)->startOfDay() : Carbon::createFromDate(null, 4, 1)->startOfDay();
        $endDate = $this->fechafin ? Carbon::createFromFormat('Y-m-d', $this->fechafin)->endOfDay() : Carbon::createFromDate(null, 4, 30)->endOfDay();

        $this->monto_pagado =  DB::table('COMPROBANTE as c')
            ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
            ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
            ->join('DOCTO_RELACIONADO as dr', DB::raw('CAST(dr.idDocumento AS NVARCHAR(MAX))'), '=', DB::raw('CAST(t.UUID AS NVARCHAR(MAX))'))
            ->whereBetween('c.Fecha', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('c.TipoDeComprobante', 'LIKE', 'P')
                    ->orWhere('c.TipoDeComprobante', 'LIKE', 'I');
            })
            ->sum('c.Total');


        $this->total_facturas =  DB::table('COMPROBANTE as c')
            ->join('TIMBRE_FISCAL_DIGITAL as t', 't.idcomprobante', '=', 'c.id')
            ->join('CONCEPTOS as conc', 'conc.idcomprobante', '=', 'c.id')
            ->join('DOCTO_RELACIONADO as dr', DB::raw('CAST(dr.idDocumento AS NVARCHAR(MAX))'), '=', DB::raw('CAST(t.UUID AS NVARCHAR(MAX))'))
            ->whereBetween('c.Fecha', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('c.TipoDeComprobante', 'LIKE', 'P')
                    ->orWhere('c.TipoDeComprobante', 'LIKE', 'I');
            })
            ->count();
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
}
