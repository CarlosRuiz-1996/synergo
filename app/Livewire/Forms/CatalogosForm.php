<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CatalogosForm extends Form
{
    public $search = "";

    public $estacion;
    public $NumeroDestino;
    public $PermisoCRE;
    public $SIIC;
    public $NombreEstacion;
    public $RFC;
    public $DireccionFiscal;
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


    protected function rules()
    {
        return [
            'estacion' => 'required',
            'NumeroDestino' => 'required',
            'PermisoCRE' => 'required',
            'SIIC' => 'required',
            'NombreEstacion' => 'required',
            'RFC' => 'required', // RFC tiene un tamaño máximo de 13 caracteres
            'DireccionFiscal' => 'required',
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
    }

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

            DB::table('EstacionesExcel')
                ->updateOrInsert(
                    ['IdEstacion' => $idEstacion], // Criterios de búsqueda
                    [
                        'estacion' => $this->estacion,
                        'NumeroDestino' => $this->NumeroDestino,
                        'PermisoCRE' => $this->PermisoCRE,
                        'SIIC' => $this->SIIC,
                        'NombreEstacion' => $this->NombreEstacion,
                        'RFC' => $this->RFC,
                        'DireccionFiscal' => $this->DireccionFiscal,
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
            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('No se pudo completar la solicitud: ' . $e->getMessage());
            Log::info('Info: ' . $e);
            return 0;

        }
    }
}
