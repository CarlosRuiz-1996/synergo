<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgDespachadores;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class DespachadoresCtg extends Component
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

    public $desc;
    public $nip;
    public $nu_isla;
    public $turno;
    public $llavero;


    protected $rules = [
        'desc' => 'required',
        'nip' => 'required',
        'nu_isla' => 'required',
        'turno' => 'required',
        'llavero' => 'required',

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'desc',
            'nip',
            'nu_isla',
            'turno',
            'open',
            'ctg_id',
            'ctg_detalle',
            'llavero',


        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgDespachadores::where('nip','like','%'.$this->search.'%')
            ->orWhere('descripcion','like','%'.$this->search.'%')
            ->orWhere('nu_isla','like','%'.$this->search.'%')
            ->orWhere('turno','like','%'.$this->search.'%')
            ->orWhere('llavero','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.despachadores-ctg', compact('catalogos'));
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
                CtgDespachadores::create([
                    
                    'descripcion' => $this->desc,
                    'nip' => $this->nip,
                    'nu_isla' => $this->nu_isla,
                    'turno' => $this->turno,
                    'llavero' => $this->llavero,

                ]);
            } else {
                Log::info('update');
                CtgDespachadores::where('id', $this->ctg_id)->update([
                   
                    'descripcion' => $this->desc,
                    'nip' => $this->nip,
                    'nu_isla' => $this->nu_isla,
                    'turno' => $this->turno,
                    'llavero' => $this->llavero,

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



    public function edit(CtgDespachadores $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->desc =$ctg->descripcion;
        $this->nu_isla =$ctg->nu_isla;
        $this->nip =$ctg->nip;
        $this->llavero =$ctg->llavero;

        $this->turno =$ctg->turno;
        $this->open = true;

    }


    #[On('delete-ctg')]
    public function destroy(CtgDespachadores $ctg){

        CtgDespachadores::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
