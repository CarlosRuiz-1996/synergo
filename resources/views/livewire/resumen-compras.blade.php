<div>
    <div class="flex justify-center min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/bg.png') }}');">
        <div class="w-full max-w-lg"
        style="width: 100%; 
               max-width: 100%; 
               background-color: rgba(157, 175, 191, 0.483); 
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
               border-radius: 1rem; 
               padding: 1.5rem; 
               margin-top: 2rem; 
               margin-bottom: 1.5rem; 
               margin-left: 1.25rem; 
               margin-right: 1.25rem; 
               backdrop-filter: blur(5px);">
            <h2 class="text-2xl font-bold text-white mb-4">Resumen de Costo por Producto</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Aumenté el gap a 6 para mayor separación -->
                <div class="flex flex-col space-y-4">
                    <!-- Campo de entrada para Estación de servicio -->
                    <div class="flex flex-col space-y-3">
                        <label for="estacion" class="text-white">Selecciona una estación de servicio</label>
                        <select wire:model="estacionSeleccionada" id="estacion" name="estacion"
                                class="p-2 border border-gray-300 rounded w-full"
                                placeholder="Selecciona una estación">
                            <option value="">Selecciona una estación...</option>
                            @foreach($estaciones as $estacion)
                                <option value="{{ $estacion->IdEstacion }}">{{ $estacion->NombreEstacion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campos de entrada para fecha y botón de búsqueda -->
                    <div class="flex space-x-4 items-center">
                        <!-- Primer campo de fecha -->
                        <div class="flex flex-col space-y-3 flex-grow px-1">
                            <label for="fechaInicio" class="text-white">Fecha de inicio</label>
                            <input type="date" wire:model='fechainicio'
                                class="p-2 border border-gray-300 rounded w-full">
                        </div>

                        <!-- Segundo campo de fecha -->
                        <div class="flex flex-col space-y-3 flex-grow px-3">
                            <label for="fechaFin" class="text-white">Fecha de fin</label>
                            <input type="date" wire:model='fechafin'
                                class="p-2 border border-gray-300 rounded w-full">
                        </div>
                        <div class="flex flex-col space-y-3 flex-grow px-3">
                            <label for="TipoCombustible" class="text-white">Tipo de combustible</label>
                            <select id="TipoCombustible" wire:model='TipoCombustible' class="p-2 border border-gray-300 rounded w-full">
                                <option value="">Seleccione</option>
                                <option value="PEMEX DIESEL">Pemex Diesel</option>
                                <option value="PEMEX MAGNA">Pemex Magna</option>
                                <option value="PEMEX PREMIUM">Pemex Premium</option>
                            </select>
                        </div>
                        <!-- Botón de búsqueda -->
                        <div class="flex flex-col space-y-3 flex-grow pl-2">
                            <button
                                class="bg-blue-500 text-white py-2 mt-6 rounded hover:bg-blue-700 w-full" wire:click='buscar'>Buscar</button>
                        </div>
                    </div>
                </div>


                <!-- Segunda columna -->
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center flex flex-col items-center space-y-4 flex-grow">
                            <div
                                style="background-color: #34D399; color: #ffffff; display: flex; justify-content: center; align-items: center; width: 4rem; height: 4rem; border-radius: 50%;">
                                <i class="fas fa-gas-pump text-4xl"></i>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-white font-bold">$ 5456146.531651</span>
                            </div>
                        </div>
                        <div class="text-center flex flex-col items-center space-y-4 flex-grow">
                            <div
                                style="background-color: #ad456a; color: #ffffff; display: flex; justify-content: center; align-items: center; width: 4rem; height: 4rem; border-radius: 50%;">
                                <i class="fas fa-gas-pump text-4xl"></i>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-white font-bold">$ 5456146.531651</span>
                            </div>
                        </div>
                        <div class="text-center flex flex-col items-center space-y-4 flex-grow">
                            <div
                                style="background-color: #000000; color: #ffffff; display: flex; justify-content: center; align-items: center; width: 4rem; height: 4rem; border-radius: 50%;">
                                <i class="fas fa-gas-pump text-4xl"></i>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-white font-bold">$ 5456146.531651</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nueva sección: Inventario y Adquisición -->
            <h1 class="text-white mt-8">Compras</h1>
            <div class="flex flex-col space-y-3 flex-grow pl-2">
                <button
                    class="bg-blue-500 text-white py-2 mt-6 rounded hover:bg-blue-700 w-full" wire:click='exportarExcel'>Exportar Excel</button>
            </div>
            <div class="mt-2">
                <div class="overflow-x-auto shadow-md rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Precio
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Flete/Servicio
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Total con Flete
                                </th>
                            </tr>
                        </thead>                 
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($despachos as $despacho)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $despacho->descripcion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($despacho->valorUnitario, 6) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($despacho->cantidad, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($despacho->Fecha)->format('Y-m-d') }}

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($despacho->FLETE_SERVICIO, 6) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($despacho->TOTAL_CON_FLETE, 6) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Nueva sección: Inventario y Adquisición -->
            <h1 class="text-white mt-8">Ventas</h1>
            <div class="mt-2">
                <div class="overflow-x-auto shadow-md rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                  Venta
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Precio Ventas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Jarras
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Jarras/Consigna
                                </th>
                            </tr>
                        </thead>                 
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($ventas as $venta)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $venta->Descripcion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($venta->Fecha)->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $venta->Venta }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($venta->precioventa, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($venta->Jarras, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $venta->JarrasConsigna }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <!-- Aquí va tu contenido anterior, omitido por brevedad -->

                <!-- Sección de la tabla con detalles -->
                <div class="mt-8">
                    <!-- Ajusta el margen top según tu diseño -->
                    <h2 class="text-2xl font-bold text-white mb-4">Detalles</h2>
                    <div class="overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full divide-y divide-gray-200">
                            <!-- Encabezados de la tabla -->
                            <thead class="bg-gray-100 text-center">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Detalle 1</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Detalle 2</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Detalle 3</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Detalle 4</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Detalle 5</th>
                                </tr>
                            </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Ejemplo de una fila de datos -->
                                    <tr class="text-center">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <div class="flex items-center justify-center space-x-3">
                                                <div class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center justify-center space-x-3">
                                                <div class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <div class="flex items-center justify-center space-x-3">
                                                <div class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center justify-center space-x-3">
                                                <div class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <div class="flex items-center justify-center space-x-3">
                                                <div class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                <div class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Puedes agregar más filas de datos según sea necesario -->
                                </tbody>                        
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>