<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Determinacion de costo promedio por producto 'variable'
            </th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Reporte de {{$fechaInicio}} al {{$fechaFin}}</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">E.S 14159 FUTURO</th>
        </tr>
        <tr>
                <!--compras-->
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Producto</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Fecha</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Inv. Inicial Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Importe Inv. Inicial</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Compras Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Compras Consigna</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Total Compras</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Importe Compras</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Flete</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Total Compras s/Consigna</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Total Compras</th>
                <!--ventas-->
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Venta Litros</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Jarras </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Venta Lts Consigna </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Ventas Netas Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Importe Ventas</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Ajuste Inv. Final</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Costo Ajuste</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Inv. Final Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Costo Promedio</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Importe Inv. Final</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Inv. Inicial Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Inv. Final Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Costo Promedio</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Importe Inv. Final</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @php
                $valorcotoinicial = 346005.27;
            @endphp

            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$invInicial->Inv_Inicial}}</td>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$CostoPromedio}}</th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$valorcotoinicial}}</th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            <th style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></th>
            
        </tr>
        @php
        $fechaInicio2 = \Carbon\Carbon::parse($fechaInicio);
        $fechaFin2 = \Carbon\Carbon::parse($fechaFin);
        $rangoFechas = collect();
        $costopromedioreal=$CostoPromedio;
        // Crea un rango de fechas
        while ($fechaInicio2->lte($fechaFin2)) {
            $rangoFechas->push($fechaInicio2->copy());
            $fechaInicio2->addDay();
        }
    
        // Agrupa los datos por fecha
        $groupedDatos = $datos->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->Fecha)->format('Y-m-d');
        });
    
        // Obtener un valor común de descripcion si está disponible
        $defaultDescripcion = $datos->first() ? $datos->first()->descripcion : 'N/A';
    
        // Combina los datos con el rango de fechas para asegurar que todas las fechas están presentes
        $datosCompletos = $rangoFechas->mapWithKeys(function ($fecha) use ($groupedDatos, $defaultDescripcion) {
            $fechaStr = $fecha->format('Y-m-d');
            $datos = $groupedDatos->get($fechaStr, collect());
    
            // Si la colección de datos está vacía, añade un objeto con valores predeterminados
            if ($datos->isEmpty()) {
                $datos = collect([
                    (object)[
                        'comp_id' => null,
                        'Fecha' => $fechaStr,
                        'idcomprobante' => null,
                        'valorUnitario' => 0,
                        'cantidad' => 0,
                        'descripcion' => $defaultDescripcion,
                        'ComprasCantidad' => 0,
                        'FLETE_SERVICIO' => 0,
                        'TOTAL_CON_FLETE' => 0
                    ]
                ]);
            }
    
            return [
                $fechaStr => [
                    'fecha' => $fechaStr,
                    'datos' => $datos,
                ],
            ];
        });

    //dd($datosCompletos);
        $valorComercializadora='';
        $sumaAcumulativa = $invInicial->Inv_Inicial;
        $totalcompras=0;
        $totalventasTotal=0;
        $sumaCantidadesCompras=0;
        $sumaCantidadesComprasConsigna=0;
        $sumaCantidadescostocompra=0;
        $sumaCantidadescostoflete=0;
        $sumaCantidadescostosinconsigna=0;
        $totalcomprasFinal=0;
        $sumventaslitro=0;
        $sumjarras=0;
        $sumjarrasconsigna=0;
        $sumventastotales=0;
        $sumtotalventas=0;
         // Inicializa la suma acumulativa con el valor inicial
    @endphp
        @foreach ($datosCompletos as $index => $grupo)
        @foreach ($grupo['datos'] as $dato)
        @php
            $valorComercializadora ='Comercializadora '.$dato->descripcion;
            $totalcompras = (($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * (($dato->cantidad ?? 0) + ($dato->ComprasCantidad ?? 0));
            if($totalcompras>0){
              $costopromedioreal=($valorcotoinicial+$totalcompras-$totalventasTotal)/$sumaAcumulativa;
              
            }else{
                $costopromedioreal=$costopromedioreal;
                //dd($costopromedioreal);
            }
           
        @endphp
        <tr>
             <!--compras-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">Comercializadora {{$dato->descripcion}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{\Carbon\Carbon::parse($dato->Fecha)->format('Y-m-d')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->cantidad, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->ComprasCantidad, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->cantidad+$dato->ComprasCantidad, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($dato->valorUnitario, 6, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->FLETE_SERVICIO, 6, '.', ',') }} </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format((($dato->valorUnitario + $dato->FLETE_SERVICIO)*$dato->cantidad), 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($totalcompras, 2, '.', ',')}}</td>
            <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$costopromedioreal}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$valorcotoinicial}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td> 
            
        </tr>
        @php
         $sumaCantidadesCompras +=$dato->cantidad ?? 0;
            $sumaCantidadesComprasConsigna+=$dato->ComprasCantidad ?? 0;
            $sumaCantidadescostocompra+=$dato->valorUnitario ?? 0;
            $sumaCantidadescostoflete+=$dato->FLETE_SERVICIO ?? 0;
            $sumaCantidadescostosinconsigna+= (($dato->valorUnitario ?? 0 + $dato->FLETE_SERVICIO ?? 0)* $dato->cantidad ?? 0);
            $totalcomprasFinal+=$totalcompras ?? 0;
        $sumaAcumulativa += $dato->cantidad+$dato->ComprasCantidad;
        @endphp
        @endforeach
        
        @foreach($ventas as $venta)
        
        @if(\Carbon\Carbon::parse($index)->format('Y-m-d')==\Carbon\Carbon::parse($venta->Fecha)->format('Y-m-d'))
        @php
        
    
        $totalcompras=0;
        if($totalcompras>0){
              $costopromedioreal=($valorcotoinicial+$totalcompras)/$sumaAcumulativa;
              
            }else{
                $costopromedioreal=$costopromedioreal;
            }
            $totalventas=$venta->Venta*$costopromedioreal;
       
        @endphp
        <tr>
             <!--compras-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$valorComercializadora}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$index}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($totalcompras, 2, '.', ',')}}</td>
             <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($venta->Venta-$venta->Jarras-$venta->JarrasConsigna, 2, '.', ',')}}</td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$venta->Jarras}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$venta->JarrasConsigna}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($sumventastotales, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumtotalventas, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$costopromedioreal}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$valorcotoinicial}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
        </tr>
        @php
         $sumventaslitro+=($venta->Venta ?? 0) -($venta->Jarras ?? 0 ) -($venta->JarrasConsigna ?? 0);
        $sumjarras+=$venta->Jarras ?? 0;
        $sumjarrasconsigna+=$venta->JarrasConsigna ?? 0;
        $sumventastotales+=$venta->Venta ?? 0;
        $sumtotalventas+=$totalventas ?? 0;
        $totalventasTotal=$venta->Venta;
       $sumaAcumulativa = $sumaAcumulativa- $venta->Venta;
        @endphp
        
       
        @endif
        @php

    $valorcotoinicial=$sumaAcumulativa*$costopromedioreal;     
        @endphp
        @endforeach
        @endforeach
        <tr>
            @php
            $invfinal=(($invInicial->Inv_Inicial)+($sumaCantidadesCompras+$sumaCantidadesComprasConsigna))-($totalventas);
            @endphp
            <!--totales-->
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaCantidadesCompras, 2, '.', ',')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaCantidadesComprasConsigna, 2, '.', ',')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaCantidadesCompras+$sumaCantidadesComprasConsigna, 2, '.', ',') }}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($sumaCantidadescostocompra, 6, '.', ',') }}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaCantidadescostoflete, 6, '.', ',') }} </td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaCantidadescostosinconsigna, 2, '.', ',')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($totalcomprasFinal, 2, '.', ',')}}</td>
            <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($sumventaslitro, 2, '.', ',')}}</td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$sumjarras}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$sumjarrasconsigna}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($venta->Venta, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($totalventas, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($invfinal, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$costopromedioreal}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$costopromedioreal*$invfinal}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
           
       </tr>
       
    </tbody>
</table>
