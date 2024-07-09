<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Inventario Combustible
            </th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">Periodo: del  01/04/2024 al 30/04/2024 </th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #f0f0f0; font-weight: bold;">E.S 14159 FUTURO
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:200%">Producto</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:250%">Periodo</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Precio Venta</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Inv.Inicial regla
            </th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Compras</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Subtotal</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Litros vendidos
            </th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Jarras</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Litros netos</th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Inv.Inicial regla
            </th>
            <th style="border: 1px solid black;background-color: #706e6e;color: #f0f0f0 ;padding: 8px; text-align: center;width:150%">Diferencia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
        <tr>

            <td style="border: 1px solid black; padding: 8px; text-align: center;width:200%">{{ $dato->Descripcion ?? '' }}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:250%">{{ $dato->FechaInicio }}-{{ $dato->FechaFin }}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%"> {{ number_format($dato->Precio, 2)  ?? '' }}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ number_format($dato->inv_inicial,2) }}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ number_format($dato->SumaCantidad) ?? '' }}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ number_format($dato->Subtotal)  ?? ''}}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ number_format($dato->venta, 0)  ?? ''}}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">0</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%"> {{ number_format($dato->venta,0)  ?? ''}}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ number_format($dato->inv_final)  ?? ''}}</td>
        <td style="border: 1px solid black; padding: 8px; text-align: center;width:150%">{{ number_format($dato->diferencia) ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
