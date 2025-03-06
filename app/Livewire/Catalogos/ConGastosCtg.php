<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgConGastos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class ConGastosCtg extends Component
{
   


    use WithPagination;
    public $readyToLoad = false;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort_congasto = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort_congasto' => ['except' => 'id'],
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
    public function order($sort_congasto)
    {

        if ($this->sort_congasto == $sort_congasto) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort_congasto = $sort_congasto;
            $this->orderBy = 'desc';
        }
    }

    public function create()
    {
        $this->clean();
        $this->open = true;
    }

    public $desc;
    public $no_gasto;
    public $concepto;
    public $tipo_gasto;
    public $relacion;


    protected $rules = [
        'desc' => 'required',
        'no_gasto' => 'required',
        'concepto' => 'required',
        'tipo_gasto' => 'required',
        'relacion' => 'required',

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'desc',
            'no_gasto',
            'concepto',
            'tipo_gasto',
            'open',
            'ctg_id',
            'ctg_detalle',
            'relacion',


        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgConGastos::where('no_gasto','like','%'.$this->search.'%')
            ->orWhere('descripcion','like','%'.$this->search.'%')
            ->orWhere('concepto','like','%'.$this->search.'%')
            ->orWhere('tipo_gasto','like','%'.$this->search.'%')
            ->orWhere('relacion','like','%'.$this->search.'%')
            ->orderBy($this->sort_congasto, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.con-gastos-ctg', compact('catalogos'));
    }


    #[On('save-congastos')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgConGastos::create([
                    
                    'descripcion' => $this->desc,
                    'no_gasto' => $this->no_gasto,
                    'concepto' => $this->concepto,
                    'tipo_gasto' => $this->tipo_gasto,
                    'relacion' => $this->relacion,

                ]);
            } else {
                Log::info('update');
                CtgConGastos::where('id', $this->ctg_id)->update([
                   
                    'descripcion' => $this->desc,
                    'no_gasto' => $this->no_gasto,
                    'concepto' => $this->concepto,
                    'tipo_gasto' => $this->tipo_gasto,
                    'relacion' => $this->relacion,

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



    public function edit(CtgConGastos $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->desc =$ctg->descripcion;
        $this->concepto =$ctg->concepto;
        $this->no_gasto =$ctg->no_gasto;
        $this->relacion =$ctg->relacion;

        $this->tipo_gasto =$ctg->tipo_gasto;
        $this->open = true;

    }


    #[On('delete-congastos')]
    public function destroy(CtgConGastos $ctg){

        CtgConGastos::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
