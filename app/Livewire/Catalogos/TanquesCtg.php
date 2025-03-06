<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgTanques;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class TanquesCtg extends Component
{
    
     
    use WithPagination;
    public $readyToLoad = false;
    public $entrada = array('5', '10', '15', '20', '50', '100');
    public $list = '5';
    public $sort_tanque = "id";
    public $orderBy = "asc";
    public $open = false;
    public $search="";
    public $ctg_detalle;
    public $ctg_id = 0;

    protected $queryString = [
        'list' => ['except' => ['10']],
        'sort_tanque' => ['except' => 'id'],
        'orderBy' => ['except' => 'asc'],
        'search' => ['except' => ''],
    ];
    public function order($sort_tanque)
    {

        if ($this->sort_tanque == $sort_tanque) {
            if ($this->orderBy == 'desc') {
                $this->orderBy = 'asc';
            } else {
                $this->orderBy = 'desc';
            }
        } else {
            $this->sort_tanque = $sort_tanque;
            $this->orderBy = 'desc';
        }
    }


    //buscador y filtrado
    public function loadData()
    {
        $this->readyToLoad = true;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
   
    public function create()
    {
        $this->clean();
        $this->open = true;
    }

    public $capacidad;
    public $diametro;
    public $niv_seg;
    public $niv_op;
    public $edo;
    public $fondaje;
    public $capa_oper;
    public $tan_dt_alta;
    protected $rules = [
        'capacidad' => 'required',
        'diametro' => 'required',
        'niv_seg' => 'required',
        'niv_op' => 'required',
        'edo' => 'required',
        'fondaje' => 'required',
        'capa_oper' => 'required',
        'tan_dt_alta' => 'required',


    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'capacidad',
            'diametro',
            'niv_seg',
            'niv_op',
            'open',
            'ctg_id',
            'ctg_detalle',
            'edo',
            'fondaje',
            'capa_oper',
            'tan_dt_alta',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgTanques::where('diametro','like','%'.$this->search.'%')
            ->orWhere('capacidad','like','%'.$this->search.'%')
            ->orWhere('niv_seg','like','%'.$this->search.'%')
            ->orWhere('niv_op','like','%'.$this->search.'%')
            ->orWhere('edo','like','%'.$this->search.'%')
            ->orWhere('fondaje','like','%'.$this->search.'%')
            ->orderBy($this->sort_tanque, $this->orderBy)->paginate(10);//->withTrashed()
        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.tanques-ctg', compact('catalogos'));
    }


    #[On('save-tanques')]
    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            Log::info('transacction');
            if ($this->ctg_id == 0) {
                Log::info('save');
                CtgTanques::create([
                    
                    'capacidad' => $this->capacidad,
                    'diametro' => $this->diametro,
                    'niv_seg' => $this->niv_seg,
                    'niv_op' => $this->niv_op,
                    'edo' => $this->edo,
                    'fondaje' => $this->fondaje,
                    'capa_oper' => $this->capa_oper,
                    'tan_dt_alta' => $this->tan_dt_alta,

                ]);
            } else {
                Log::info('update');
                CtgTanques::where('id', $this->ctg_id)->update([
                   
                    'capacidad' => $this->capacidad,
                    'diametro' => $this->diametro,
                    'niv_seg' => $this->niv_seg,
                    'niv_op' => $this->niv_op,
                    'edo' => $this->edo,
                    'fondaje' => $this->fondaje,
                    'capa_oper' => $this->capa_oper,
                    'tan_dt_alta' => $this->tan_dt_alta,


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



    public function edit(CtgTanques $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->capacidad =$ctg->capacidad;
        $this->niv_seg =$ctg->niv_seg;
        $this->diametro =$ctg->diametro;
        $this->edo =$ctg->edo;
        $this->fondaje =$ctg->fondaje;
        $this->capa_oper =$ctg->capa_oper;
        $this->tan_dt_alta =$ctg->tan_dt_alta;

        $this->niv_op =$ctg->niv_op;
        $this->open = true;

    }


    #[On('delete-tanques')]
    public function destroy(CtgTanques $ctg){

        CtgTanques::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
