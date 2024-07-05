<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Texto de la primera fila de encabezado
            </th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Reporte de {{$fechaInicio}} al
                {{$fechaFin}}</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Texto de la tercera fila de encabezado
            </th>
        </tr>
        <tr>
            <th
                style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">
                Gas</th>
            <th
                style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">
                Fecha</th>
            <th
                style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">
                Precio</th>
            <th
                style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">
                Cantidad</th>
        </tr>
    </thead>
    <tbody>

        @foreach($datos as $despacho)
        <tr class="border-b">
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $despacho->NuCombustible?? '' }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{\Carbon\Carbon::parse($despacho->Fecha)->format('Y-m-d') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $despacho->precioventa }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $despacho->JarrasConsigna}}</td>
        </tr>
        @endforeach
    </tbody>
</table>