<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('sqlsrv_synergo')->table('ctg_tipos')->insert([
            [
                'tipo' => 'Ac',
                'descripcion' => 'ACEITE',
               
            ],
            [
                'tipo' => 'Ad',
                'descripcion' => 'ADITIVO',
               
            ],
            [
                'tipo' => 'Ot',
                'descripcion' => 'OTRO',
               
            ],
        ]);
    }
}
