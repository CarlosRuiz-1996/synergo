<?php

namespace App\Livewire\Catalogos;

use App\Models\Catalogos\CtgFormaPago;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
class FormasPagoCtg extends Component
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
    public $consulta;
    public $bnd_factura;
    public $nu_copias;
    public $bnd_autorizacion;
    public $bnd_puntada;

    protected $rules = [
        'desc' => 'required',
        'consulta' => 'required',
        'bnd_factura' => 'required',
        'nu_copias' => 'required',
        'bnd_autorizacion' => 'required',
        'bnd_puntada' => 'required',

    ];

    protected $messages = [
        '*.required' => 'El campo estación es obligatorio.',
    ];

    public function clean()
    {
        $this->reset([
         
            'desc',
            'consulta',
            'bnd_factura',
            'nu_copias',
            'open',
            'ctg_id',
            'ctg_detalle',
            'bnd_autorizacion',
            'bnd_puntada',

        ]);
    }
    public function render()
    {

        if ($this->readyToLoad) {
            $catalogos = CtgFormaPago::where('consulta','like','%'.$this->search.'%')
            ->orWhere('descripcion','like','%'.$this->search.'%')
            ->orWhere('bnd_factura','like','%'.$this->search.'%')
            ->orWhere('nu_copias','like','%'.$this->search.'%')
            ->orWhere('bnd_autorizacion','like','%'.$this->search.'%')
            ->orWhere('bnd_puntada','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->orderBy)->paginate(10);//->withTrashed()


        } else {

            $catalogos = [];
        }
        return view('livewire.catalogos.formas-pago-ctg', compact('catalogos'));
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
                CtgFormaPago::create([
                    
                    'descripcion' => $this->desc,
                    'consulta' => $this->consulta,
                    'bnd_factura' => $this->bnd_factura,
                    'nu_copias' => $this->nu_copias,
                    'bnd_autorizacion' => $this->bnd_autorizacion,
                    'bnd_puntada' => $this->bnd_puntada,

                ]);
            } else {
                Log::info('update');
                CtgFormaPago::where('id', $this->ctg_id)->update([
                   
                    'descripcion' => $this->desc,
                    'consulta' => $this->consulta,
                    'bnd_factura' => $this->bnd_factura,
                    'nu_copias' => $this->nu_copias,
                    'bnd_autorizacion' => $this->bnd_autorizacion,
                    'bnd_puntada' => $this->bnd_puntada,

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



    public function edit(CtgFormaPago $ctg)
    {

        $this->ctg_id = $ctg->id;
        $this->desc =$ctg->descripcion;
        $this->bnd_factura =$ctg->bnd_factura;
        $this->consulta =$ctg->consulta;
        $this->bnd_autorizacion =$ctg->bnd_autorizacion;
        $this->bnd_puntada =$ctg->bnd_puntada;

        $this->nu_copias =$ctg->nu_copias;
        $this->open = true;

    }


    #[On('delete-ctg')]
    public function destroy(CtgFormaPago $ctg){

        CtgFormaPago::destroy($ctg->id);
        $this->dispatch('alert', ['Estación eliminada', "success"]);

    }
}
