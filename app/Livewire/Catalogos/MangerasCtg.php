<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgMangueras;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class MangerasCtg extends Component
{
   
    use WithPagination;
    public $readyToLoad = false;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort' => ['except' => 'NumeroSistemaContable'],
        'orderBy' => ['except' => 'asc'],
        'search' => ['except' => ''],
    ];


    //buscador y filtrado
    public function loadData()
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

    public $nu_isla;
    public $nu_combustible;
    public $nu_pos_carga;
    public $lec_ini;
    public $estado;
    public $nu_cliente;
    public $nu_tarjeta;
    public $bnd_miles;
    public $nu_pistola;
    public $nu_antena;

    public $man_dt_alta;
    protected $rules = [
        'nu_isla' => 'required',
        'nu_combustible' => 'required',
        'nu_pos_carga' => 'required',
        'lec_ini' => 'required',
        'estado' => 'required',
        'nu_cliente' => 'required',
        'nu_tarjeta' => 'required',
        'bnd_miles' => 'required',
        'nu_antena' => 'required',
        'nu_pistola' => 'required',
        'man_dt_alta' => 'required',

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'nu_isla',
            'nu_combustible',
            'nu_pos_carga',
            'lec_ini',
            'open',
            'ctg_id',
            'ctg_detalle',
            'estado',
            'nu_cliente',
            'nu_tarjeta',
            'bnd_miles',
            'nu_antena',
            'nu_pistola',
            'man_dt_alta',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgMangueras::where('nu_isla','like','%'.$this->search.'%')
            ->orWhere('nu_combustible','like','%'.$this->search.'%')
            ->orWhere('nu_pos_carga','like','%'.$this->search.'%')
            ->orWhere('lec_ini','like','%'.$this->search.'%')
            ->orWhere('estado','like','%'.$this->search.'%')
            ->orWhere('nu_tarjeta','like','%'.$this->search.'%')
            ->orWhere('bnd_miles','like','%'.$this->search.'%')
            ->orWhere('nu_antena','like','%'.$this->search.'%')
            ->orWhere('nu_pistola','like','%'.$this->search.'%')
            ->orWhere('man_dt_alta','like','%'.$this->search.'%')
            ->orWhere('nu_cliente','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.mangeras-ctg', compact('catalogos'));
    }


    #[On('save-ctg')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgMangueras::create([
                    
                    'nu_islaription' => $this->nu_isla,
                    'nu_combustible' => $this->nu_combustible,
                    'nu_pos_carga' => $this->nu_pos_carga,
                    'lec_ini' => $this->lec_ini,
                    'estado' => $this->estado,
                    'nu_cliente' => $this->nu_cliente,
                    'nu_tarjeta' => $this->nu_tarjeta,
                    'bnd_miles' => $this->bnd_miles,
                    'nu_antena' => $this->nu_antena,
                    'nu_pistola' => $this->nu_pistola,
                    'man_dt_alta' => $this->man_dt_alta,

                ]);
            } else {
                Log::info('update');
                CtgMangueras::where('id', $this->ctg_id)->update([
                   
                    'nu_islaription' => $this->nu_isla,
                    'nu_combustible' => $this->nu_combustible,
                    'nu_pos_carga' => $this->nu_pos_carga,
                    'lec_ini' => $this->lec_ini,
                    'estado' => $this->estado,
                    'nu_cliente' => $this->nu_cliente,
                    'nu_tarjeta' => $this->nu_tarjeta,
                    'bnd_miles' => $this->bnd_miles,
                    'nu_antena' => $this->nu_antena,
                    'nu_pistola' => $this->nu_pistola,
                    'man_dt_alta' => $this->man_dt_alta,

                ]);
            }
            DB::commit();
            $msg = "La estación se " . $this->ctg_id != 0 ? "actualizo" : "creo" . " exitosamente!";

            $this->dispatch('alert', [$msg, "success"]);
            $this->clean();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('No se pudo completar la solicitud: ' . $e->getMessage());
            Log::info('Info: ' . $e);
            $this->dispatch('alert', ["Ocurrio un error, intenta mas tarde.", "error"]);
        }
    }



    public function edit(CtgMangueras $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->nu_isla =$ctg->nu_islaription;
        $this->nu_pos_carga =$ctg->nu_pos_carga;
        $this->nu_combustible =$ctg->nu_combustible;
        $this->estado =$ctg->estado;
        $this->nu_cliente =$ctg->nu_cliente;

        $this->lec_ini =$ctg->lec_ini;
        $this->open = true;

        $this->nu_tarjeta =$ctg->nu_tarjeta;
        $this->bnd_miles=$ctg->bnd_miles;
        $this->nu_antena=$ctg->nu_antena;
        $this->nu_pistola=$ctg->nu_pistola;
        $this->man_dt_alta=$ctg->man_dt_alta;

    }


    #[On('delete-ctg')]
    public function destroy(CtgMangueras $ctg){

        CtgMangueras::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
