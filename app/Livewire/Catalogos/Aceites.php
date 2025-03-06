<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\Aceite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Aceites extends Component
{
    use WithPagination;
    public $readyToLoad = false;
    // public CatalogosForm $catalogos;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort_aceite = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort_aceite' => ['except' => 'id'],
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
    public function order($sort_aceite)
    {

        if ($this->sort_aceite == $sort_aceite) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort_aceite = $sort_aceite;
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
            $aceites = Aceite::where('tipo','like','%'.$this->search.'%')
            ->orWhere('description','like','%'.$this->search.'%')
            ->orWhere('corta','like','%'.$this->search.'%')
            ->orWhere('costo','like','%'.$this->search.'%')
            ->orWhere('existencia','like','%'.$this->search.'%')
            ->orderBy($this->sort_aceite, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $aceites = [];
        }
        return view('livewire.catalogos.aceites', compact('aceites'));
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
                Aceite::create([
                    'tipo' => $this->tipo,
                    // 'nuAceite'=>$this->no,
                    'description' => $this->desc,
                    'corta' => $this->corta,
                    'costo' => $this->costo,
                    'existencia' => $this->existencia,
                ]);
            } else {
                Log::info('update');
                Aceite::where('id', $this->ctg_id)->update([
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



    public function edit(Aceite $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->tipo =$ctg->tipo;
        $this->desc =$ctg->description;
        $this->costo =$ctg->costo;
        $this->corta =$ctg->corta;

        $this->existencia =$ctg->existencia;
        $this->open = true;

    }


    #[On('delete-ctg')]
    public function destroy(Aceite $ctg){

        Aceite::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
