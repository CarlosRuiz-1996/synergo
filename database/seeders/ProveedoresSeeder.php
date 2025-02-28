<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $proveedores = [
            [
                'nombre' => 'BARDAHL DE MEXICO S.A. DE C.V.',
                'rfc' => 'BAR-900618-KL9',
                'calle' => 'CENTENO 90',
                'colonia' => 'GRANJAS ESMERALDA',
                'ciudad' => 'MEXICO D.F.',
                'edo' => 'D.F.',
                'cp' => '06500',
                'tel' => '55.78.89.45',
                'fax' => '55.58.56.56',
                'contacto' => 'SERGIO PEREZ',
                'credito' => 30
            ],
            [
                'nombre' => 'DISTRIBUIDORA DE LUBRICANTES MARAL S DE RL DE C.V.',
                'rfc' => 'LUM-950314-554',
                'calle' => 'ORIENTE157 NO. 10 INT. 302 C',
                'colonia' => 'EL COYOL',
                'ciudad' => 'GUSTAVO A MADER',
                'edo' => 'MEXICO, D.F.',
                'cp' => '45879',
                'tel' => '55.55.55.55',
                'fax' => '66.66.66.66',
                'contacto' => 'RODOLFO MAEQUEZ',
                'credito' => 15
            ],
            [
                'nombre' => 'ACEITES SUPERFINOS S.A. DE C.V.',
                'rfc' => 'ASU-820820-EVQ',
                'calle' => 'HELIOTROPO NO.161',
                'colonia' => 'ATLAMPA',
                'ciudad' => 'CENTRO',
                'edo' => 'DISTRTO FEDERAL',
                'cp' => '01',
                'tel' => '02',
                'fax' => 'V',
                'contacto' => 'XXXX',
                'credito' => 30
            ],
            [
                'nombre' => 'GRUPO PRODESIN S.A. DE C.V.',
                'rfc' => 'GPR-990820-11',
                'calle' => 'MARGARITAS',
                'colonia' => 'CRISTAL',
                'ciudad' => 'CUAUTITLAN R.R.',
                'edo' => 'edo. DE MEXICO',
                'cp' => '54875',
                'tel' => '58725118',
                'fax' => '58723425',
                'contacto' => 'SR.IGARI',
                'credito' => 1
            ],
            [
                'nombre' => 'DISTRIBUIDORA DE LUBRICANTES PLATA SA DE CV',
                'rfc' => 'DLP-870703-1FA',
                'calle' => 'CARR. FED MEX - PACHUCA KM 48',
                'colonia' => 'LOS REYES',
                'ciudad' => 'ACOSAC',
                'edo' => 'edo. MEXICO',
                'cp' => '01234',
                'tel' => '77962215',
                'fax' => '77962215',
                'contacto' => 'JORGE LUGO ALVAREZ',
                'credito' => 0
            ],
            [
                'nombre' => 'DITAtel, S.A. DE C.V.',
                'rfc' => 'DIT 940608 LJ2',
                'calle' => 'AV.MARIO COLIN 315',
                'colonia' => 'IND. LA LOMA',
                'ciudad' => 'TLALNAPANTLA',
                'edo' => 'edo.MEX.',
                'cp' => '54060',
                'tel' => '53984963',
                'fax' => '53978290',
                'contacto' => 'SR.MARCO',
                'credito' => 15
            ],
            [
                'nombre' => 'QUIMICA MARAL S DE RL DE C.V.',
                'rfc' => 'QMA-000905-BY7',
                'calle' => 'CITLALTEPETL NO. 24-101',
                'colonia' => 'HIPODROMO CONDESA',
                'ciudad' => 'ALVARO OBREGON',
                'edo' => 'D.F.',
                'cp' => '06100',
                'tel' => '5771-37-23',
                'fax' => '5771-37-23',
                'contacto' => 'RODOLFO MARQUEZ',
                'credito' => 30
            ],
            [
                'nombre' => 'COMERCIALIZADORA PROGAS S.A. DE C.V.',
                'rfc' => 'cpR9705024AA',
                'calle' => 'RIO NILO N° 90 7° PISO',
                'colonia' => 'CUAUHTEMOC',
                'ciudad' => '.',
                'edo' => 'D.F',
                'cp' => '00',
                'tel' => '00',
                'fax' => '00',
                'contacto' => '00',
                'credito' => 0
            ],
            [
                'nombre' => 'COMERCILIZADORA TORINO 2000, S.A. DE C.V.',
                'rfc' => 'CTD-000620-BH1',
                'calle' => 'A.CAMINO A SAN PEDRO MARTIR 221-B4101',
                'colonia' => 'SAN PEDRO MARTIR',
                'ciudad' => 'TLALPAN',
                'edo' => 'MEXICO, D.F.',
                'cp' => '14650',
                'tel' => '0155-2615',
                'fax' => '0155-3423',
                'contacto' => 'XXX',
                'credito' => 7
            ],
            [
                'nombre' => 'VICTOR LEOPOLDO GALVAN MAGAÑA',
                'rfc' => 'GAMV 601223 4MA',
                'calle' => '16 DE SEPTIEMBRE16 OCOTEPEC',
                'colonia' => '20 DE NOVIEMBRE',
                'ciudad' => 'CUERNAVACA, MOR',
                'edo' => 'CUERNAVACA MOR.',
                'cp' => '62220',
                'tel' => '01777382',
                'fax' => '01773',
                'contacto' => 'VICTOR LEOPOLDO GALVAN',
                'credito' => 30
            ],
            [
                'nombre' => 'SOLUCIONES INTEGRALES DE MEXICO, S.A. DEC.V.',
                'rfc' => 'SIM 010524 QB5',
                'calle' => 'CAFETALES 1792 -12',
                'colonia' => 'HACIENDAS DE COYOACAN',
                'ciudad' => 'COYOACAN',
                'edo' => 'MEXICO, D.F.',
                'cp' => '04970',
                'tel' => '5671-8578',
                'fax' => '2652-0576',
                'contacto' => 'ISRAEL SOLORZANO',
                'credito' => 30
            ],
            [
                'nombre' => 'WALTER STEIN BLANCO',
                'rfc' => 'SEBW 710123 HY5',
                'calle' => 'AV. CENTENARIO NO. 2699  A11',
                'colonia' => 'RINCON CENTENARIO',
                'ciudad' => 'ALVARO OBREGON',
                'edo' => 'MEXICO, D.F.',
                'cp' => '10437',
                'tel' => '5423-08-49',
                'fax' => '05420',
                'contacto' => 'WALTER STEIN BLANCO',
                'credito' => 30
            ],
            [
                'nombre' => 'CORPORATIVO MEXICANO DE GASOLINERIAS, S.C.',
                'rfc' => 'CMG-960827-P86',
                'calle' => 'RIO NILO 90-7',
                'colonia' => 'CUAHUTEMOC',
                'ciudad' => 'CUAHUTEMOC',
                'edo' => 'MEXICO, D.F.',
                'cp' => '56500',
                'tel' => '551121-86',
                'fax' => '55112',
                'contacto' => 'DAVID CUREÑO',
                'credito' => 15
            ],
            [
                'nombre' => 'ESTRATEGIA AUTOMOTRIZ DE MEXICO, S.A. C.V.',
                'rfc' => 'EAM-000829862',
                'calle' => 'MIGUEL VELASQUEZ NO. 48',
                'colonia' => 'PROVIDENCIA',
                'ciudad' => 'AZCAPOTZALCO',
                'edo' => 'MEXICO, D.F.',
                'cp' => '02440',
                'tel' => '53522424',
                'fax' => '5352-5224',
                'contacto' => 'RAUL DEL RIO',
                'credito' => 30
            ],
        ];

        DB::connection('sqlsrv_synergo')->table('ctg_proveedores')->insert($proveedores);
    }
}
