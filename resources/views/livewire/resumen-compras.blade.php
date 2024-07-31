<div>
    <div class="flex justify-center min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/bg.png') }}');">
        <div class="w-full max-w-lg" style="width: 100%;max-width: 100%;background-color: rgba(157, 175, 191, 0.483);box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);border-radius: 1rem;padding: 1.5rem;margin-top: 2rem; margin-bottom: 1.5rem; margin-left: 1.25rem; margin-right: 1.25rem; backdrop-filter: blur(5px);">
            <h2 class="text-2xl font-bold text-white mb-4">
                <a href="{{ route('dashboard') }}" title="ATRAS" class="me-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
                Determinacion de costo promedio
            </h2>
            <div class="flex flex-col space-y-1">
                <div class="flex items-center justify-between space-x-1">
                    <!-- Contenedor de inputs y botón a la izquierda -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-3/4">
                        <!-- Campo de entrada para Estación de servicio -->
                        <div wire:ignore class="flex flex-col space-y-4">
                            <div class="flex flex-col space-y-3">
                                <label for="estacion" class="text-white">Selecciona estación</label>
                                <select wire:model="EstacionSeleccionada" id="EstacionSeleccionada" name="EstacionSeleccionada"
                                    class="select2 p-2 border border-gray-300 rounded w-full" placeholder="Selecciona una estación">
                                    <option value="">Selecciona una estación...</option>
                                    @foreach ($estaciones as $estacion)
                                        <option value="{{ $estacion->IdEstacion }}">{{ $estacion->estacion }}--{{ $estacion->NombreEstacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Campo de entrada para Tipo de combustible -->
                        <div wire:ignore class="flex flex-col space-y-4">
                            <div class="flex flex-col space-y-3">
                                <label for="TipoCombustible" class="text-white">Tipo de combustible</label>
                                <select id="TipoCombustible" wire:model='TipoCombustible' class="select2 p-2 border border-gray-300 rounded w-full">
                                    <option value="">Seleccione</option>
                                    <option value="PEMEX DIESEL">Pemex Diesel</option>
                                    <option value="PEMEX MAGNA">Pemex Magna</option>
                                    <option value="PEMEX PREMIUM">Pemex Premium</option>
                                </select>
                            </div>
                        </div>
                        <!-- Botón de búsqueda -->
                        <div class="flex flex-col space-y-4 mt-2">
                            <button class="bg-blue-500 text-white py-1 mt-6 rounded hover:bg-blue-700 w-full" wire:click='buscar'>Buscar</button>
                        </div>
                    </div>
            
                    <!-- Contenedor de la tabla a la derecha -->
                    <div class="w-1/4 overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full divide-y divide-gray-200 text-center text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-200 px-2 py-1">GAS</th>
                                    <th class="border border-gray-200 px-2 py-1">C/PROMEDIO</th>
                                    <th class="border border-gray-200 px-2 py-1">VENTAS</th>
                                    <th class="border border-gray-200 px-2 py-1">COMPRAS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($totalesValores as $resultado)
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-1">{{ $resultado->descripcion }}</td>
                                        <td class="border border-gray-200 px-2 py-1">{{ $resultado->PromedioValorUnitario }}</td>
                                        <td class="border border-gray-200 px-2 py-1">{{ $resultado->TotalCantidad }}</td>
                                        <td class="border border-gray-200 px-2 py-1">{{ $resultado->SumaEntregueRecibi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
                
            <div>
                <!-- Aquí va tu contenido anterior, omitido por brevedad -->
                @if($EstacionSeleccionada  =='153' || $EstacionSeleccionada  =='141' || $EstacionSeleccionada  =='143')
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
                                        Reporte Resumen</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Reporte Consigna</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Reporte Venta Consigna</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Reporte Inv.Combustible</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Reporte Inv.Combustible Total</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Reporte Inv.Consigna</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Ejemplo de una fila de datos -->
                                <tr class="text-center">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center justify-center space-x-3">
                                            @if($reportesSeleccion==1)
                                            <div  wire:click="abrirModalResumen(1)" class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            @elseif($reportesSeleccion==3)
                                            <div  wire:click="abrirModalResumen(3)" class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            @elseif($reportesSeleccion==2)
                                            <div  wire:click="abrirModalResumen(2)" class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-gas-pump text-xs"></i>
                                            </div>
                                            @else
                                              Sin Información para mostrar  
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center justify-center space-x-3">
                                            @if ($reportesSeleccion == 1)
                                                <div wire:click="abrirModal(1)" class="ml-2"
                                                    style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            @elseif($reportesSeleccion == 3)
                                                <div wire:click="abrirModal(3)" class="ml-2"
                                                    style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            @elseif($reportesSeleccion == 2)
                                                <div wire:click="abrirModal(2)" class="ml-2"
                                                    style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @else
                                                  Sin Información para mostrar  
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center justify-center space-x-3">
                                                @if($reportesSeleccion==1)
                                                <div  wire:click="abrirModalVentasConsignas(1)" class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==3)
                                                <div  wire:click="abrirModalVentasConsignas(3)" class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==2)
                                                <div  wire:click="abrirModalVentasConsignas(2)" class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @else
                                                  Sin Información para mostrar  
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <div class="flex items-center justify-center space-x-3">
                                                @if($reportesSeleccion==1)
                                                <div  wire:click="abrirmodalInventarioCom(1)" class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==3)
                                                <div  wire:click="abrirmodalInventarioCom(3)" class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==2)
                                                <div  wire:click="abrirmodalInventarioCom(2)" class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @else
                                                  Sin Información para mostrar  
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center justify-center space-x-3">
                                                @if($reportesSeleccion==1)
                                                <div  wire:click="abrirModaltotal(1)" class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==3)
                                                <div  wire:click="abrirModaltotal(3)" class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==2)
                                                <div  wire:click="abrirModaltotal(2)" class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @else
                                                  Sin Información para mostrar  
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <div class="flex items-center justify-center space-x-3">
                                                @if($reportesSeleccion==1)
                                                <div  wire:click="abrirModaltotalCon(1)" class="ml-2" style="background-color: #34D399; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==3)
                                                <div  wire:click="abrirModaltotalCon(3)" class="ml-2" style="background-color: #ad456a; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                                @elseif($reportesSeleccion==2)
                                                <div  wire:click="abrirModaltotalCon(2)" class="ml-2" style="background-color: #000000; color: #ffffff; width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fas fa-gas-pump text-xs"></i>
                                                </div>
                                            @else
                                                Sin Información para mostrar
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <!-- Puedes agregar más filas de datos según sea necesario -->
                            </tbody>
                        </table>
                    </div>
                </div>                    
                @elseif($EstacionSeleccionada  !='153' && $EstacionSeleccionada  !=''  && $EstacionSeleccionada  !='141'  && $EstacionSeleccionada  !='143')
                <div class="flex justify-center mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-1/2 text-center" role="alert">
                       <p> <strong class="font-bold">No hay informacion para esta estacion.</strong>
                    </div>
                </div>
                @else
                <div class="flex justify-center mt-4">
                    <div class="bg-red-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative w-1/2 text-center" role="alert">
                       <p> <strong class="font-bold">Seleccione una estacion.</strong>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>


    <x-dialog-modal id="modal-compras" maxWidth="4xl" wire:model="showModal">
        <x-slot name="title" class="bg-gray-500">
            Reporte Consigna
        </x-slot>

        <x-slot name="content">
            @livewire('compras-consignas', ['valorModal' => 1])
        </x-slot>

        <x-slot name="footer">
            <button x-on:click="show = false"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cerrar
            </button>
        </x-slot>
    </x-dialog-modal>
    <!--modal 2-->
    <x-dialog-modal id="modal-compras2" maxWidth="4xl" wire:model="showModal2">
        <x-slot name="title" class="bg-gray-500">
            Reporte Consigna
        </x-slot>

        <x-slot name="content">
            @livewire('compras-consignas', ['valorModal' => 3])
        </x-slot>

        <x-slot name="footer">
            <button x-on:click="show = false"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cerrar
            </button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal id="modal-compras3" maxWidth="4xl" wire:model="showModal3">
        <x-slot name="title" class="bg-gray-500">
            Reporte Consigna
        </x-slot>

        <x-slot name="content">
            @livewire('compras-consignas', ['valorModal' => 2])
        </x-slot>

        <x-slot name="footer">
            <button x-on:click="show = false"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cerrar
            </button>
        </x-slot>
    </x-dialog-modal>

