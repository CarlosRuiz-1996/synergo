<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CgtBancos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class BancosCtg extends Component
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
    public $no_secuencial;
    public $saldo;
    public $imprimir;


    protected $rules = [
        'desc' => 'required',
        'no_secuencial' => 'required',
        'saldo' => 'required',
        'imprimir' => 'required',
    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'desc',
            'no_secuencial',
            'saldo',
            'imprimir',
            'open',
            'ctg_id',
            'ctg_detalle',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CgtBancos::where('no_secuencial','like','%'.$this->search.'%')
            ->orWhere('descripcion','like','%'.$this->search.'%')
            ->orWhere('saldo','like','%'.$this->search.'%')
            ->orWhere('imprimir','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.bancos-ctg', compact('catalogos'));
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
                CgtBancos::create([
                    
                    'descripcion' => $this->desc,
                    'no_secuencial' => $this->no_secuencial,
                    'saldo' => $this->saldo,
                    'imprimir' => $this->imprimir,
                ]);
            } else {
                Log::info('update');
                CgtBancos::where('id', $this->ctg_id)->update([
                   
                    'descripcion' => $this->desc,
                    'no_secuencial' => $this->no_secuencial,
                    'saldo' => $this->saldo,
                    'imprimir' => $this->imprimir,
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



    public function edit(CgtBancos $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->desc =$ctg->descripcion;
        $this->saldo =$ctg->saldo;
        $this->no_secuencial =$ctg->no_secuencial;

        $this->imprimir =$ctg->imprimir;
        $this->open = true;

    }


    #[On('delete-ctg')]
    public function destroy(CgtBancos $ctg){

        CgtBancos::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
