<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgTurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        DB::connection('sqlsrv_synergo')->table('ctg_turnos')->insert([
            [
                'nu_turno' => 1,
                'descripcion' => '',
                'inicio' => '06:00:00',
                'duracion' => 8,
                
            ],
            [
                'nu_turno' => 2,
                'descripcion' => '',
                'inicio' => '14:00:00',
                'duracion' => 8,
                
            ],
            [
                'nu_turno' => 3,
                'descripcion' => '',
                'inicio' => '22:00:00',
                'duracion' => 8,
                
            ],
        ]);
    }
}
