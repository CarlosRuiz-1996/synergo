<?php

namespace App\Livewire\Reportes;

use App\Exports\reportes\ExcelreporteInvCombustibletotal;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class InventarioCombustibletotal extends Component
{
    public $selectedMonth;

    
    public $coneccion;

    protected $listeners = ['abrirModaltotala'];

   

    public function abrirModaltotala($valor)
    {
        $this->coneccion = $valor;
    }

    public function render()
    {
        $inv = $this->encontrarInventario();
        return view('livewire.reportes.inventario-combustibletotal', compact('inv'));
    }

    public function encontrarInventario()
    {
        // Verificar si el mes seleccionado es 04
        if ($this->selectedMonth !== '04') {
            return [];
        }

        $query = "WITH PriceChange AS (
    SELECT 
        vg.Precio, 
        vg.FechaIni AS Fecha,
        cc.NuCombustible,
        cc.Descripcion,
        LAG(vg.Precio) OVER (PARTITION BY cc.NuCombustible ORDER BY vg.FechaIni) AS PrevPrecio,
        CASE 
            WHEN LAG(vg.Precio) OVER (PARTITION BY cc.NuCombustible ORDER BY vg.FechaIni) IS NULL THEN 1
            WHEN LAG(vg.Precio) OVER (PARTITION BY cc.NuCombustible ORDER BY vg.FechaIni) != vg.Precio THEN 1 
            ELSE 0 
        END AS PriceChangeFlag
    FROM vtaGasolina vg
    INNER JOIN CatMangueras cm ON vg.NuManguera = cm.NuManguera
    INNER JOIN CatCombustibles cc ON cc.NuCombustible = cm.NuCombustible
    WHERE vg.FechaIni >= '2024-03-30 23:59:59.999' AND vg.FechaIni < '2024-05-01'
),
GroupedPrices AS (
    SELECT *,
        SUM(PriceChangeFlag) OVER (PARTITION BY NuCombustible ORDER BY Fecha) AS PriceGroup
    FROM PriceChange
),
Consolidated AS (
    SELECT 
        NuCombustible, 
        Descripcion, 
        Precio, 
        MIN(Fecha) AS FechaInicio, 
        LEAD(MIN(Fecha), 1, '2024-04-30 23:59:59.999') OVER (PARTITION BY NuCombustible ORDER BY MIN(Fecha)) AS FechaFin
    FROM GroupedPrices
    GROUP BY NuCombustible, Descripcion, Precio, PriceGroup
),
SalesSum AS (
    SELECT 
        NuCombustible,
        precioventa,
        SUM(venta) AS SumaVenta
    FROM ERGVentasGasolina_View
    WHERE Fecha >= '2024-04-01' AND Fecha < '2024-05-01'
    GROUP BY NuCombustible, precioventa
),
FinalResults AS (
    SELECT 
        c.NuCombustible, 
        c.Descripcion, 
        c.Precio, 
        CASE 
            WHEN DAY(c.FechaInicio) = DAY(EOMONTH(c.FechaInicio)) THEN DATEADD(DAY, 1, EOMONTH(c.FechaInicio)) 
            ELSE c.FechaInicio 
        END AS FechaInicio,
        CASE 
            WHEN DAY(c.FechaFin) = 1 THEN DATEADD(DAY, -1, c.FechaFin) 
            ELSE c.FechaFin 
        END AS FechaFin,
        COALESCE(SUM(g.Cantidad), 0) AS SumaCantidad,
        COALESCE(s.SumaVenta, 0) AS SumaVenta,
        ROW_NUMBER() OVER (PARTITION BY c.NuCombustible ORDER BY c.FechaInicio) AS rn
    FROM Consolidated c
    LEFT JOIN ComGasolina g 
        ON c.NuCombustible = g.NuTanque 
        AND  g.Fecha >= c.FechaInicio AND g.Fecha < c.FechaFin
    LEFT JOIN SalesSum s
        ON c.NuCombustible = s.NuCombustible 
        AND c.Precio = s.precioventa 
    GROUP BY c.NuCombustible, c.Descripcion, c.Precio, c.FechaInicio, c.FechaFin, s.SumaVenta
),
Totals AS (
    SELECT 
        NuCombustible, 
        NULL AS Descripcion, 
        NULL AS Precio, 
        NULL AS FechaInicio, 
        NULL AS FechaFin,
        SUM(SumaCantidad) AS SumaCantidad,
        SUM(SumaVenta) AS SumaVenta,
        ROW_NUMBER() OVER (PARTITION BY NuCombustible ORDER BY (SELECT NULL)) + (SELECT COUNT(DISTINCT NuCombustible) FROM Consolidated) AS rn
    FROM FinalResults
    GROUP BY NuCombustible
),
InitialInventory AS (
    SELECT 
        NuCombustible,
        ROUND(inv_inicial, 0) AS inv_inicial
    FROM ERInventarioCombustibleReglaxEStablaVentas_View
    WHERE Fecha >= '2024-04-01' AND Fecha < '2024-05-01'
),
FinalInventory AS (
    SELECT 
        NuCombustible,
        ROUND(inv_final, 0) AS inv_final
    FROM ERInventarioCombustibleReglaxEStablaVentas_View
    WHERE Fecha >= '2024-04-30' AND Fecha < '2024-05-01'
)
SELECT 
    fr.NuCombustible, 
    fr.Descripcion, 
    fr.Precio, 
    CASE 
        WHEN fr.FechaInicio > fr.FechaFin THEN CONVERT(varchar, fr.FechaFin, 103) -- Formato dd/MM/yyyy
        ELSE CONVERT(varchar, fr.FechaInicio, 103) -- Formato dd/MM/yyyy
    END AS FechaInicio,
    CONVERT(varchar, fr.FechaFin, 103) AS FechaFin,
    fr.SumaCantidad,
    ROUND(fr.SumaVenta,0) as venta,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE ii.inv_inicial END AS inv_inicial,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE (ii.inv_inicial + fr.SumaCantidad) END AS Subtotal,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE fi.inv_final END AS inv_final,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE ROUND((fi.inv_final - ((ii.inv_inicial + fr.SumaCantidad) - fr.SumaVenta)), 0) END AS diferencia
FROM (
    SELECT * FROM FinalResults
    UNION ALL
    SELECT * FROM Totals
) AS fr
LEFT JOIN InitialInventory ii
    ON fr.NuCombustible = ii.NuCombustible
LEFT JOIN FinalInventory fi
    ON fr.NuCombustible = fi.NuCombustible
ORDER BY fr.NuCombustible, CASE WHEN fr.Descripcion IS NOT NULL THEN 0 ELSE 1 END, fr.FechaInicio;
        ";
        
        $resultados = DB::connection($this->coneccion)->select($query);
        return $resultados;
    }

    public function exportarExcel()
    {
        // Verificar si el mes seleccionado es 04
        if ($this->selectedMonth !== '04') {
            // No hacer nada si el mes seleccionado no es 04
            return;
        }else{

        $query = "WITH PriceChange AS (
    SELECT 
        vg.Precio, 
        vg.FechaIni AS Fecha,
        cc.NuCombustible,
        cc.Descripcion,
        LAG(vg.Precio) OVER (PARTITION BY cc.NuCombustible ORDER BY vg.FechaIni) AS PrevPrecio,
        CASE 
            WHEN LAG(vg.Precio) OVER (PARTITION BY cc.NuCombustible ORDER BY vg.FechaIni) IS NULL THEN 1
            WHEN LAG(vg.Precio) OVER (PARTITION BY cc.NuCombustible ORDER BY vg.FechaIni) != vg.Precio THEN 1 
            ELSE 0 
        END AS PriceChangeFlag
    FROM vtaGasolina vg
    INNER JOIN CatMangueras cm ON vg.NuManguera = cm.NuManguera
    INNER JOIN CatCombustibles cc ON cc.NuCombustible = cm.NuCombustible
    WHERE vg.FechaIni >= '2024-03-30 23:59:59.999' AND vg.FechaIni < '2024-05-01'
),
GroupedPrices AS (
    SELECT *,
        SUM(PriceChangeFlag) OVER (PARTITION BY NuCombustible ORDER BY Fecha) AS PriceGroup
    FROM PriceChange
),
Consolidated AS (
    SELECT 
        NuCombustible, 
        Descripcion, 
        Precio, 
        MIN(Fecha) AS FechaInicio, 
        LEAD(MIN(Fecha), 1, '2024-04-30 23:59:59.999') OVER (PARTITION BY NuCombustible ORDER BY MIN(Fecha)) AS FechaFin
    FROM GroupedPrices
    GROUP BY NuCombustible, Descripcion, Precio, PriceGroup
),
SalesSum AS (
    SELECT 
        NuCombustible,
        precioventa,
        SUM(venta) AS SumaVenta
    FROM ERGVentasGasolina_View
    WHERE Fecha >= '2024-04-01' AND Fecha < '2024-05-01'
    GROUP BY NuCombustible, precioventa
),
FinalResults AS (
    SELECT 
        c.NuCombustible, 
        c.Descripcion, 
        c.Precio, 
        CASE 
            WHEN DAY(c.FechaInicio) = DAY(EOMONTH(c.FechaInicio)) THEN DATEADD(DAY, 1, EOMONTH(c.FechaInicio)) 
            ELSE c.FechaInicio 
        END AS FechaInicio,
        CASE 
            WHEN DAY(c.FechaFin) = 1 THEN DATEADD(DAY, -1, c.FechaFin) 
            ELSE c.FechaFin 
        END AS FechaFin,
        COALESCE(SUM(g.Cantidad), 0) AS SumaCantidad,
        COALESCE(s.SumaVenta, 0) AS SumaVenta,
        ROW_NUMBER() OVER (PARTITION BY c.NuCombustible ORDER BY c.FechaInicio) AS rn
    FROM Consolidated c
    LEFT JOIN ComGasolina g 
        ON c.NuCombustible = g.NuTanque 
        AND  g.Fecha >= c.FechaInicio AND g.Fecha < c.FechaFin
    LEFT JOIN SalesSum s
        ON c.NuCombustible = s.NuCombustible 
        AND c.Precio = s.precioventa 
    GROUP BY c.NuCombustible, c.Descripcion, c.Precio, c.FechaInicio, c.FechaFin, s.SumaVenta
),
Totals AS (
    SELECT 
        NuCombustible, 
        NULL AS Descripcion, 
        NULL AS Precio, 
        NULL AS FechaInicio, 
        NULL AS FechaFin,
        SUM(SumaCantidad) AS SumaCantidad,
        SUM(SumaVenta) AS SumaVenta,
        ROW_NUMBER() OVER (PARTITION BY NuCombustible ORDER BY (SELECT NULL)) + (SELECT COUNT(DISTINCT NuCombustible) FROM Consolidated) AS rn
    FROM FinalResults
    GROUP BY NuCombustible
),
InitialInventory AS (
    SELECT 
        NuCombustible,
        ROUND(inv_inicial, 0) AS inv_inicial
    FROM ERInventarioCombustibleReglaxEStablaVentas_View
    WHERE Fecha >= '2024-04-01' AND Fecha < '2024-05-01'
),
FinalInventory AS (
    SELECT 
        NuCombustible,
        ROUND(inv_final, 0) AS inv_final
    FROM ERInventarioCombustibleReglaxEStablaVentas_View
    WHERE Fecha >= '2024-04-30' AND Fecha < '2024-05-01'
)
SELECT 
    fr.NuCombustible, 
    fr.Descripcion, 
    fr.Precio, 
    CASE 
        WHEN fr.FechaInicio > fr.FechaFin THEN CONVERT(varchar, fr.FechaFin, 103) -- Formato dd/MM/yyyy
        ELSE CONVERT(varchar, fr.FechaInicio, 103) -- Formato dd/MM/yyyy
    END AS FechaInicio,
    CONVERT(varchar, fr.FechaFin, 103) AS FechaFin,
    fr.SumaCantidad,
    ROUND(fr.SumaVenta,0) as venta,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE ii.inv_inicial END AS inv_inicial,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE (ii.inv_inicial + fr.SumaCantidad) END AS Subtotal,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE fi.inv_final END AS inv_final,
    CASE WHEN fr.Descripcion IS NOT NULL THEN NULL ELSE ROUND((fi.inv_final - ((ii.inv_inicial + fr.SumaCantidad) - fr.SumaVenta)), 0) END AS diferencia
FROM (
    SELECT * FROM FinalResults
    UNION ALL
    SELECT * FROM Totals
) AS fr
LEFT JOIN InitialInventory ii
    ON fr.NuCombustible = ii.NuCombustible
LEFT JOIN FinalInventory fi
    ON fr.NuCombustible = fi.NuCombustible
ORDER BY fr.NuCombustible, CASE WHEN fr.Descripcion IS NOT NULL THEN 0 ELSE 1 END, fr.FechaInicio;
        ";
           $resultados = DB::connection($this->coneccion)->select($query);
           $colección = collect($resultados);
           $nombredoc = 'Inventariocombustible.xlsx';
           $estacions=DB::connection($this->coneccion)->table('Estaciones')->first();
           $valorestacionnombre="E.S  ".$estacions->NuES."  ".$estacions->Razon;
       return Excel::download(new ExcelreporteInvCombustibletotal($colección,$valorestacionnombre), $nombredoc);
        }
    }
}

