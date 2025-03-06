<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgFpDivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fp_divisions = [
            ['nu_forma_pago' => 5, 'division' => 0, 'descripcion' => 'BANCO 1'],
            ['nu_forma_pago' => 5, 'division' => 1, 'descripcion' => 'BANCO 2'],
            ['nu_forma_pago' => 5, 'division' => 2, 'descripcion' => 'BANCO 3'],
            ['nu_forma_pago' => 5, 'division' => 3, 'descripcion' => 'BANCO 4'],
            ['nu_forma_pago' => 5, 'division' => 4, 'descripcion' => 'BANCO 5'],
            ['nu_forma_pago' => 5, 'division' => 5, 'descripcion' => '-----------'],
            ['nu_forma_pago' => 6, 'division' => 0, 'descripcion' => 'VALE ACCOR'],
            ['nu_forma_pago' => 6, 'division' => 1, 'descripcion' => 'EFECTIVALE'],
            ['nu_forma_pago' => 6, 'division' => 2, 'descripcion' => 'HIDROSINA'],
            ['nu_forma_pago' => 6, 'division' => 3, 'descripcion' => '-----------'],
            ['nu_forma_pago' => 6, 'division' => 4, 'descripcion' => '-----------'],
            ['nu_forma_pago' => 6, 'division' => 5, 'descripcion' => '-----------'],
        ];

        foreach ($fp_divisions as $fp_division) {
            DB::connection('sqlsrv_synergo')->table('ctg_fpdivisions')->insert($fp_division);
        }
    }
}
