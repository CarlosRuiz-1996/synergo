<div>
    <div class="flex justify-center min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/bg.png') }}');">
        <div class="w-full max-w-lg" style="width: 100%; 
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
                        <label for="estacion" class="text-white">Estación de servicio</label>
                        <input type="text" id="estacion" name="estacion"
                            class="p-2 border border-gray-300 rounded w-full"
                            placeholder="Ingrese estación de servicio">
                    </div>

                    <!-- Campos de entrada para fecha y botón de búsqueda -->
                    <div class="flex space-x-4 items-center">
                        <!-- Primer campo de fecha -->
                        <div class="flex flex-col space-y-3 flex-grow px-1">
                            <label for="fechaInicio" class="text-white">Fecha de inicio</label>
                            <input type="date" wire:model="fechaInicio"
                                class="p-2 border border-gray-300 rounded w-full">
                        </div>

                        <!-- Segundo campo de fecha -->
                        <div class="flex flex-col space-y-3 flex-grow px-3">
                            <label for="fechaFin" class="text-white">Fecha de fin</label>
                            <input type="date" wire:model="fechaFin"
                                class="p-2 border border-gray-300 rounded w-full">
                        </div>

                        <!-- Botón de búsqueda -->
                        <div class="flex flex-col space-y-3 flex-grow pl-2">
                            <button
                                class="bg-blue-500 text-white py-2 mt-6 rounded hover:bg-blue-700 w-full" wire:click="datos">Buscar</button>
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
            <h1 class="text-white mt-8">Inventario y Adquisición</h1>
            <div class="mt-2">
                <div class="overflow-x-auto shadow-md rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    <button wire:click="descargarSeleccionados" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        <i class="fas fa-download text-blue-600 hover:text-blue-700 cursor-pointer"></i>
                                    </button>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="mr-1">
                                            <i class="fas fa-file-pdf text-red-500"></i> <!-- Icono de PDF -->
                                        </span>
                                        PDF 
                                        <input type="checkbox" id="selectAllPDF" wire:model="selectAllPDF" wire:click="toggleSelectAllPDF">  
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="mr-1">
                                            <i class="fas fa-file-code text-green-500"></i> <!-- Icono de XML -->
                                        </span>
                                        XML 
                                        <input type="checkbox" id="selectAllXML" wire:model="selectAllXML" wire:click="toggleSelectAllXML">
                                    </div>
                                </th>                                
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Folio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Serie</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tipo de Comprobante</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Vista</th>
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($Comprobantes as $comprobante)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <button wire:click="descargarPorID({{ $comprobante->id }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <i class="fas fa-download text-blue-600 hover:text-blue-700 cursor-pointer"></i>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if($comprobante->TipoDeComprobante !="P")
                                        <input type="checkbox" class="pdf-checkbox" wire:model="selectedPDF.{{ $comprobante->id }}">                                        
                                        @else
                                            Sin Archivo PDF
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        
                                        <input type="checkbox" class="xml-checkbox" wire:model="selectedXML.{{ $comprobante->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $comprobante->Fecha }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $comprobante->folio }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $comprobante->Serie }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $comprobante->TipoDeComprobante }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $comprobante->Total }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($comprobante->TipoDeComprobante !="P")
                                        <button wire:click="mostrarPdf('{{ asset('storage/archivos_descomprimidos/' . $comprobante->UUID . '@1000000000XX0.pdf') }}')" class="text-blue-500 hover:text-blue-700">Detalle</button>                                 
                                        @else
                                            Sin Archivo PDF
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                                        <!-- Paginación -->
                                        @if(count($Comprobantes)>0)
                                        <div class="mt-4">
                                            {{ $Comprobantes->links() }}
                                        </div>
                                        @endif
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
                                            <div class="ml-2"
                                                style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center justify-center space-x-3">
                                            <div class="ml-2"
                                                style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center justify-center space-x-3">
                                            <div class="ml-2"
                                                style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center justify-center space-x-3">
                                            <div class="ml-2"
                                                style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center justify-center space-x-3">
                                            <div class="ml-2"
                                                style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            <div class="ml-2"
                                                style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
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

    <!-- Modal para mostrar PDF -->
    @if($isOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Este elemento es necesario para centrar el contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    PDF Detalle
                                </h3>
                                <div class="mt-2">
                                    <embed src="{{ $pdfUrl }}" type="application/pdf" class="w-full" height="500px" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" wire:click="closeModal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
