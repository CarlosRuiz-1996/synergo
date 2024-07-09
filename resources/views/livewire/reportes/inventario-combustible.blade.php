<div>
    <!-- resources/views/livewire/ventas-component.blade.php -->
 <div class="flex justify-center min-h-full relative bg-cover bg-center">
     <div class="w-full md:w-4/4 m-1">
         <h1 class="text-white text-2xl font-bold mb-5">Invntario Combustible</h1>
         
         <!-- Formulario para filtros -->
             <div class="flex mb-4">
                <select wire:model="selectedMonth">
                    <option value="">Seleccione un mes</option>
                    @foreach ([
                        '01' => 'Enero',
                        '02' => 'Febrero',
                        '03' => 'Marzo',
                        '04' => 'Abril',
                        '05' => 'Mayo',
                        '06' => 'Junio',
                        '07' => 'Julio',
                        '08' => 'Agosto',
                        '09' => 'Septiembre',
                        '10' => 'Octubre',
                        '11' => 'Noviembre',
                        '12' => 'Diciembre',
                    ] as $value => $month)
                        <option value="{{ $value }}">{{ $month }}</option>
                    @endforeach
                </select>
                 <button wire:click='encontrarInventario' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aplicar Filtro</button>
                 <button wire:click="exportarExcel" style="background-color: #15803d" class="text-white font-bold py-2 px-4 rounded" >
                     Exportar a Excel
                 </button>
             </div>
             <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="w-full table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Producto</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Periodo</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Precio Venta</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Inv.Inicial regla</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Compras</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Subtotal</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Litros vendidos</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Jarras</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Litros netos</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Inv.Inicial regla</th>
                            <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Diferencia</th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($inv as $despacho)
                            <tr class="border-b">
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->Descripcion ?? '' }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->FechaInicio }}-{{ $despacho->FechaFin }}</td>
                                <td class="py-2 px-4 whitespace-nowrap"> {{ number_format($despacho->Precio, 2) }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->inv_inicial }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->SumaCantidad ?? '' }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->Subtotal }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ number_format($despacho->venta, 0) }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">0</td>
                                <td class="py-2 px-4 whitespace-nowrap"> {{ number_format($despacho->venta,0) }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->inv_final }}</td>
                                <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->diferencia }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        
     </div>
 </div>
 </div>
 