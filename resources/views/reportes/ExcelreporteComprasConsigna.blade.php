<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Compras Consigna</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Reporte de {{$fechaInicio}} al {{$fechaFin}}</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">{{$nombreestacion}}</th>
        </tr>
        <tr>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Numero Recepción</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">Fecha Recepción</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">No. Factura</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">No. Tanque</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">Producto</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Litros Factura</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:100%">Importe</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ $dato->NuRec ?? '' }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; width: 200%">
                {{ isset($dato->Fecha) ? \Carbon\Carbon::parse($dato->Fecha)->format('d/m/Y') : '' }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ $dato->NuFactura }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ $dato->NuTanque }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">{{ $dato->Descripcion }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ $dato->Cantidad }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; width: 100px;">{{ number_format($dato->Importe, 2, '.', ',') }} </td>
        </tr>
        @endforeach
    </tbody>
</table>
