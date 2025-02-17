<?php

namespace App\Livewire\Catalogos;

use Livewire\Component;
use App\Livewire\Forms\CatalogosForm;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Estaciones extends Component
{
    use WithPagination;
    public $readyToLoad = false;
    public CatalogosForm $catalogos;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort = "NumeroSistemaContable";
    public $orderBy = "asc";
    public $open = false;
    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort' => ['except' => 'NumeroSistemaContable'],
        'orderBy' => ['except' => 'asc'],
        'catalogos.search' => ['except' => ''],
    ];
    public function render()
    {
        if ($this->readyToLoad) {
            $estaciones = $this->catalogos->getAllEstaciones($this->sort, $this->orderBy, $this->list);
            // dd($estaciones);

        } else {
            $estaciones = [];
        }
        return view('livewire.catalogos.estaciones', compact('estaciones'));
    }

    //buscador y filtrado
    public function loadEstaciones()
    {
        $this->readyToLoad = true;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function order($sort)
    {

        if ($this->sort == $sort) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->orderBy = 'desc';
        }
    }

    public function create()
    {
        $this->clean();
        $this->open = true;
    }

    public $estacion_detalle;
    public $estacion_id = 0;
    public function edit($id)
    {

        $this->estacion_id = $id;
        $this->estacion_detalle = $this->catalogos->getEstacionById($id);
        $this->catalogos->estacion = $this->estacion_detalle->estacion;
        $this->catalogos->NumeroSistemaContable = $this->estacion_detalle->NumeroSistemaContable;
        $this->catalogos->NumeroDestino = $this->estacion_detalle->NumeroDestino;
        $this->catalogos->FechaInicioOperaciones = $this->estacion_detalle->FechaInicioOperaciones;
        $this->catalogos->PermisoCRE = $this->estacion_detalle->PermisoCRE;
        $this->catalogos->SIIC = $this->estacion_detalle->SIIC;
        $this->catalogos->NombreEstacion = $this->estacion_detalle->NombreEstacion;
        $this->catalogos->RFC = $this->estacion_detalle->RFC;
        $this->catalogos->DireccionFiscal = $this->estacion_detalle->DireccionFiscal;
        $this->catalogos->AnalistaJR = $this->estacion_detalle->AnalistaJR;
        $this->catalogos->CorreoAnalistaJR = $this->estacion_detalle->CorreoAnalistaJR;
        $this->catalogos->Contador = $this->estacion_detalle->Contador;
        $this->catalogos->CorreoContador = $this->estacion_detalle->CorreoContador;
        $this->catalogos->AnalistaCtaXPagar = $this->estacion_detalle->AnalistaCtaXPagar;
        $this->catalogos->CorreoCXP = $this->estacion_detalle->CorreoCXP;
        $this->catalogos->AnalistaCtaXCobrar = $this->estacion_detalle->AnalistaCtaXCobrar;
        $this->catalogos->CorreoCXC = $this->estacion_detalle->CorreoCXC;
        $this->catalogos->Secretaria = $this->estacion_detalle->Secretaria;
        $this->catalogos->CorreoSCA = $this->estacion_detalle->CorreoSCA;
        $this->catalogos->DescargaContracargos = $this->estacion_detalle->DescargaContracargos;
        $this->open = true;
    }

    public $info=false;
    public function detalles($id)
    {

        $this->estacion_detalle = $this->catalogos->getEstacionById($id);
        $this->catalogos->estacion = $this->estacion_detalle->estacion;
        $this->catalogos->NumeroSistemaContable = $this->estacion_detalle->NumeroSistemaContable;
        $this->catalogos->NumeroDestino = $this->estacion_detalle->NumeroDestino;
        $this->catalogos->FechaInicioOperaciones = $this->estacion_detalle->FechaInicioOperaciones;
        $this->catalogos->PermisoCRE = $this->estacion_detalle->PermisoCRE;
        $this->catalogos->SIIC = $this->estacion_detalle->SIIC;
        $this->catalogos->NombreEstacion = $this->estacion_detalle->NombreEstacion;
        $this->catalogos->RFC = $this->estacion_detalle->RFC;
        $this->catalogos->DireccionFiscal = $this->estacion_detalle->DireccionFiscal;
        $this->catalogos->AnalistaJR = $this->estacion_detalle->AnalistaJR;
        $this->catalogos->CorreoAnalistaJR = $this->estacion_detalle->CorreoAnalistaJR;
        $this->catalogos->Contador = $this->estacion_detalle->Contador;
        $this->catalogos->CorreoContador = $this->estacion_detalle->CorreoContador;
        $this->catalogos->AnalistaCtaXPagar = $this->estacion_detalle->AnalistaCtaXPagar;
        $this->catalogos->CorreoCXP = $this->estacion_detalle->CorreoCXP;
        $this->catalogos->AnalistaCtaXCobrar = $this->estacion_detalle->AnalistaCtaXCobrar;
        $this->catalogos->CorreoCXC = $this->estacion_detalle->CorreoCXC;
        $this->catalogos->Secretaria = $this->estacion_detalle->Secretaria;
        $this->catalogos->CorreoSCA = $this->estacion_detalle->CorreoSCA;
        $this->catalogos->DescargaContracargos = $this->estacion_detalle->DescargaContracargos;
        $this->info = true;
    }

    #[On('save-estacion')]
    public function save()
    {
        $res = $this->catalogos->store($this->estacion_id);
        $msg = "La estación se " . $this->estacion_id != 0 ? "actualizo" : "creo" . " exitosamente!";

        if ($res == 1) {

            $this->dispatch('alert', [$msg, "success"]);

            $this->render();
            $this->clean();
        } else {
            $this->dispatch('alert', ["Ocurrio un error, intenta mas tarde.", "error"]);
        }
    }

    public function clean()
    {
        $this->reset([
            'open', 'estacion_id', 'estacion_detalle','info',
            'catalogos.estacion',
            'catalogos.NumeroSistemaContable',
            'catalogos.NumeroDestino',
            'catalogos.FechaInicioOperacione',
            'catalogos.PermisoCRE',
            'catalogos.SIIC',
            'catalogos.NombreEstacion',
            'catalogos.RFC',
            'catalogos.DireccionFiscal',
            'catalogos.AnalistaJR',
            'catalogos.CorreoAnalistaJR',
            'catalogos.Contador',
            'catalogos.CorreoContador',
            'catalogos.AnalistaCtaXPagar',
            'catalogos.CorreoCXP',
            'catalogos.AnalistaCtaXCobrar',
            'catalogos.CorreoCXC',
            'catalogos.Secretaria',
            'catalogos.CorreoSCA',
            'catalogos.DescargaContracargos'
        ]);
    }

    
}
