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
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">Numero Recepción</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">Fecha Recepción</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">No. Factura</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">No. Tanque</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">Producto</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">Litros Factura</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">Importe</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->NuRec ?? '' }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Fecha ?? '' }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->NuFactura }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->NuTanque }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Descripcion }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Cantidad }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 300px;">{{ number_format($dato->Importe, 2, '.', ',') }} </td>
        </tr>
        @endforeach
    </tbody>
</table>
