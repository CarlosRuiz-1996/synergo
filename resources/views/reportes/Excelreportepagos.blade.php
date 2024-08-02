<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Reporte Pagos
            </th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Periodo: del  {{$fechaInicio}} al {{$fechaFin}} </th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">{{$nombreReporte}}
            </th>
        </tr>
        <tr>
            <tr>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Fecha
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    No. Factura
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Producto
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Proveedor
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Cantidad
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Subtotal
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Total
                </th>
                <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">
                    Estatus del pago
                </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $detalle)
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                {{ \Carbon\Carbon::parse($detalle->Fecha)->format('Y-m-d') }}

            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                {{ $detalle->n_factura }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                {{ $detalle->combustible }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:350%">
                {{ $detalle->nombre_emisor }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                {{ number_format($detalle->litros, 2) }}

            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                {{ number_format($detalle->SubTotal, 2) }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                {{ number_format($detalle->Total, 2) }}
            </td>

            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">
                <b>
                    @if($detalle->estatus == 1)
                        Pagada
                    @elseif($detalle->estatus == 2)
                        Pendiente
                    @elseif($detalle->estatus == 3)
                        Vencida
                    @elseif($detalle->estatus == 4)
                        Cargada Recientemente
                    @else
                        Desconocido
                    @endif
                </b>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
