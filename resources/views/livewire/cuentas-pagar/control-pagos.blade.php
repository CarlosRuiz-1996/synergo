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
                            class="p-2 border border-gray-300 rounded w-full" placeholder="Selecciona una estación">
                            <option value="">Selecciona una estación...</option>
                            @foreach ($estaciones as $estacion)
                                @if ($estacion->IdEstacion == 153)
                                    <option value="{{ $estacion->IdEstacion }}">{{ $estacion->NombreEstacion }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Campos de entrada para fecha y botón de búsqueda -->
                    <div class="flex space-x-1 items-center">
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
                            <label for="TipoCombustible" class="text-white">Estado de pago</label>
                            <select id="TipoCombustible" wire:model='TipoCombustible'
                                class="p-2 border border-gray-300 rounded w-full">
                                <option value="0">Seleccione</option>
                                <option value="Pagada">Pagada</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Vencida">Vencida</option>
                            </select>
                        </div>
                        <!-- Botón de búsqueda -->
                        <div class="flex flex-col space-y-3 flex-grow pl-2">
                            <button class="bg-blue-500 text-white py-2 px-2 mt-8 rounded hover:bg-blue-700 w-full"
                                wire:click='buscar'>Buscar</button>
                        </div>
                    </div>
                    @if ($estacion_detalle)
                        <div class="flex space-x-1 items-center">
                            <div
                                class="flex-grow p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <div>
                                    <h2><b>Nombre:{{$estacion_detalle->NombreEstacion}}</b></h2>
                                </div>
                                <div>
                                    <h2><b>RFC: {{$estacion_detalle->RFC}}</b></h2>
                                </div>
                                <div>
                                    <h2><b>Domicilio: {{$estacion_detalle->DireccionFiscal}}</b></h2>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>


            </div>

            <!-- Nueva sección: Inventario y Adquisición -->
            <h1 class="text-white mt-8">Detalle</h1>


            <h1 class="text-white mt-8">Monto pagado: {{$monto_pagado}}</h1>
            {{-- <div class="flex flex-col space-y-3 flex-grow pl-2">
                <button class="bg-blue-500 text-white py-2 mt-6 rounded hover:bg-blue-700 w-full"
                    wire:click='exportarExcel'>Exportar Excel</button>
            </div> --}}
            <div class="mt-2">
                <div class="overflow-x-auto shadow-md rounded-lg" wire:init='loadEstaciones'>

                    @if ($detalles)

                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        No. Factura
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Tipo de combustible
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Cantidad en litros
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Estatus del pago
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Ver
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach ($detalles as $detalle)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($detalle->Fecha)->format('Y-m-d') }}

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $detalle->n_factura }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $detalle->combustible }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($detalle->litros, 6) }}

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($detalle->SubTotal, 6) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($detalle->Total, 6) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $detalle->estatus ? 'PAGADA' : 'PENDIENTE' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($detalle->TipoDeComprobante !="P")
                                            <button wire:click="mostrarPdf('{{ asset('storage/archivos_descomprimidos/' . $detalle->estatus . '@1000000000XX0.pdf') }}')" class="text-blue-500 hover:text-blue-700"><span class="mr-1">
                                                <i class="fas fa-file-pdf text-red-500"></i> <!-- Icono de PDF -->
                                            </span></button>                                 
                                            @else
                                                Sin Archivo PDF
                                            @endif
                                            <button wire:click='descargarXML({{$detalle->id}})'>
                                                <span class="mr-1">
                                                    <i class="fas fa-file-code text-green-500"></i> <!-- Icono de XML -->
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>



                        </table>
                        @if ($detalles->hasPages())
                            <div class="px-6 py-3  bg-gray-200">
                                {{ $detalles->links() }}
                            </div>
                        @endif
                    @else
                        @if ($readyToLoad)
                            <h1 class="px-6 py-3 text-gray-500 ">No hay datos disponibles</h1>
                        @else
                            <!-- Muestra un spinner mientras los datos se cargan -->
                            <div class="flex justify-center items-center h-40">
                                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-yellow-500">
                                </div>
                            </div>
                        @endif
                    @endif
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