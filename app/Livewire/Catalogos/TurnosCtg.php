<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgTurnos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class TurnosCtg extends Component
{
    
    use WithPagination;
    public $readyToLoad = false;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort_turno = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort_turno' => ['except' => 'id'],
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
   
    public function order($sort_turno)
    {

        if ($this->sort_turno == $sort_turno) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort_turno = $sort_turno;
            $this->orderBy = 'desc';
        }
    }
    public function create()
    {
        $this->clean();
        $this->open = true;
    }

    public $descripcion;
    public $inicio;
    public $duracion;
    
    public $man_dt_alta;
    protected $rules = [
        'descripcion' => 'required',
        'inicio' => 'required',
        'duracion' => 'required',
       

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'descripcion',
            'inicio',
            'duracion',
            'open',
            'ctg_id',
            'ctg_detalle',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgTurnos::where('descripcion','like','%'.$this->search.'%')
            ->orWhere('inicio','like','%'.$this->search.'%')
            ->orWhere('duracion','like','%'.$this->search.'%')
            ->orderBy($this->sort_turno, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.turnos-ctg', compact('catalogos'));
    }


    #[On('save-turnos')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgTurnos::create([
                    
                    'descripcionription' => $this->descripcion,
                    'inicio' => $this->inicio,
                    'duracion' => $this->duracion,
                   

                ]);
            } else {
                Log::info('update');
                CtgTurnos::where('id', $this->ctg_id)->update([
                   
                    'descripcionription' => $this->descripcion,
                    'inicio' => $this->inicio,
                    'duracion' => $this->duracion,
                   
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



    public function edit(CtgTurnos $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->descripcion =$ctg->descripcionription;
        $this->duracion =$ctg->duracion;
        $this->inicio =$ctg->inicio;
      
        $this->open = true;

        $this->man_dt_alta=$ctg->man_dt_alta;

    }


    #[On('delete-turnos')]
    public function destroy(CtgTurnos $ctg){

        CtgTurnos::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
