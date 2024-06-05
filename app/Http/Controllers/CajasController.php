<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CajasController extends Controller
{
    //
    public function reporte(Request $request)
    {

        $query = Pago::query();
        $query->from('hPago as h'); // Asigna un alias a la tabla principal

    

        if ($request->has('expediente') && !empty($request->expediente)) {
            $query->where('h.cve_expediente', $request->expediente);
        }

        if ($request->has('folio') && !empty($request->folio)) {
            $query->where('h.no_foliorecibo', $request->folio);
        }

        if ($request->has('ctgGrupoUsr') && !empty($request->ctgGrupoUsr)) {
            $query->whereHas('grupo', function ($q) use ($request) {
                $q->where('idctgGrupo', $request->ctgGrupoUsr);
            });
        }

        if ($request->has('ctgEmpresa') && !empty($request->ctgEmpresa)) {
            $query->whereHas('empresa', function ($q) use ($request) {
                $q->where('idctgEmpresa', $request->ctgEmpresa);
            });
        }

        if ($request->has('inpTipoPlan') && !empty($request->inpTipoPlan)) {
            $query->whereHas('tipoPlan', function ($q) use ($request) {
                $q->where('idctgTipoPlan', $request->inpTipoPlan);
            });
        }

        if ($request->has('fechadesde') && !empty($request->fechadesde)) {
            $query->whereDate('h.fecha_alta', '>=', $request->fechadesde);
        }

        if ($request->has('fechahasta') && !empty($request->fechahasta)) {
            $query->whereDate('h.fecha_alta', '<=', $request->fechahasta);
        }

        if ($request->has('formapago') && !empty($request->formapago)) {
            $query->where('h.tipodepago', $request->formapago);
        }

        if ($request->has('conceptoPago') && !empty($request->conceptoPago)) {
            $query->where('h.id_dcConceptoDePago', $request->conceptoPago);
        }

        if ($request->has('mes_cubierto') && !empty($request->mes_cubierto)) {
            $query->where('h.mes_cubierto', $request->mes_cubierto);
        }

        if ($request->has('actividadesnombre') && !empty($request->actividadesnombre)) {
            $query->whereHas('actividadExtra', function ($q) use ($request) {
                $q->where('nombreactividad', $request->actividadesnombre);
            });
        }

        if ($query->count() == 0) {
            $query->whereDate('fecha_alta', '>=', now()->startOfDay())
                ->whereDate('fecha_alta', '<=', now()->endOfDay());
        }

        if (empty($request->all())) {
            $pagos = [];
        } else {
            $pagos = $query->with(['cliente', 'conceptoDePago',  'actividadExtra'])
                ->orderBy('fecha_alta', 'DESC')
                ->limit(1)
                ->get();
        }

        // foreach ($pagos as $c) {
        //     dd($c);
        // }

        $groups = DB::table('dCuotasGral as c')
            ->distinct()
            ->select('gpo.nombreGrupo as ds_nomgrupo', 'gpo.idctgGrupo as cve_grupo')
            ->join('ctgGrupo as gpo', function ($join) {
                $join->on('c.grupo', '=', 'gpo.nombreGrupo')
                    ->where('c.estatus', 1)
                    ->where('gpo.sts', 1);
            })
            ->orderBy('gpo.nombreGrupo')
            ->orderBy('c.num_personas')
            ->get();
        $empresas = DB::table('ctgEmpresa')
            ->select('idctgEmpresa as cve_empresa', 'razonsocial as ds_razonsocial')
            ->where('sts', 1)
            ->distinct()
            ->get();

        $conceptos = DB::table('dcConceptoDePago')
            ->select('id_dcConceptoDePago', 'concepto', 'cuota', 'estatus')
            ->where('estatus', 1)
            ->get();
        // return response()->json(['data' => $pagos]);

        $actividadesExtras = DB::table('hactividades_extras')
            ->select('nombreactividad', 'edad', 'interno')
            ->selectRaw("
                CASE 
                    WHEN interno = 1 THEN 'Interno'
                    ELSE 'Externo'
                END AS tipoUsr
            ")
            ->where('sts', 1)
            ->distinct()
            ->get();
        return view('reportes.cajas-reporte', compact('pagos', 'groups', 'empresas', 'conceptos', 'actividadesExtras'));
    }
}
