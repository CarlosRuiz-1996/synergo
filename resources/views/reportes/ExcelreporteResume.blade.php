<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Determinacion de costo promedio por producto {{$nombreProducto}}
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
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Producto</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Fecha</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Inv. Inicial Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Importe Inv. Inicial</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Compras Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Compras Consigna</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Total Compras</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Importe Compras</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Flete</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Total Compras s/Consigna</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Total Compras</th>
                <!--ventas-->
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Venta Litros</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Jarras </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Venta Lts Consigna </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Ventas Netas Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Importe Ventas</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Ajuste Inv. Final</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Costo Ajuste</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Inv. Final Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Costo Promedio</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Importe Inv. Final</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%"></th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Inv. Inicial Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Inv. Final Lts</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Costo Promedio</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Importe Inv. Final</th>
        </tr>
    </thead>
    <tbody>

        @php
        $fechaInicio2 = \Carbon\Carbon::parse($fechaInicio);
        $fechaFin2 = \Carbon\Carbon::parse($fechaFin);
        $rangoFechas = collect();
        $costopromedioreal = $CostoPromedio;
        $totalprimero='$'.number_format($costopromedioreal*$invInicial->Inv_Inicial, 2, '.', ',');
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
        $defaultFecha = $datos->first() ? $datos->first()->Fecha : 'N/A';
        
        // Combina los datos con el rango de fechas para asegurar que todas las fechas están presentes
        $datosCompletos = $rangoFechas->mapWithKeys(function ($fecha) use ($groupedDatos, $defaultDescripcion) {
            $fechaStr = $fecha->format('Y-m-d');
            $datos = $groupedDatos->get($fechaStr, collect());
        
            return [
                $fechaStr => (object) [
                    'fecha' => $fechaStr,
                    'datos' => $datos->map(function ($item) {
                        return is_array($item) ? (object) $item : $item;
                    }),
                ],
            ];
        });
        
        // Verificar si el primer día del rango no tiene datos y agregar un registro vacío
        $firstDate = $rangoFechas->first()->format('Y-m-d');
        if ($datosCompletos[$firstDate]->datos->isNotEmpty()) {
            $datosCompletos[$firstDate]->datos->prepend((object) [
                "comp_id" => "",
                "Fecha" => $defaultFecha,
                "idcomprobante" => 0,
                "valorUnitario" => 0,
                "cantidad" => 0,
                "descripcion" => $defaultDescripcion,
                "FLETE_SERVICIO" => 0,
                "TOTAL_CON_FLETE" => 0,
                "ComprasCantidad" => 0,
                "NuFactura" => $totalprimero,
            ]);
        }
        
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
        $sumacumulativafinal=0;
        $costofinal=0;
        $totalcomprassinconsignas=0;
        //ultimas 4 columnas
        $ininicialfinal= $invInicial->Inv_Inicial;
        $infinalfinal=0;
        $costofinalpromfinal=$CostoPromedio;
        $costofinalcostofinalpromfinal=0;
        $importefinalpromfinal=0;
         // Inicializa la suma acumulativa con el valor inicial
         @endphp
        @foreach ($datosCompletos as $index => $grupo)
        @foreach ($grupo->datos as $dato)
        @php
            $sumacumulativafinal=$sumaAcumulativa+(($dato->cantidad ?? 0) + ($dato->ComprasCantidad ?? 0));
            $valorComercializadora ='Comercializadora '.$dato->descripcion;
            $totalcompras = (($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * (($dato->cantidad ?? 0) + ($dato->ComprasCantidad ?? 0));
            $totalcomprassinconsignas=(($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * ($dato->cantidad ?? 0);
            if($totalcompras>0){
              $costopromedioreal=($costofinal+$totalcompras)/$sumacumulativafinal;
              
            }else{
                $costopromedioreal=$costopromedioreal;
                //dd($costopromedioreal);
            }
            $costofinal=$sumacumulativafinal*$costopromedioreal;
            $sumaCantidadescostosinconsigna += (($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * ($dato->cantidad ?? 0);
            $ininicialfinal=$ininicialfinal;
            $infinalfinal=(($ininicialfinal)+($dato->cantidad ?? 0))-(0-0);
            if($totalcomprassinconsignas>0){
              $costofinalpromfinal=($costofinalcostofinalpromfinal+$totalcomprassinconsignas)/$infinalfinal;
            }else{
                $costofinalpromfinal=$costofinalpromfinal;
                //dd($costopromedioreal);
            }
            $costofinalcostofinalpromfinal=$costofinalpromfinal*$infinalfinal;
        @endphp
        <tr>
             <!--compras-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;text-align: right;">Comercializadora {{$dato->descripcion}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{\Carbon\Carbon::parse($dato->Fecha)->format('d-m-Y')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{$dato->NuFactura}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($dato->cantidad, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: right; width: 100px;">
                {{ $dato->ComprasCantidad != 0 ? number_format($dato->ComprasCantidad, 2, '.', ',') : '' }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($dato->cantidad+$dato->ComprasCantidad, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($dato->valorUnitario, 6, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($dato->FLETE_SERVICIO, 6, '.', ',') }} </td>
            <td style="border: 1px solid black; padding: 8px; text-align: right; width: 100px;">
                {{ (($dato->valorUnitario + $dato->FLETE_SERVICIO) * $dato->cantidad) != 0 ? '$' . number_format((($dato->valorUnitario + $dato->FLETE_SERVICIO) * $dato->cantidad), 2, '.', ',') : '' }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: right; width: 100px;">
                {{ $totalcompras != 0 ? '$' . number_format($totalcompras, 2, '.', ',') : '' }}
            </td>
            <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{ number_format(0, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumacumulativafinal, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($costopromedioreal, 4, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($costofinal, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($ininicialfinal,2,'.',',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($infinalfinal,2,'.',',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($costofinalpromfinal, 4, '.', ',')}}</td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($costofinalcostofinalpromfinal, 2, '.', ',')}}</td> 
            
        </tr>
        @php
         $sumaCantidadesCompras +=$dato->cantidad ?? 0;
            $sumaCantidadesComprasConsigna+=$dato->ComprasCantidad ?? 0;
            $sumaCantidadescostocompra+=$dato->valorUnitario ?? 0;
            $sumaCantidadescostoflete+=$dato->FLETE_SERVICIO ?? 0;
            
            $totalcomprasFinal+=$totalcompras ?? 0;
        $sumaAcumulativa += $dato->cantidad+$dato->ComprasCantidad;
        $ininicialfinal=$infinalfinal;
        $totalprimero='';
        @endphp
        @endforeach
        
        @foreach($ventas as $venta)
        
        @if(\Carbon\Carbon::parse($index)->format('Y-m-d')==\Carbon\Carbon::parse($venta->Fecha)->format('Y-m-d'))
        @php
    
       
        $sumventastotales=$venta->Venta ?? 0;
        $sumacumulativafinal=$sumaAcumulativa- $sumventastotales;
        $totalcons=0;
        $totalcompras=0;
        if($totalcompras>0){
              $costopromedioreal=($valorcotoinicial+$totalcompras)/$sumacumulativafinal;
              
            }else{
                $costopromedioreal=$costopromedioreal;
            }
            $totalventas=$venta->Venta*$costopromedioreal;
            $costofinal=$sumacumulativafinal*$costopromedioreal;
            if($valorComercializadora==""){
                $valorComercializadora='Comercializadora '.$nombreProducto;
            }
            $ininicialfinal=$ininicialfinal;
            $infinalfinal=(($ininicialfinal)+(0))-((($venta->Venta ?? 0)-($venta->Jarras ?? 0) - ($venta->JarrasConsigna ?? 0)-($venta->Jarras ?? 0)));
            if($totalcons>0){
              $costofinalpromfinal=($costofinalcostofinalpromfinal+$totalcons)/$infinalfinal;
            }else{
                $costofinalpromfinal=$costofinalpromfinal;
                //dd($costopromedioreal);
            }
            $costofinalcostofinalpromfinal=$costofinalpromfinal*$infinalfinal;
            $valorinicalprecio=$totalprimero;
        @endphp
        <tr>
             <!--compras-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;text-align: right;">{{$valorComercializadora}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{\Carbon\Carbon::parse($index)->format('d-m-Y')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{$valorinicalprecio}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: right; width: 100px;">
                {{ $totalcompras != 0 ? '$' . number_format($totalcompras, 2, '.', ',') : '' }}
            </td>
             <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($venta->Venta-$venta->Jarras-$venta->JarrasConsigna, 2, '.', ',')}}</td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($venta->Jarras, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{$venta->JarrasConsigna}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($sumventastotales, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{ number_format($totalventas, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumacumulativafinal, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($costopromedioreal, 4, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($costofinal, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($ininicialfinal,2,'.',',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($infinalfinal,2,'.',',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($costofinalpromfinal, 4, '.', ',')}}</td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($costofinalcostofinalpromfinal, 2, '.', ',')}}</td> 
        </tr>
        @php
         $sumventaslitro+=($venta->Venta ?? 0) -($venta->Jarras ?? 0 ) -($venta->JarrasConsigna ?? 0);
        $sumjarras+=$venta->Jarras ?? 0;
        $sumjarrasconsigna+=$venta->JarrasConsigna ?? 0;
        $sumtotalventas+=$totalventas ?? 0;
        $totalventasTotal+=$venta->Venta;
        $sumaAcumulativa = $sumacumulativafinal;
        $ininicialfinal=$infinalfinal;
        $totalprimero='';
        @endphp
        
       
        @endif
        @php

        $valorcotoinicial=$sumaAcumulativa*$costopromedioreal;     
        @endphp
        @endforeach
        @endforeach
        <!--ajustes de inve-->
        <tr>
            @php
            $ajustesinv=$invInicial->Inv_Final-$sumaAcumulativa;
            $invfinalajuste=$ajustesinv+$sumaAcumulativa;
            $costofinalpro=$costofinal/$invfinalajuste;
            $costofinalventsa=$invfinalajuste*$costofinalpro;

            //ultimos 4 datos
            $dato1=$ininicialfinal;
            $dato2=$dato1+$ajustesinv;
            $dato3=$costofinalcostofinalpromfinal/$dato2;
            $dato4=$dato2*$dato3;
           
            @endphp
            <!--totales-->
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;text-align: right;">{{$valorComercializadora}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{\Carbon\Carbon::parse($fechaFin2)->format('d-m-Y')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($ajustesinv, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($invfinalajuste, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($costofinalpro, 4, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($costofinalventsa, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($dato1, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($dato2, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($dato3, 4, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($dato4, 2, '.', ',')}}</td>
           
       </tr>
       <tr>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
        <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
       </tr>

        <tr>
            @php
            $invfinal=(($invInicial->Inv_Inicial)+($sumaCantidadesCompras+$sumaCantidadesComprasConsigna))-($totalventas);
            @endphp
            <!--totales-->
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td> <!-- Muestra la suma acumulativa -->
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">TOTALES</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaCantidadesCompras, 2, '.', ',')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaCantidadesComprasConsigna, 2, '.', ',')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaCantidadesCompras+$sumaCantidadesComprasConsigna, 2, '.', ',') }}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($sumaCantidadescostocompra, 6, '.', ',') }}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($sumaCantidadescostoflete, 6, '.', ',') }} </td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{ number_format($sumaCantidadescostosinconsigna, 2, '.', ',')}}</td>
           <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($totalcomprasFinal, 2, '.', ',')}}</td>
            <!--ventas-->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($sumventaslitro, 2, '.', ',')}}</td> 
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{$sumjarras}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{$sumjarrasconsigna}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($totalventasTotal, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{ number_format($sumtotalventas, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{ number_format($ajustesinv, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($invfinalajuste, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($costofinalpro, 4, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($costofinalventsa, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($dato2, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">{{number_format($dato3, 4, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 100px;text-align: right;">${{number_format($dato4, 2, '.', ',')}}</td>
           
       </tr>
       
    </tbody>
</table>
