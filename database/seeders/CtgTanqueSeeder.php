<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgTanqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('sqlsrv_synergo')->table('ctg_tanques')->insert([
            [
                'nu_tanque' => 1,
                'capacidad' => 60000,
                'diametro' => 100,
                'niv_seg' => 1,
                'niv_op' => 1,
                'edo' => null,
                'fondaje' => 53371,
                'capa_oper' => 100,
                'tan_dt_alta' => '2007-01-01 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nu_tanque' => 2,
                'capacidad' => 60000,
                'diametro' => 100,
                'niv_seg' => 1,
                'niv_op' => 1,
                'edo' => null,
                'fondaje' => 33761,
                'capa_oper' => 100,
                'tan_dt_alta' => '2007-01-01 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nu_tanque' => 3,
                'capacidad' => 60000,
                'diametro' => 100,
                'niv_seg' => 1,
                'niv_op' => 1,
                'edo' => null,
                'fondaje' => 21468,
                'capa_oper' => 100,
                'tan_dt_alta' => '2007-01-01 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
