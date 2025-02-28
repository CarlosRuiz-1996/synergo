<?php

namespace App\Livewire\Catalogos;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Catalogos\CtgCombustible;

class CombustiblesCtg extends Component
{
 

    use WithPagination;
    public $readyToLoad = false;
    // public CatalogosForm $catalogos;
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

    public $tipo;
    // public $no;
    public $desc;
    public $corta;
    public $costo;
    public $existencia;


    protected $rules = [
        'tipo' => 'required',
        // 'no' => 'required',
        'desc' => 'required',
        'corta' => 'required',
        'costo' => 'required',
        'existencia' => 'required',
    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
            'tipo',
            // 'no',
            'desc',
            'corta',
            'costo',
            'existencia',
            'open',
            'ctg_id',
            'ctg_detalle',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $combustibles = CtgCombustible::
            // where('clv_pemex','like','%'.$this->search.'%')
            // ->orWhere('description','like','%'.$this->search.'%')
            // ->orWhere('color_tq','like','%'.$this->search.'%')
            // ->orWhere('costo','like','%'.$this->search.'%')
            // ->orWhere('venta','like','%'.$this->search.'%')
            orderBy($this->sort, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $combustibles = [];
        }
        return view('livewire.catalogos.combustibles-ctg', compact('combustibles'));

    }


    #[On('save-combustible')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgCombustible::create([
                    'tipo' => $this->tipo,
                    // 'nuAceite'=>$this->no,
                    'description' => $this->desc,
                    'corta' => $this->corta,
                    'costo' => $this->costo,
                    'existencia' => $this->existencia,
                ]);
            } else {
                Log::info('update');
                CtgCombustible::where('id', $this->ctg_id)->update([
                    'tipo' => $this->tipo,
                    // 'nuAceite'=>$this->no,
                    'description' => $this->desc,
                    'corta' => $this->corta,
                    'costo' => $this->costo,
                    'existencia' => $this->existencia,
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



    public function edit(CtgCombustible $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->tipo =$ctg->tipo;
        $this->desc =$ctg->description;
        $this->costo =$ctg->costo;
        $this->corta =$ctg->corta;

        $this->existencia =$ctg->existencia;
        $this->open = true;

    }


    #[On('delete-combustible')]
    public function destroy(CtgCombustible $ctg){

        CtgCombustible::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
