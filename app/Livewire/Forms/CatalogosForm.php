<?php

namespace App\Livewire\Forms;

use App\Models\EstacionesExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CatalogosForm extends Form
{
    public $search = "";

    public $estacion;
    public $NumeroSistemaContable;
    public $NumeroDestino;
    public $FechaInicioOperaciones;
    public $PermisoCRE;
    public $SIIC;
    public $NombreEstacion;
    public $RFC;
    public $DireccionFiscal;
    public $AnalistaJR;
    public $CorreoAnalistaJR;
    public $Contador;
    public $CorreoContador;
    public $AnalistaCtaXPagar;
    public $CorreoCXP;
    public $AnalistaCtaXCobrar;
    public $CorreoCXC;
    public $Secretaria;
    public $CorreoSCA;
    public $DescargaContracargos;

    protected $rules = [
        'estacion' => 'required',
        'NumeroSistemaContable' => 'required',
        'NumeroDestino' => 'required',
        'FechaInicioOperaciones' => 'required',
        'PermisoCRE' => 'required',
        'SIIC' => 'required',
        'NombreEstacion' => 'required',
        'RFC' => 'required', // RFC tiene un tamaño máximo de 13 caracteres
        'DireccionFiscal' => 'required',
        'AnalistaJR' => 'required',
        'CorreoAnalistaJR' => 'required|email|max:255',
        'Contador' => 'required',
        'CorreoContador' => 'required|email|max:255',
        'AnalistaCtaXPagar' => 'required',
        'CorreoCXP' => 'required|email|max:255',
        'AnalistaCtaXCobrar' => 'required',
        'CorreoCXC' => 'required|email|max:255',
        'Secretaria' => 'required',
        'CorreoSCA' => 'required|email|max:255',
        'DescargaContracargos' => 'required',
    ];
    protected $messages = [
        'estacion.required' => 'El campo estación es obligatorio.',
        'NumeroSistemaContable.required' => 'El campo es obligatorio',
        'NumeroDestino.required' => 'El campo Número de Destino es obligatorio.',
        'PermisoCRE.required' => 'El campo Permiso CRE es obligatorio.',
        'SIIC.required' => 'El campo SIIC es obligatorio.',
        'NombreEstacion.required' => 'El campo Nombre de la Estación es obligatorio.',
        'RFC.required' => 'El campo RFC es obligatorio.',
        'RFC.max' => 'El campo RFC no puede tener más de 13 caracteres.',
        'DireccionFiscal.required' => 'El campo Dirección Fiscal es obligatorio.',
        'CorreoAnalistaJR.required' => 'El campo Correo del Analista JR es obligatorio.',
        'CorreoAnalistaJR.email' => 'El campo Correo del Analista JR debe ser una dirección de correo válida.',
        'CorreoAnalistaJR.max' => 'El campo Correo del Analista JR no puede tener más de 255 caracteres.',
        'Contador.required' => 'El campo Contador es obligatorio.',
        'CorreoContador.required' => 'El campo Correo del Contador es obligatorio.',
        'CorreoContador.email' => 'El campo Correo del Contador debe ser una dirección de correo válida.',
        'CorreoContador.max' => 'El campo Correo del Contador no puede tener más de 255 caracteres.',
        'AnalistaCtaXPagar.required' => 'El campo Analista de Cuentas por Pagar es obligatorio.',
        'CorreoCXP.required' => 'El campo Correo de Cuentas por Pagar es obligatorio.',
        'CorreoCXP.email' => 'El campo Correo de Cuentas por Pagar debe ser una dirección de correo válida.',
        'CorreoCXP.max' => 'El campo Correo de Cuentas por Pagar no puede tener más de 255 caracteres.',
        'AnalistaCtaXCobrar.required' => 'El campo Analista de Cuentas por Cobrar es obligatorio.',
        'CorreoCXC.required' => 'El campo Correo de Cuentas por Cobrar es obligatorio.',
        'CorreoCXC.email' => 'El campo Correo de Cuentas por Cobrar debe ser una dirección de correo válida.',
        'CorreoCXC.max' => 'El campo Correo de Cuentas por Cobrar no puede tener más de 255 caracteres.',
        'Secretaria.required' => 'El campo Secretaria es obligatorio.',
        'CorreoSCA.required' => 'El campo Correo de la Secretaria es obligatorio.',
        'CorreoSCA.email' => 'El campo Correo de la Secretaria debe ser una dirección de correo válida.',
        'CorreoSCA.max' => 'El campo Correo de la Secretaria no puede tener más de 255 caracteres.',
        'DescargaContracargos.required' => 'El campo Descarga de Contracargos es obligatorio.',
    ];

    public function getAllEstaciones($sort, $orderBy, $list)
    {
        return DB::table('EstacionesExcel')
            ->where(function ($query) {
                $query->orWhere('IdEstacion', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('estacion', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('NumeroSistemaContable', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('NombreEstacion', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('DireccionFiscal', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy('IdEstacion', $orderBy)

            ->paginate($list);
    }

    public function getEstacionById($id)
    {
        return  DB::table('EstacionesExcel')->where('IdEstacion', $id)->first();
    }

    //CRUD ESTACION
    public function store($idEstacion)
    {
        $this->validate();

        try {
            DB::beginTransaction();

            if ($idEstacion == 0) {
                $this->save();
            } else {
                $this->update($idEstacion);
            }
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('No se pudo completar la solicitud: ' . $e->getMessage());
            Log::info('Info: ' . $e);
            return 0;
        }
    }


    public function save()
    {
        EstacionesExcel::create(
            [
                'estacion' => $this->estacion,
                'NumeroSistemaContable' => $this->NumeroSistemaContable,
                'NumeroDestino' => $this->NumeroDestino,
                'FechaInicioOperaciones' => $this->FechaInicioOperaciones,
                'PermisoCRE' => $this->PermisoCRE,
                'SIIC' => $this->SIIC,
                'NombreEstacion' => $this->NombreEstacion,
                'RFC' => $this->RFC,
                'DireccionFiscal' => $this->DireccionFiscal,
                'AnalistaJR' => $this->AnalistaJR,
                'CorreoAnalistaJR' => $this->CorreoAnalistaJR,
                'Contador' => $this->Contador,
                'CorreoContador' => $this->CorreoContador,
                'AnalistaCtaXPagar' => $this->AnalistaCtaXPagar,
                'CorreoCXP' => $this->CorreoCXP,
                'AnalistaCtaXCobrar' => $this->AnalistaCtaXCobrar,
                'CorreoCXC' => $this->CorreoCXC,
                'Secretaria' => $this->Secretaria,
                'CorreoSCA' => $this->CorreoSCA,
                'DescargaContracargos' => $this->DescargaContracargos,
            ]
        );
    }
    public function update($id)
    {

        $estacion =  EstacionesExcel::find($id);
        $estacion->update([
            'estacion' => $this->estacion,
            'NumeroSistemaContable' => $this->NumeroSistemaContable,
            'NumeroDestino' => $this->NumeroDestino,
            'FechaInicioOperaciones' => $this->FechaInicioOperaciones,
            'PermisoCRE' => $this->PermisoCRE,
            'SIIC' => $this->SIIC,
            'NombreEstacion' => $this->NombreEstacion,
            'RFC' => $this->RFC,
            'DireccionFiscal' => $this->DireccionFiscal,
            'AnalistaJR' => $this->AnalistaJR,
            'CorreoAnalistaJR' => $this->CorreoAnalistaJR,
            'Contador' => $this->Contador,
            'CorreoContador' => $this->CorreoContador,
            'AnalistaCtaXPagar' => $this->AnalistaCtaXPagar,
            'CorreoCXP' => $this->CorreoCXP,
            'AnalistaCtaXCobrar' => $this->AnalistaCtaXCobrar,
            'CorreoCXC' => $this->CorreoCXC,
            'Secretaria' => $this->Secretaria,
            'CorreoSCA' => $this->CorreoSCA,
            'DescargaContracargos' => $this->DescargaContracargos,
        ]);
    }
}
