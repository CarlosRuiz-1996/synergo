<div>
    <div class="flex justify-center min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/bg.png') }}');">
        <div class="w-full max-w-lg"
            style="width: 100%; max-width: 100%; background-color: rgba(157, 175, 191, 0.483); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 1.5rem; margin-top: 2rem; margin-bottom: 1.5rem; margin-left: 1.25rem; margin-right: 1.25rem; backdrop-filter: blur(5px);">
            <h2 class="text-2xl font-bold text-white mb-4">
                <a href="{{ route('dashboard') }}" title="ATRAS" class="me-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
                Recepción de pagos
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                <!-- Columna 1: Select y botón de búsqueda -->
                <div class="flex flex-col space-y-2">
                    <!-- Select múltiple de estaciones -->
                    <div wire:ignore>
                        <div class="flex flex-col">
                            <label for="estacion" class="text-white">Selecciona una estación de servicio</label>
                            <select multiple wire:model="estacionSeleccionada" id="estacion" name="estacion"
                                class="border border-gray-300 rounded select2 w-full"
                                placeholder="Selecciona una estación">
                                <option value="">Selecciona una estación...</option>
                                @foreach ($estaciones as $estacion)
                                <option value="{{ $estacion->IdEstacion }}">
                                    {{ $estacion->IdEstacion . ' - ' . $estacion->NombreEstacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Select múltiple de proveedores -->
                    <div wire:ignore>
                        <div class="flex flex-col">
                            <label for="proveedor" class="text-white">Selecciona un proveedor</label>
                            <select wire:model="proveedor" id="proveedor" name="proveedor"
                                class="border border-gray-300 rounded select2 w-full"
                                placeholder="Selecciona un proveedor">
                                <option value="">Selecciona un proveedor...</option>
                                @foreach ($uniqueEmisors as $emisor)
                                <option value="{{ $emisor }}">{{ $emisor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Botón de búsqueda -->
                    <div class="flex items-center">
                        <button type="button"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full"
                            wire:click='buscar'>Buscar</button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto shadow-md rounded-lg mt-2 max-h-96">
                @if ($sinseleccionarestacion)
                <div style="overflow-y: auto; max-height: 500px; border: 1px solid #e5e7eb; margin-top: 10px;">
                    <table class="w-full divide-y divide-gray-200" style="height: 25%">
                        <thead style="position: sticky; top: 0; background-color: #f3f4f6; z-index: 1;">
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
                            Producto
                        </th>
                        <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Estación
                    </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Proveedor
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                            Cantidad
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
                    @foreach ($estaciondtodos as $connection => $results)
                        @foreach ($results as $result)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($result->Fecha)->format('Y-m-d') }}

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $result->n_factura }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" style="word-break: break-word;">
                                {{ $result->combustible }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" style="word-break: break-word;">
                                {{ $result->razon }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" style="word-break: break-word;">
                                {{ $result->nombre_emisor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($result->litros, 2) }}

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($result->SubTotal, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($result->Total, 2) }}
                            </td>

                            <td class="px-6 py-4  text-sm {{ 
                                $result->estatus == 1 ? 'text-green-500' : 
                                ($result->estatus == 2 ? 'text-yellow-500' : 
                                ($result->estatus == 3 ? 'text-red-500' : 'text-gray-500')) }}" style="word-break: break-word;">
                                <b>
                                    @if($result->estatus == 1)
                                        Pagada
                                    @elseif($result->estatus == 2)
                                        Pendiente
                                    @elseif($result->estatus == 3)
                                        Vencida
                                    @elseif($result->estatus == 4)
                                        Cargada Recientemente
                                    @else
                                        Desconocido
                                    @endif
                                </b>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($result->TipoDeComprobante != 'P')
                                <button
                                    wire:click="abrirmodalpdf({{ $result->id }})"
                                    class="text-blue-500 hover:text-blue-700"><span class="mr-1">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        <!-- Icono de PDF -->
                                    </span></button>
                                @else
                                Sin Archivo PDF
                                @endif
                                <button wire:click='descargarXML({{ $result->id }})'>
                                    <span class="mr-1">
                                        <i class="fas fa-file-code text-green-500"></i>
                                    </span>
                                </button>
                                @if($result->estatus == 2)
                                <button wire:click='enviaraTesoreriaTodos({{ $result->id }},"{{$connection}}")' title="aceptar pago">
                                    <span class="mr-1">
                                        <i class="fas fa-coins text-yellow-500"></i>
                                    </span>
                                </button>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                </tbody>
            </table>
            @endif
        </div>

            <!-- Cards para mostrar estaciond si sinseleccionarestacion está en false -->
            @if (!$sinseleccionarestacion && $estaciond)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full mt-5">
                @foreach ($estaciond as $stationId => $data)
                <div class="flex items-start bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-6">
                    <div class="flex-grow">
                        @foreach ($data as $item)
                        <div class="grid grid-cols-4 gap-6 mb-4 items-center">
                            <div class="col-span-3">
                                <h2><b>Razón Social: {{ $item->Razon }}</b></h2>
                                <h2><b>RFC: {{ $item->RFC }}</b></h2>
                                <h2><b>Dirección: {{ $item->Direccion }}, {{ $item->Colonia }}, {{ $item->Estado }}, {{ $item->CP }}</b></h2>
                                <h2><b>Monto: {{ number_format($item->monto_pagado, 2) }}</b></h2>
                                <h2><b>Total de Facturas: {{ $item->total_facturas }}</b></h2>
                            </div>
                            <div class="col-span-1 flex items-center justify-center">
                                <x-button wire:click='abrirModal({{ $stationId }})'>Detalles</x-button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
    <x-dialog-modal id="modal-compras" maxWidth="4xl" wire:model="showModal">
        <x-slot name="title" class="bg-gray-200">
            {{$nombre_reporte}}
        </x-slot>

        <x-slot name="content">
            <div class="mt-2 mb-2">
                <div class="flex flex-row space-x-4 px-1">
                    <!-- Primer campo de fecha -->
                    <div class="flex flex-col space-y-2 flex-grow">
                        <label for="fechaInicio" class="text-black">Fecha de inicio</label>
                        <input type="date" wire:model='fechainicio' class="p-2 border border-gray-300 rounded w-full">
                    </div>

                    <!-- Segundo campo de fecha -->
                    <div class="flex flex-col space-y-2 flex-grow">
                        <label for="fechaFin" class="text-black">Fecha de fin</label>
                        <input type="date" wire:model='fechafin' class="p-2 border border-gray-300 rounded w-full">
                    </div>
                    <!-- Botón de búsqueda -->
                    <div class="flex flex-col flex-grow">
                        <label for="fechaFin"
                            class="text-white mt-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button class="bg-blue-500 text-white py-2 rounded hover:bg-blue-700 w-full mt-2"
                            wire:click='obtenerDatosdos'>Buscar</button>
                    </div>
                    <div class="flex flex-col space-y-2 flex-grow pl-2">
                        <label for="fechaFin"
                            class="text-white mt-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button class="text-white py-2 mt-2 rounded w-full" style="background-color: green;"
                            wire:click='exportarExcel'>Exportar Excel</button>
                    </div>
                </div>
                <div class="flex justify-between items-center shadow-md rounded-lg mt-2 bg-gray-200">
                    <div class="text-center w-full">
                        <span class="font-bold">Monto:</span>
                        <div class="text-lg mt-1 text-green-600">$ {{ number_format($monto_pagado, 2) }}</div>
                    </div>
                    <div class="text-center  w-full">
                        <span class="font-bold">Total Facturas:</span>
                        <div class="text-lg text-green-600 mt-1"> {{ $total_facturas}}</div>
                    </div>
                </div>
                <div style="overflow-y: auto; max-height: 500px; border: 1px solid #e5e7eb; margin-top: 10px;">
                    @if (count($datos) > 0)
                        <table class="w-full divide-y divide-gray-200" style="height: 25%">
                            <thead style="position: sticky; top: 0; background-color: #f3f4f6; z-index: 1;">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    No. Factura
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Estación
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Proveedor
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Subtotal
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Estatus del pago
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left  text-xs text-gray-700 uppercase tracking-wider">
                                    Ver
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 w-full">

                            @foreach ($datos as $detalle)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($detalle->Fecha)->format('Y-m-d') }}

                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $detalle->n_factura }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500" style="word-break: break-word;">
                                    {{ $detalle->combustible }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500" style="word-break: break-word;">
                                    {{ $detalle->razon }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500" style="word-break: break-word;">
                                    {{ $detalle->nombre_emisor }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($detalle->litros, 2) }}

                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($detalle->SubTotal, 2) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($detalle->Total, 2) }}
                                </td>

                                <td class="px-4 py-4 text-sm {{ 
                                    $detalle->estatus == 1 ? 'text-green-500' : 
                                    ($detalle->estatus == 2 ? 'text-yellow-500' : 
                                    ($detalle->estatus == 3 ? 'text-red-500' : 'text-gray-500')) }}" style="word-break: break-word;">
                                    <b>
                                        @if($detalle->estatus == 1)
                                            Pagada
                                        @elseif($detalle->estatus == 2)
                                            Pendiente
                                        @elseif($detalle->estatus == 3)
                                            Vencida
                                        @elseif($detalle->estatus == 4)
                                            Cargada Recientemente
                                        @else
                                            Desconocido
                                        @endif
                                    </b>
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($detalle->TipoDeComprobante != 'P')
                                    <button
                                        wire:click="abrirmodalpdf({{ $detalle->id }})"
                                        class="text-blue-500 hover:text-blue-700"><span class="mr-1">
                                            <i class="fas fa-file-pdf text-red-500"></i>
                                            <!-- Icono de PDF -->
                                        </span></button>
                                    @else
                                    Sin Archivo PDF
                                    @endif
                                    <button wire:click='descargarXML({{ $detalle->id }})'>
                                        <span class="mr-1">
                                            <i class="fas fa-file-code text-green-500"></i>
                                        </span>
                                    </button>
                                    @if($detalle->estatus == 2)
                                    <button wire:click='enviaraTesoreria({{ $detalle->id }})' title="aceptar pago">
                                        <span class="mr-1">
                                            <i class="fas fa-coins text-yellow-500"></i>
                                        </span>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>



                    </table>
                    <div class="m-4 py-4 px-4">
                        <!-- Renderiza los enlaces de paginación -->
                        {{ $datos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button x-on:click="show = false"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cerrar
            </button>
        </x-slot>
    </x-dialog-modal>


<!-- Modal de facturas cargadas -->
<x-dialog-modal id="modal-facturas" maxWidth="4xl" wire:model="showModalFacturas">
    <x-slot name="title" class="bg-gray-200">
        FACTURAS CARGADAS
    </x-slot>

    <x-slot name="content">
        <button class="bg-green-500 hover:bg-green-300 text-white font-bold py-2 px-4 rounded"
            wire:click='exportarExcelFacturas'>Exportar</button>
        <div class="mt-2 max-h-96 overflow-y-auto"> <!-- Ajuste para hacer scrollable el contenido -->
            <!-- Tabla para facturas rechazadas -->
            @if($ArchivosFallados->isNotEmpty())
            <div class="overflow-x-auto shadow-md rounded-lg mt-2">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Folio</th>
                            <th class="border px-4 py-2">Concepto</th>
                            <th class="border px-4 py-2">Emisor</th>
                            <th class="border px-4 py-2">Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ArchivosFallados as $factura)
                        <tr>
                            <td class="border px-4 py-2">{{ $factura['folio'] }}</td>
                            <td class="border px-4 py-2">{{ $factura['descripcion'] }}</td>
                            <td class="border px-4 py-2">{{ $factura['nombre_emisor'] }}</td>
                            <td class="border px-4 py-2">Factura con este folio ya existe, y fue omitida.</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
    
            <!-- Tabla para facturas aceptadas -->
            @if($ArchivosAceptados->isNotEmpty())
            <div class="overflow-x-auto shadow-md rounded-lg mt-2">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Folio</th>
                            <th class="border px-4 py-2">Concepto</th>
                            <th class="border px-4 py-2">Emisor</th>
                            <th class="border px-4 py-2">Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ArchivosAceptados as $factura)
                        <tr>
                            <td class="border px-4 py-2">{{ $factura['folio'] }}</td>
                            <td class="border px-4 py-2">{{ $factura['descripcion'] }}</td>
                            <td class="border px-4 py-2">{{ $factura['nombre_emisor'] }}</td>
                            <td class="border px-4 py-2">Factura registrada correctamente</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="footer">
        <button wire:click="$set('showModalFacturas', false)"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>

