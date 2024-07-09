<div>
    <!-- resources/views/livewire/ventas-component.blade.php -->
 
 <div class="flex justify-center min-h-full relative bg-cover bg-center">
     <div class="w-full md:w-4/4 m-1">
         <h1 class="text-white text-2xl font-bold mb-5">Ventas consigna</h1>
         
         <!-- Formulario para filtros -->
             <div class="flex mb-4">
                 <input type="date" placeholder="Fecha inicial" class="mr-2" wire:model="fechainicio">
                 <input type="date" placeholder="Fecha final" class="mr-2" wire:model="fechafin">
                 <button wire:click='buscar' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aplicar Filtro</button>
                 <button wire:click="exportarExcel" style="background-color: #15803d" class="text-white font-bold py-2 px-4 rounded" >
                     Exportar a Excel
                 </button>
             </div>
         <div class="overflow-x-auto bg-white rounded-lg shadow-md">
             <table class="w-full divide-y divide-gray-200">
                 <thead class="bg-gray-100">
                     <tr>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Numero Recepción</th>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Fecha Recepción</th>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">No. Factura</th>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">No. Tanque</th>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Producto</th>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Litros Factura</th>
                         <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Importe</th>
                     </tr>
                 </thead>
                 <tbody class="bg-white divide-y divide-gray-200">
                     @foreach($despachos as $despacho)
                         <tr class="border-b">
                             <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->NuRec ?? '' }}</td>
                             <td class="py-2 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($despacho->Fecha)->format('Y-m-d') }}</td>
                             <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->NuFactura }}</td>
                             <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->NuTanque }}</td>
                             <td class="py-2 px-4 whitespace-nowrap">{{ $despacho->Descripcion }}</td>
                             <td class="py-2 px-4 whitespace-nowrap">{{ number_format($despacho->Cantidad, 2, '.', ',') }}</td>
                             <td class="py-2 px-4 whitespace-nowrap">{{ number_format($despacho->Importe, 2, '.', ',') }}</td>
                         </tr>
                        
                     @endforeach
                 </tbody>
             </table>
         </div>
         <div class="mt-4">
             <!-- Renderiza los enlaces de paginación -->
             {{ $despachos->links() }}
         </div>
     </div>
 </div>
 </div>
 