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
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: left;width:300%">Clave Producto</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">Descripción</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">Fecha</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">Importe</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">Litros</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">Autorización</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">Precio Venta</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: left;width:300%">No. Turno</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->NuCombustible ?? '' }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Descripcion ?? '' }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->FecIni }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Importe }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Litros }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Autorizacion }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Precio }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: left;width:300%">{{ $dato->Turno }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
