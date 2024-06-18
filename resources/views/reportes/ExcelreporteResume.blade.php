<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Texto de la primera fila de encabezado</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Reporte de {{$fechaInicio}} al {{$fechaFin}}</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Texto de la tercera fila de encabezado</th>
        </tr>
        <tr>

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
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Venta Litros</th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:150%">Jarras Venta Lts Consigna</th>
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
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$invInicial->Inv_Inicial}}</td>
            
        </tr>
        @php
            $sumaAcumulativa = $invInicial->Inv_Inicial; // Inicializa la suma acumulativa con el valor inicial
        @endphp
        @foreach ($datos as $dato)
        
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">Comercializadora {{$dato->descripcion}}--{{$dato->TOTAL_CON_FLETE}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{$dato->Fecha}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->cantidad, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->ComprasCantidad, 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->cantidad+$dato->ComprasCantidad, 2, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{number_format($dato->valorUnitario, 6, '.', ',') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format($dato->FLETE_SERVICIO, 6, '.', ',') }} </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;">{{ number_format((($dato->valorUnitario + $dato->FLETE_SERVICIO)*$dato->cantidad), 2, '.', ',')}}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150px;"></td>
           
        </tr>
        @php
            $sumaAcumulativa += $dato->cantidad;
        @endphp
        @endforeach
        
       
    </tbody>
</table>
