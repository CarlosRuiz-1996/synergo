<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgTablas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class TablasCtg extends Component
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

    public $nombre;
    public $bnd_catalogo;
    public $n_padre;
    
    public $man_dt_alta;
    protected $rules = [
        'nombre' => 'required',
        'bnd_catalogo' => 'required',
        'n_padre' => 'required',
       

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'nombre',
            'bnd_catalogo',
            'n_padre',
            'open',
            'ctg_id',
            'ctg_detalle',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgTablas::where('nombre','like','%'.$this->search.'%')
            ->orWhere('bnd_catalogo','like','%'.$this->search.'%')
            ->orWhere('n_padre','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.tablas-ctg', compact('catalogos'));
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
                CtgTablas::create([
                    
                    'nombreription' => $this->nombre,
                    'bnd_catalogo' => $this->bnd_catalogo,
                    'n_padre' => $this->n_padre,
                   

                ]);
            } else {
                Log::info('update');
                CtgTablas::where('id', $this->ctg_id)->update([
                   
                    'nombreription' => $this->nombre,
                    'bnd_catalogo' => $this->bnd_catalogo,
                    'n_padre' => $this->n_padre,
                   
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



    public function edit(CtgTablas $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->nombre =$ctg->nombreription;
        $this->n_padre =$ctg->n_padre;
        $this->bnd_catalogo =$ctg->bnd_catalogo;
      
        $this->open = true;

        $this->man_dt_alta=$ctg->man_dt_alta;

    }


    #[On('delete-ctg')]
    public function destroy(CtgTablas $ctg){

        CtgTablas::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
