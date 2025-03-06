<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgValeGas extends Model
{


   use HasFactory;
   protected $table = "ctg_vale_gas";
   use SoftDeletes;
   protected $connection = 'sqlsrv_synergo';

   protected $fillable = [
       'descripcion',
   ];


}
