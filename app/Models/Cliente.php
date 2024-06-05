<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "ClienteTitular";

    public function plan()
    {
        return $this->belongsTo(TipoPlan::class, 'idctgTipoPlan', 'idctgTipoPlan');
    }

    
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'idctgGrupo', 'idctgGrupo');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idctgEmpresa', 'idctgEmpresa');
    }
}
