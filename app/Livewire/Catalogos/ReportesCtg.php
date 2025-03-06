<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgReportes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class ReportesCtg extends Component
{
   
    use WithPagination;
    public $readyToLoad = false;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort_repo = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort_repo' => ['except' => 'id'],
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
   
    public function order($sort_repo)
    {

        if ($this->sort_repo == $sort_repo) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort_repo = $sort_repo;
            $this->orderBy = 'desc';
        }
    }
    public function create()
    {
        $this->clean();
        $this->open = true;
    }

    public $titulo;
    public $consulta;
    public $nivel;
    
    public $man_dt_alta;
    protected $rules = [
        'titulo' => 'required',
        'consulta' => 'required',
        'nivel' => 'required',
       

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'titulo',
            'consulta',
            'nivel',
            'open',
            'ctg_id',
            'ctg_detalle',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgReportes::where('titulo','like','%'.$this->search.'%')
            ->orWhere('consulta','like','%'.$this->search.'%')
            ->orWhere('nivel','like','%'.$this->search.'%')
            ->orderBy($this->sort_repo, $this->orderBy)->paginate(10);//->withTrashed()

        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.reportes-ctg', compact('catalogos'));
    }


    #[On('save-reportes')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgReportes::create([
                    
                    'tituloription' => $this->titulo,
                    'consulta' => $this->consulta,
                    'nivel' => $this->nivel,
                   

                ]);
            } else {
                Log::info('update');
                CtgReportes::where('id', $this->ctg_id)->update([
                   
                    'tituloription' => $this->titulo,
                    'consulta' => $this->consulta,
                    'nivel' => $this->nivel,
                   
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



    public function edit(CtgReportes $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->titulo =$ctg->tituloription;
        $this->nivel =$ctg->nivel;
        $this->consulta =$ctg->consulta;
      
        $this->open = true;

        $this->man_dt_alta=$ctg->man_dt_alta;

    }


    #[On('delete-reportes')]
    public function destroy(CtgReportes $ctg){

        CtgReportes::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