<!--vntas consignas-->

<x-dialog-modal id="modal-compras" maxWidth="4xl" wire:model="showModalventaConsigna">
    <x-slot name="title" class="bg-gray-500">
        Reporte Ventas Consigna
    </x-slot>

    <x-slot name="content">
        @livewire('reportes.ventas-consignas', ['valorModal' => 1])
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>
<!--modal 2-->
<x-dialog-modal id="modal-compras2" maxWidth="4xl" wire:model="showModalventaConsigna2">
    <x-slot name="title" class="bg-gray-500">
        Reporte Ventas Consigna
    </x-slot>

    <x-slot name="content">
        @livewire('reportes.ventas-consignas', ['valorModal' => 3])
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>
<x-dialog-modal id="modal-compras3" maxWidth="4xl" wire:model="showModalventaConsigna3">
    <x-slot name="title" class="bg-gray-500">
        Reporte Ventas Consigna
    </x-slot>

    <x-slot name="content">
        @livewire('reportes.ventas-consignas', ['valorModal' => 2])
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>


<x-dialog-modal id="modal-compras3" maxWidth="4xl" wire:model="showModalInventarioCombustible">
    <x-slot name="title" class="bg-gray-500">
        Inventario Combustible
    </x-slot>

    <x-slot name="content">
        @livewire('reportes.inventario-combustible')
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>
<x-dialog-modal id="modal-compras3" maxWidth="4xl" wire:model="showModalInventarioCombustibletotal">
    <x-slot name="title" class="bg-gray-500">
        Inventario Combustible Total
    </x-slot>

    <x-slot name="content">
        @livewire('reportes.inventario-combustibletotal')
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>
<x-dialog-modal id="modal-compras4" maxWidth="4xl" wire:model="showModalInventarioCombustibleconsigna">
    <x-slot name="title" class="bg-gray-500">
        Inventario Combustible Consigna
    </x-slot>

    <x-slot name="content">
        @livewire('reportes.inventario-combustibleconsigna')
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
</x-dialog-modal>


    <x-dialog-modal id="modal-compras4" maxWidth="4xl" wire:model="showModalResumen">
    <x-slot name="title" class="bg-gray-500">
        Determinación de costo
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-row space-x-4 px-1">
            <!-- Primer campo de fecha -->
            <div class="flex flex-col space-y-2 flex-grow">
                <label for="fechaInicio" class="text-white">Fecha de inicio</label>
                <input type="date" wire:model='fechainicio'
                    class="p-2 border border-gray-300 rounded w-full">
            </div>
        
            <!-- Segundo campo de fecha -->
            <div class="flex flex-col space-y-2 flex-grow">
                <label for="fechaFin" class="text-white">Fecha de fin</label>
                <input type="date" wire:model='fechafin'
                    class="p-2 border border-gray-300 rounded w-full">
            </div>
        
            <!-- Botón de búsqueda -->
            <div class="flex flex-col flex-grow">
                <label for="fechaFin" class="text-white mt-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <button class="bg-blue-500 text-white py-2 rounded hover:bg-blue-700 w-full mt-2"
                    wire:click='buscar'>Buscar</button>
            </div>
        </div>
        
        @if (session('error'))
