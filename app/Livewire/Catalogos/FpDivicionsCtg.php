<?php

namespace App\Livewire\Catalogos;


use App\Models\Catalogos\CtgFPDivision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class FpDivicionsCtg extends Component
{
   
       
    use WithPagination;
    public $readyToLoad = false;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort_fpdiv = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort_fpdiv' => ['except' => 'id'],
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
    public function order($sort_fpdiv)
    {

        if ($this->sort_fpdiv == $sort_fpdiv) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort_fpdiv = $sort_fpdiv;
            $this->orderBy = 'desc';
        }
    }

    public function create()
    {
        $this->clean();
        $this->open = true;
    }

    public $desc;
    public $division;
 
    protected $rules = [
        'desc' => 'required',
        'division' => 'required',
       

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'desc',
            'division',
            'open',
            'ctg_id',
            'ctg_detalle',
           
        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgFPDivision::where('division','like','%'.$this->search.'%')
            ->orWhere('descripcion','like','%'.$this->search.'%')
            ->orderBy($this->sort_fpdiv, $this->orderBy)->paginate(10);//->withTrashed()

                   } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.fp-divicions-ctg', compact('catalogos'));
    }


    #[On('save-fpdivisions')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgFPDivision::create([
                    
                    'descripcion' => $this->desc,
                    'division' => $this->division,
                 
                ]);
            } else {
                Log::info('update');
                CtgFPDivision::where('id', $this->ctg_id)->update([
                   
                    'descripcion' => $this->desc,
                    'division' => $this->division,
                   
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



    public function edit(CtgFPDivision $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->desc =$ctg->descripcion;
        $this->division =$ctg->division;
        $this->open = true;

    }


    #[On('delete-fpdivisions')]
    public function destroy(CtgFPDivision $ctg){

        CtgFPDivision::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