<!-- Modal de facturas cargadas -->
<x-dialog-modal id="modal-facturasPDF" maxWidth="4xl" wire:model="showModalFacturaspdf">
    <x-slot name="title" class="bg-gray-200">
        FACTURA PDF
    </x-slot>

    <x-slot name="content">
        @if ($pdfPath)
            <iframe src="{{ asset($pdfPath) }}" 
                    type="application/pdf" 
                    width="100%" 
                    height="600px">
            </iframe>
        @else
            <p>No se encontró el archivo PDF.</p>
        @endif
    </x-slot>

    <x-slot name="footer">
        <button wire:click="$set('showModalFacturaspdf', false)"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>


    <script>
        $(document).ready(function() {
            $('#estacion').select2();
            $('#proveedor').select2();
        });
        $('#estacion').on('change', function() {
            var estacionSeleccionada = $(this).val();
            @this.set('estacionSeleccionada', estacionSeleccionada)
            // Aquí puedes hacer lo que necesites con el valor seleccionado, como enviarlo a través de Livewire
        });
        $('#proveedor').on('change', function() {
            var proveedor = $(this).val();
            @this.set('proveedor', proveedor)
            // Aquí puedes hacer lo que necesites con el valor seleccionado, como enviarlo a través de Livewire
        });
    </script>

</div>