<div class="flex justify-center">
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-1/2" role="alert">
       <p> <strong class="font-bold">Lo sentimos, no se puede generar el reporte en el periodo seleccionado.</strong>
        <span class="block sm:inline">{{ session('error') }}</span></p>
    </div>
</div>
@endif
<div class="flex flex-col space-y-3 flex-grow pl-2">
    <button class="bg-blue-500 text-white py-2 mt-6 rounded hover:bg-blue-700 w-full"
        wire:click='exportarExcel'>Exportar Excel</button>
</div>
@if($invInicial !=null)

<div class="overflow-x-auto mt-3 rounded-lg shadow-md" style="max-height: 400px;">
    <!-- Contenedor para el desplazamiento vertical y horizontal -->
    <div class="max-h-full overflow-y-auto">
        <!-- Asegúrate de que la tabla tenga un ancho suficiente para el desplazamiento horizontal -->
        <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th colspan="27" style="background-color: #f0f0f0; font-weight: bold;text-align: start;">Determinacion de costo promedio por producto {{$nombreProducto}}
                </th>
            </tr>
            <tr>
                <th colspan="27" style="background-color: #f0f0f0; font-weight: bold;;text-align: start;">Reporte de {{\Carbon\Carbon::parse($fechaInicio)->format('Y-m-d')}} al {{$fechaFin}}</th>
            </tr>
            <tr>
                <th colspan="27" style="background-color: #f0f0f0; font-weight: bold;;text-align: start;">E.S 14159 FUTURO</th>
            </tr>
            <tr>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Producto</th>
                <th class="border border-black bg-gray-700 text-white text-center px-6 py-2 ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Inv. Inicial Lts</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Importe Inv. Inicial</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Compras Lts</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Compras Consigna</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Total Compras</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Importe Compras</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Flete</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Total Compras s/Consigna</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Total Compras</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Venta Litros</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Jarras</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Venta Lts Consigna</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Ventas Netas Lts</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Importe Ventas</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Ajuste Inv. Final</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Costo Ajuste</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Inv. Final Lts</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Costo Promedio</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Importe Inv. Final</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2"></th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Inv. Inicial Lts</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Inv. Final Lts</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Costo Promedio</th>
                <th class="border border-black bg-gray-700 text-white text-center px-4 py-2">Importe Inv. Final</th>
            </tr>
        </thead>
        <tbody>
    
            @php
            $fechaInicio2 = \Carbon\Carbon::parse($fechaInicio);
            $fechaFin2 = \Carbon\Carbon::parse($fechaFin);
            $rangoFechas = collect();
            $costopromedioreal = $CostoPromedio;
            $totalprimero='$'.number_format($costopromedioreal*$invInicial->Inv_Inicial, 2, '.', ',');
            // Crea un rango de fechas
            while ($fechaInicio2->lte($fechaFin2)) {
                $rangoFechas->push($fechaInicio2->copy());
                $fechaInicio2->addDay();
            }
            
            // Agrupa los datos por fecha
            $groupedDatos = $datos->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->Fecha)->format('Y-m-d');
            });
            
            // Obtener un valor común de descripcion si está disponible
            $defaultDescripcion = $datos->first() ? $datos->first()->descripcion : 'N/A';
            $defaultFecha = $datos->first() ? $datos->first()->Fecha : 'N/A';
            
            // Combina los datos con el rango de fechas para asegurar que todas las fechas están presentes
            $datosCompletos = $rangoFechas->mapWithKeys(function ($fecha) use ($groupedDatos, $defaultDescripcion) {
                $fechaStr = $fecha->format('Y-m-d');
                $datos = $groupedDatos->get($fechaStr, collect());
            
                return [
                    $fechaStr => (object) [
                        'fecha' => $fechaStr,
                        'datos' => $datos->map(function ($item) {
                            return is_array($item) ? (object) $item : $item;
                        }),
                    ],
                ];
            });
            
            // Verificar si el primer día del rango no tiene datos y agregar un registro vacío
            $firstDate = $rangoFechas->first()->format('Y-m-d');
            if ($datosCompletos[$firstDate]->datos->isNotEmpty()) {
                $datosCompletos[$firstDate]->datos->prepend((object) [
                    "comp_id" => "",
                    "Fecha" => $defaultFecha,
                    "idcomprobante" => 0,
                    "valorUnitario" => 0,
                    "cantidad" => 0,
                    "descripcion" => $defaultDescripcion,
                    "FLETE_SERVICIO" => 0,
                    "TOTAL_CON_FLETE" => 0,
                    "ComprasCantidad" => 0,
                    "NuFactura" => $totalprimero,
                ]);
            }
            
            $valorComercializadora='';
            $sumaAcumulativa = $invInicial->Inv_Inicial;
            $totalcompras=0;
            $totalventasTotal=0;
            $sumaCantidadesCompras=0;
            $sumaCantidadesComprasConsigna=0;
            $sumaCantidadescostocompra=0;
            $sumaCantidadescostoflete=0;
            $sumaCantidadescostosinconsigna=0;
            $totalcomprasFinal=0;
            $sumventaslitro=0;
            $sumjarras=0;
            $sumjarrasconsigna=0;
            $sumventastotales=0;
            $sumtotalventas=0;
            $sumacumulativafinal=0;
            $costofinal=0;
            $totalcomprassinconsignas=0;
            //ultimas 4 columnas
            $ininicialfinal= $invInicial->Inv_Inicial;
            $infinalfinal=0;
            $costofinalpromfinal=$CostoPromedio;
            $costofinalcostofinalpromfinal=0;
            $importefinalpromfinal=0;
             // Inicializa la suma acumulativa con el valor inicial
             @endphp
            @foreach ($datosCompletos as $index => $grupo)
            @foreach ($grupo->datos as $dato)
            @php
                $sumacumulativafinal=$sumaAcumulativa+(($dato->cantidad ?? 0) + ($dato->ComprasCantidad ?? 0));
                $valorComercializadora ='Comercializadora '.$dato->descripcion;
                $totalcompras = (($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * (($dato->cantidad ?? 0) + ($dato->ComprasCantidad ?? 0));
                $totalcomprassinconsignas=(($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * ($dato->cantidad ?? 0);
                if($totalcompras>0){
                  $costopromedioreal=($costofinal+$totalcompras)/$sumacumulativafinal;
                  
                }else{
                    $costopromedioreal=$costopromedioreal;
                    //dd($costopromedioreal);
                }
                $costofinal=$sumacumulativafinal*$costopromedioreal;
                $sumaCantidadescostosinconsigna += (($dato->valorUnitario ?? 0) + ($dato->FLETE_SERVICIO ?? 0)) * ($dato->cantidad ?? 0);
                $ininicialfinal=$ininicialfinal;
                $infinalfinal=(($ininicialfinal)+($dato->cantidad ?? 0))-(0-0);
                if($totalcomprassinconsignas>0){
                  $costofinalpromfinal=($costofinalcostofinalpromfinal+$totalcomprassinconsignas)/$infinalfinal;
                }else{
                    $costofinalpromfinal=$costofinalpromfinal;
                    //dd($costopromedioreal);
                }
                $costofinalcostofinalpromfinal=$costofinalpromfinal*$infinalfinal;
            @endphp
            <tr>
                 <!--compras-->
                <td class="border border-black  text-black text-sm text-center px-4 py-2">Comercializadora {{$dato->descripcion}}</td>
                <td class="border border-black  text-black text-sm text-center px-6 py-2 ">{{\Carbon\Carbon::parse($dato->Fecha)->format('d-m-Y')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$dato->NuFactura}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($dato->cantidad, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">
                    {{ $dato->ComprasCantidad != 0 ? number_format($dato->ComprasCantidad, 2, '.', ',') : '' }}
                </td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($dato->cantidad+$dato->ComprasCantidad, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($dato->valorUnitario, 6, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($dato->FLETE_SERVICIO, 6, '.', ',') }} </td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">
                    {{ (($dato->valorUnitario + $dato->FLETE_SERVICIO) * $dato->cantidad) != 0 ? '$' . number_format((($dato->valorUnitario + $dato->FLETE_SERVICIO) * $dato->cantidad), 2, '.', ',') : '' }}
                </td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">
                    {{ $totalcompras != 0 ? '$' . number_format($totalcompras, 2, '.', ',') : '' }}
                </td>
                <!--ventas-->
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{ number_format(0, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumacumulativafinal, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($costopromedioreal, 4, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($costofinal, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($ininicialfinal,2,'.',',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($infinalfinal,2,'.',',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($costofinalpromfinal, 4, '.', ',')}}</td> 
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($costofinalcostofinalpromfinal, 2, '.', ',')}}</td> 
                
            </tr>
            @php
             $sumaCantidadesCompras +=$dato->cantidad ?? 0;
                $sumaCantidadesComprasConsigna+=$dato->ComprasCantidad ?? 0;
                $sumaCantidadescostocompra+=$dato->valorUnitario ?? 0;
                $sumaCantidadescostoflete+=$dato->FLETE_SERVICIO ?? 0;
                
                $totalcomprasFinal+=$totalcompras ?? 0;
            $sumaAcumulativa += $dato->cantidad+$dato->ComprasCantidad;
            $ininicialfinal=$infinalfinal;
            $totalprimero='';
            @endphp
            @endforeach
            
            @foreach($ventas as $venta)
            
            @if(\Carbon\Carbon::parse($index)->format('Y-m-d')==\Carbon\Carbon::parse($venta->Fecha)->format('Y-m-d'))
            @php
        
           
            $sumventastotales=$venta->Venta ?? 0;
            $sumacumulativafinal=$sumaAcumulativa- $sumventastotales;
            $totalcons=0;
            $totalcompras=0;
            if($totalcompras>0){
                  $costopromedioreal=($valorcotoinicial+$totalcompras)/$sumacumulativafinal;
                  
                }else{
                    $costopromedioreal=$costopromedioreal;
                }
                $totalventas=$venta->Venta*$costopromedioreal;
                $costofinal=$sumacumulativafinal*$costopromedioreal;
                if($valorComercializadora==""){
                    $valorComercializadora='Comercializadora '.$nombreProducto;
                }
                $ininicialfinal=$ininicialfinal;
                $infinalfinal=(($ininicialfinal)+(0))-((($venta->Venta ?? 0)-($venta->Jarras ?? 0) - ($venta->JarrasConsigna ?? 0)-($venta->Jarras ?? 0)));
                if($totalcons>0){
                  $costofinalpromfinal=($costofinalcostofinalpromfinal+$totalcons)/$infinalfinal;
                }else{
                    $costofinalpromfinal=$costofinalpromfinal;
                    //dd($costopromedioreal);
                }
                $costofinalcostofinalpromfinal=$costofinalpromfinal*$infinalfinal;
                $valorinicalprecio=$totalprimero;
            @endphp
            <tr>
                 <!--compras-->
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$valorComercializadora}}</td>
                <td class="border border-black  text-black text-sm text-center px-6 py-2 ">{{\Carbon\Carbon::parse($index)->format('d-m-Y')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$valorinicalprecio}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">
                    {{ $totalcompras != 0 ? '$' . number_format($totalcompras, 2, '.', ',') : '' }}
                </td>
                 <!--ventas-->
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($venta->Venta-$venta->Jarras-$venta->JarrasConsigna, 2, '.', ',')}}</td> 
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($venta->Jarras, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$venta->JarrasConsigna}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($sumventastotales, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{ number_format($totalventas, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumacumulativafinal, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($costopromedioreal, 4, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($costofinal, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($ininicialfinal,2,'.',',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($infinalfinal,2,'.',',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($costofinalpromfinal, 4, '.', ',')}}</td> 
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($costofinalcostofinalpromfinal, 2, '.', ',')}}</td> 
            </tr>
            @php
             $sumventaslitro+=($venta->Venta ?? 0) -($venta->Jarras ?? 0 ) -($venta->JarrasConsigna ?? 0);
            $sumjarras+=$venta->Jarras ?? 0;
            $sumjarrasconsigna+=$venta->JarrasConsigna ?? 0;
            $sumtotalventas+=$totalventas ?? 0;
            $totalventasTotal+=$venta->Venta;
            $sumaAcumulativa = $sumacumulativafinal;
            $ininicialfinal=$infinalfinal;
            $totalprimero='';
            @endphp
            
           
            @endif
            @php
    
            $valorcotoinicial=$sumaAcumulativa*$costopromedioreal;     
            @endphp
            @endforeach
            @endforeach
            <!--ajustes de inve-->
            
            @php
            $ajustesinv = 0;
            $mensajesfinal="TOTALES";
            if($invInicial->Inv_Final==0){
                $ajustesinv = 0;
                $mensajesfinal="TOTALES PARCIALES";
            }else{
                $ajustesinv = $invInicial->Inv_Final - $sumaAcumulativa;
            }
           
            // Validar que $ajustesinv no sea negativo y evitar división por cero
            if ($ajustesinv <= 0) {
                // Manejar el caso donde ajustesinv es negativo o cero
                $invfinalajuste = $ajustesinv + $sumaAcumulativa; // O asignar un valor predeterminado
                $costofinalpro = $costofinal / $invfinalajuste;
                $costofinalventsa = $invfinalajuste * $costofinalpro;
            } else {
                $invfinalajuste = $ajustesinv + $sumaAcumulativa;

                // Validar que $invfinalajuste no sea cero para evitar división por cero
                if ($invfinalajuste == 0) {
                    $costofinalpro = 0; // O manejar según la lógica de negocio
                    $costofinalventsa = 0; // O manejar según la lógica de negocio
                } else {
                    $costofinalpro = $costofinal / $invfinalajuste;
                    $costofinalventsa = $invfinalajuste * $costofinalpro;
                }
            }



            //ultimos 4 datos
            $dato1=$ininicialfinal;
            $dato2=$dato1+$ajustesinv;
            $dato3=$costofinalcostofinalpromfinal/$dato2;
            $dato4=$dato2*$dato3;
           
            @endphp
            @if($invInicial->Inv_Final !=0)
            <tr>

                <!--totales-->
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$valorComercializadora}}</td>
               <td class="border border-black  text-black text-sm text-center px-6 py-2 ">{{\Carbon\Carbon::parse($fechaFin2)->format('d-m-Y')}}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaAcumulativa, 2, '.', ',') }}</td> <!-- Muestra la suma acumulativa -->
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <!--ventas-->
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td> 
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($ajustesinv, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($invfinalajuste, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($costofinalpro, 4, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($costofinalventsa, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($dato1, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($dato2, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($dato3, 4, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($dato4, 2, '.', ',')}}</td>
               
           </tr>
           @endif
           <tr>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2 "></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
            <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
           </tr>
    
            <tr>
                @php
                $invfinal=(($invInicial->Inv_Inicial)+($sumaCantidadesCompras+$sumaCantidadesComprasConsigna))-($totalventas);
                @endphp
                <!--totales-->
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2 "></td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2"></td> <!-- Muestra la suma acumulativa -->
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$mensajesfinal}}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaCantidadesCompras, 2, '.', ',')}}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaCantidadesComprasConsigna, 2, '.', ',')}}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaCantidadesCompras+$sumaCantidadesComprasConsigna, 2, '.', ',') }}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($sumaCantidadescostocompra, 6, '.', ',') }}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($sumaCantidadescostoflete, 6, '.', ',') }} </td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">${{ number_format($sumaCantidadescostosinconsigna, 2, '.', ',')}}</td>
               <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($totalcomprasFinal, 2, '.', ',')}}</td>
                <!--ventas-->
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($sumventaslitro, 2, '.', ',')}}</td> 
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$sumjarras}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{$sumjarrasconsigna}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($totalventasTotal, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{ number_format($sumtotalventas, 2, '.', ',') }}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{ number_format($ajustesinv, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($invfinalajuste, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($costofinalpro, 4, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($costofinalventsa, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2"></td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($dato2, 2, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">{{number_format($dato3, 4, '.', ',')}}</td>
                <td class="border border-black  text-black text-sm text-center px-4 py-2">${{number_format($dato4, 2, '.', ',')}}</td>
               
           </tr>
           
        </tbody>
    </table>
    
</div>
</div>
@endif
    </x-slot>

    <x-slot name="footer">
        <button x-on:click="show = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cerrar
        </button>
    </x-slot>
    </x-dialog-modal>

    <div>
        @if (session()->has('database_messages'))
            @foreach (session('database_messages') as $message)
                <div class="alert alert-info">
                    {{ $message }}
                </div>
            @endforeach
        @endif
    
        <!-- Aquí va el resto del contenido de tu componente -->
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve' // ensure the select2 dropdown fits its container
            });
        });
    
        $('#EstacionSeleccionada').on('change', function() {
            var estacionSeleccionada = $(this).val();
            @this.set('EstacionSeleccionada', estacionSeleccionada);
        });
        $('#TipoCombustible').on('change', function() {
            var TipoCombustible = $(this).val();
            @this.set('TipoCombustible', TipoCombustible);
        });
    </script>
</div>
