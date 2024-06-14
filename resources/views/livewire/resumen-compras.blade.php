<div>
    <div class="flex justify-center min-h-screen relative bg-cover bg-center" style="background-image: url('{{ asset('img/bg.png') }}');">
        <div class="w-screen md:w-4/4 mt-28 m-5">
            <h1 class="text-white text-2xl font-bold mb-5">Ventas consigna</h1>
    <div class="flex mb-4">
        <input type="date" placeholder="Fecha inicial" class="mr-2" wire:model="fechainicio">
        <input type="date" placeholder="Fecha final" class="mr-2" wire:model="fechafin">
        <button wire:click='buscar' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aplicar Filtro</button>
        <button wire:click="exportarExcel" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Exportar a Excel
        </button>
        <button wire:click="exportarTxt" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
            Exportar a TXT
        </button>
        <button wire:click="insertarBase" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
            Insertar XML
        </button>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-screen divide-y divide-gray-200">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Fecha</th>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Cantidad</th>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Descripción</th>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Valor Unitario</th>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Importe</th>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Flete Servicio</th>
                    <th scope="col" class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Total con Flete</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($despachos as $dato)
                <tr class="border-b">
                    <td class="py-2 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($dato->Fecha)->format('Y-m-d') }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $dato->cantidad }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $dato->descripcion }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $dato->valorUnitario }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $dato->importe }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $dato->FLETE_SERVICIO }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $dato->TOTAL_CON_FLETE }}</td>
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
