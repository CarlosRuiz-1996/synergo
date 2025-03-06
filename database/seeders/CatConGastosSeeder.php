<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatConGastosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::connection('sqlsrv_synergo')->table('ctg_con_gastos')->insert([
            [
                'no_gasto' => 1,
                'concepto' => 'GASTOS GENERALES',
                'descripcion' => 'Gastos recurrentes de la estación de servicio',
                'tipo_gasto' => 1,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 2,
                'concepto' => 'MANTTO DE EDIF',
                'descripcion' => 'MATERIAL Y MANO DE OBRA EMPLEADO PARA DAR MANTTO A LA E.S. EN CUANTO AL MOBILIARIO',
                'tipo_gasto' => 17,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 3,
                'concepto' => 'MANTTO DE EQUIPO',
                'descripcion' => 'MANO DE OBRA Y MATERIAL OCUPADO EN EL MANTENIMENTO DEL EQUIPO DE LA E.S.',
                'tipo_gasto' => 18,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 4,
                'concepto' => 'ADMINISTRATIVOS',
                'descripcion' => 'GASTOS ADMINISTRATIVOS RECURRENTES MES A MES',
                'tipo_gasto' => 45,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 5,
                'concepto' => 'IMPUESTOS',
                'descripcion' => 'RELACION DE IMPUESTOS QUE SE PAGAN POR LA ACTIVIDAD DE LA ESTACION DE SERVICIO',
                'tipo_gasto' => 46,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 6,
                'concepto' => 'HONORARIOS PROF',
                'descripcion' => 'PAGO DE HONARIOS PRESTADOS POR PERSONAL INDEPENDIENTE.',
                'tipo_gasto' => 62,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 7,
                'concepto' => 'GASTOS JARRAS',
                'descripcion' => 'ACT.',
                'tipo_gasto' => 85,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 8,
                'concepto' => 'COMISIONES',
                'descripcion' => 'PAGO DIFERENTES COMISIONES BANCARIAS Y CARGOS POR SERV. PRESTADOS POR EL BANCO',
                'tipo_gasto' => 64,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 9,
                'concepto' => 'GASTOS EMPRESAS',
                'descripcion' => 'GASTOS PAGADOS A LAS EMPRESAS DEL GRUPO Y EXTERNAS POR SERVICIOS PRESTADOS',
                'tipo_gasto' => 63,
                'relacion' => 0,
                
            ],
            [
                'no_gasto' => 10,
                'concepto' => 'GASTOS EFECTIVO',
                'descripcion' => 'ACT. PARA REPORTE DE ANTICIPOS',
                'tipo_gasto' => 89,
                'relacion' => 0,
                
            ],
            ['no_gasto' => 1, 'concepto' => 'GASTOS GENERALES', 'descripcion' => 'Gastos recurrentes de la estación de servicio', 'tipo_gasto' => 1, 'relacion' => 0],
            ['no_gasto' => 2, 'concepto' => 'MANTTO DE EDIF', 'descripcion' => 'MATERIAL Y MANO DE OBRA EMPLEADO PARA DAR MANTTO A LA E.S. EN CUANTO AL MOBILIARIO', 'tipo_gasto' => 17, 'relacion' => 0],
            ['no_gasto' => 3, 'concepto' => 'MANTTO DE EQUIPO', 'descripcion' => 'MANO DE OBRA Y MATERIAL OCUPADO EN EL MANTENIMENTO DEL EQUIPO DE LA E.S.', 'tipo_gasto' => 18, 'relacion' => 0],
            ['no_gasto' => 4, 'concepto' => 'ADMINISTRATIVOS', 'descripcion' => 'GASTOS ADMINISTRATIVOS RECURRENTES MES A MES', 'tipo_gasto' => 45, 'relacion' => 0],
            ['no_gasto' => 5, 'concepto' => 'IMPUESTOS', 'descripcion' => 'RELACION DE IMPUESTOS QUE SE PAGAN POR LA ACTIVIDAD DE LA ESTACION DE SERVICIO', 'tipo_gasto' => 46, 'relacion' => 0],
            ['no_gasto' => 6, 'concepto' => 'HONORARIOS PROF', 'descripcion' => 'PAGO DE HONARIOS PRESTADOS POR PERSONAL INDEPENDIENTE.', 'tipo_gasto' => 62, 'relacion' => 0],
            ['no_gasto' => 7, 'concepto' => 'GASTOS JARRAS', 'descripcion' => 'ACT.', 'tipo_gasto' => 85, 'relacion' => 0],
            ['no_gasto' => 8, 'concepto' => 'COMISIONES', 'descripcion' => 'PAGO DIFERENTES COMISIONES BANCARIAS Y CARGOS POR SERV. PRESTADOS POR EL BANCO', 'tipo_gasto' => 64, 'relacion' => 0],
            ['no_gasto' => 9, 'concepto' => 'GASTOS EMPRESAS', 'descripcion' => 'GASTOS PAGADOS A LAS EMPRESAS DEL GRUPO Y EXTERNAS POR SERVICIOS PRESTADOS', 'tipo_gasto' => 63, 'relacion' => 0],
            ['no_gasto' => 10, 'concepto' => 'GASTOS EFECTIVO', 'descripcion' => 'ACT. PARA REPORTE DE ANTICIPOS', 'tipo_gasto' => 89, 'relacion' => 0],
            ['no_gasto' => 11, 'concepto' => 'COMPRAS', 'descripcion' => 'Compras Act.', 'tipo_gasto' => 97, 'relacion' => 0],
            ['no_gasto' => 101, 'concepto' => 'ARTICULOS DE OFICINA', 'descripcion' => 'COMPRA DE EQUIPO DE OFICINA, FAX, SUMADORAS, PC, ETC....', 'tipo_gasto' => 5, 'relacion' => 1],
            ['no_gasto' => 102, 'concepto' => 'PAPELERIA', 'descripcion' => 'COMPRA DE PAPELERIA EN GENERAL HOJAS, PLUMAS, LIGAS, ETC...', 'tipo_gasto' => 3, 'relacion' => 1],
            ['no_gasto' => 103, 'concepto' => 'GASTOS DE FESTIVIDADES', 'descripcion' => 'COMIDA DEL 12 DE DICIEMBRE, 24 Y 31, EVENTOS ESPECIALES', 'tipo_gasto' => 2, 'relacion' => 1],
            ['no_gasto' => 104, 'concepto' => 'IMPRESION DE PAPELERIA', 'descripcion' => 'FAJILLAS, VOUCHERS, FACTURAS, ETC..', 'tipo_gasto' => 4, 'relacion' => 1],
            ['no_gasto' => 105, 'concepto' => 'BOLSAS PARA MORRALLA', 'descripcion' => 'COMPRA DE BOLSAS PARA ENVIAR LA MORRALLA A CUSTRAVAL', 'tipo_gasto' => 6, 'relacion' => 1],
            ['no_gasto' => 106, 'concepto' => 'COMISION DE VENTAS', 'descripcion' => 'COMISION QUE SE PAGA A LOS PROPINEROS POR ALCANZAR LOS OBJETIVOS X VENTAS ACEITES DEL MES', 'tipo_gasto' => 7, 'relacion' => 1],
            ['no_gasto' => 107, 'concepto' => 'PASAJES Y CASETAS', 'descripcion' => 'PAGO DE PASAJES COMPRA DE MATERIAL', 'tipo_gasto' => 8, 'relacion' => 1],
            ['no_gasto' => 108, 'concepto' => 'SUELDOS Y PRESTACIONES', 'descripcion' => 'SUELDOS QUE SE PAGA AL PERSONAL DE PATIO EN LA E.S.', 'tipo_gasto' => 9, 'relacion' => 1],
            ['no_gasto' => 109, 'concepto' => 'PIPAS DE AGUA', 'descripcion' => 'PAGO DE SUMINISTRO DE AGUA POTABLE X PIPAS A LA E.S.', 'tipo_gasto' => 10, 'relacion' => 1],
            ['no_gasto' => 110, 'concepto' => 'CHAMARRAS', 'descripcion' => 'COMPRA DE CHAMARRAS PARA EL PERSONAL DE PISO EN EPOCA DE INVIERNO', 'tipo_gasto' => 11, 'relacion' => 1],
            ['no_gasto' => 111, 'concepto' => 'GRATIFICACIONES', 'descripcion' => 'COMPENSACION POR SERVICIOS EXTRAORDINARIOS', 'tipo_gasto' => 12, 'relacion' => 1],
            ['no_gasto' => 112, 'concepto' => 'LIQUIDACIONES A EMPLEADOS', 'descripcion' => 'PAGO DE REMUNERACION POR TERMINACION DE LA RELACION LABORAL', 'tipo_gasto' => 13, 'relacion' => 1],
            ['no_gasto' => 113, 'concepto' => 'GASTOS MEDICOS', 'descripcion' => 'AYUDAS P/ACCIDENTES, MEDICINAS, ESTUDIOS', 'tipo_gasto' => 14, 'relacion' => 1],
            ['no_gasto' => 114, 'concepto' => 'RENTA DE EQUIPO', 'descripcion' => 'RENTAS PLANTA DE LUZ, INFLABLES, EQUIPO DE SONIDO, ETC', 'tipo_gasto' => 15, 'relacion' => 1],
            ['no_gasto' => 115, 'concepto' => 'ASALTOS', 'descripcion' => 'FUGAS DE CLIENTES SIN PAGAR, ASALTOS A LAS ISLAS', 'tipo_gasto' => 16, 'relacion' => 1],
            ["no_gasto" => 10, "concepto" => "GASTOS EFECTIVO", "descripcion" => "ACT. PARA REPORTE DE ANTICIPOS", "tipo_gasto" => 89, "relacion" => 0],
            ["no_gasto" => 201, "concepto" => "PINTURA", "descripcion" => "MANO DE OBRA Y MATERIAL: BROCHAS, THINNER ESTOPA, CUÑAS, REMOVEDOR, ETC...", "tipo_gasto" => 19, "relacion" => 17],
            ["no_gasto" => 202, "concepto" => "MATERIAL ELECTRICO", "descripcion" => "MANO DE OBRA Y MATERIAL, BALASTRAS, CABLES, CONTACTOS, PASTILLAS, LAMPARAS, ETC..", "tipo_gasto" => 20, "relacion" => 17],
            ["no_gasto" => 203, "concepto" => "PLOMERIA", "descripcion" => "MANO DE OBRA Y MATERIAL : BOMBAS AGUA, EMPAQUES, LLAVES, LAVABOS, JABONERAS,...", "tipo_gasto" => 21, "relacion" => 17],
            ["no_gasto" => 204, "concepto" => "GASTOS CONSTRUCCION", "descripcion" => "MANO DE OBRA Y MATERIAL DE CONSTRUCCION Y ALBAÑILERIA,", "tipo_gasto" => 22, "relacion" => 17],
            ["no_gasto" => 205, "concepto" => "HERRAMIENTAS", "descripcion" => "COMPRA DE HERRAMIENTA PARA USO DE LA E.S. SEGUN LISTA", "tipo_gasto" => 23, "relacion" => 17],
            ["no_gasto" => 206, "concepto" => "HERRERIA", "descripcion" => "MANO DE OBRA Y MATERIALES: ANGULOS, BISAGRAS, CHAPAS, LAMINAS, SOLDADURA, ETC....", "tipo_gasto" => 24, "relacion" => 17],
            ["no_gasto" => 207, "concepto" => "MANTTO AREAS VERDES", "descripcion" => "JARDINERIA, COMPRA DE PLANTAS, ABONO, SUELDO JARDINERO", "tipo_gasto" => 25, "relacion" => 17],
            ["no_gasto" => 208, "concepto" => "RECOLECCION DE BASURA", "descripcion" => "PAGO SEMANAL O MENSUAL DE LA RECOLECCION DE BASURA", "tipo_gasto" => 26, "relacion" => 17],
            ["no_gasto" => 209, "concepto" => "VACTOR", "descripcion" => "LIMPIEZA DE TRAMPAS", "tipo_gasto" => 27, "relacion" => 17],
            ["no_gasto" => 210, "concepto" => "ROTULOS Y SEÑALAMIENTOS", "descripcion" => "CALCOMANIAS, CARTELES PREVENTIVOS, INFORMATIVOS, RESTRICTIVOS.", "tipo_gasto" => 28, "relacion" => 17],
            // Agrega los demás registros aquí

        ]);
    }
}
