<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Ventas Consigna</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Reporte de {{$fechaInicio}} al {{$fechaFin}}</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">E.S 14159 FUTURO</th>
        </tr>
        <tr>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Clave Producto</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:150%">Descripción</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:200%">Fecha</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:150%">Importe</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:150%">Litros</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:150%">Autorización</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:150%">Precio Venta</th>
            <th style="border: 1px solid black;background-color: #706e6e; color: #f0f0f0 ; padding: 8px; text-align: center;width:150%">No. Turno</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
                {{ $dato->NuCombustible ?? '' }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
                {{ $dato->Descripcion ?? '' }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 200%">
                {{ $dato->FecIni }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
               $ {{ number_format($dato->Importe, 2) }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
                {{ number_format($dato->Litros, 2) }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
                {{ $dato->Autorizacion }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
              $  {{ number_format($dato->Precio, 2) }}
            </td>
            <td style="border: 1px solid black; padding: 8px; text-align: left; width: 150%;text-align: center;">
                {{ $dato->Turno }}
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
