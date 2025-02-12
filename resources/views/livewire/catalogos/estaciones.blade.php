<div>
    <div class="flex justify-center min-h-full mb-4 max-w-full bg-gray-100">
        <div class="w-full max-w-xl max-h-full"
            style="width: 100%; 
               max-width: 100%; 
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
               border-radius: 1rem; 
               padding: 1.5rem; 
               margin-top: 2rem; 
               margin-bottom: 5rem; 
               margin-left: 1.25rem; 
               margin-right: 1.25rem;">

            <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-700 mb-4">
                <a href="{{ route('dashboard') }}" title="ATRAS" class="me-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
                Catalogos de estaciones
            </h2>
          <div class="py-6 px-4 bg-gray-200 rounded-lg flex space-x-4">
                <!-- Consulta de Reporte -->
                <select class="w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tipo de Reporte</option>
                    <option value="magna">Gastos</option>
                    <option value="premium">Consignas</option>
                    <option value="diesel">Otros</option>
                </select>

                <!-- Tipo de Combustible -->
                <select class="w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecciona Combustible</option>
                    <option value="magna">Magna</option>
                    <option value="premium">Premium</option>
                    <option value="diesel">Diésel</option>
                </select>

                <!-- Gastos -->
                <select class="w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecciona tipo de Gastos</option>
                    <option value="magna">Entradas</option>
                    <option value="premium">Salidas</option>
                    <option value="diesel">Otros</option>
                </select>
            </div>


            <div class=" py-6 px-4 bg-gray-200 flex">

                <div class="flex items-center">
                    <span style="font-size: 12px;">Mostrar</span>

                    <select
                        class="
                            border-gray-300 
                            text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-black dark:focus:ring-blue-500 
                            dark:focus:border-blue-500 mx-2"
                        wire:model.live='list'>
                        @foreach ($entrada as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <span style="font-size: 12px;">Entradas</span>
                </div>

                <x-input-filtro type="text" placeholder="Busca una estación" class="w-full ml-4 "
                    wire:model.live='catalogos.search' />

                <x-button class="ml-4" wire:click="create">Nuevo</x-button>
            </div>

            <div class="mt-2 " wire:init='loadEstaciones'>
                <div class="overflow-x-auto shadow-md rounded-lg">

                    @if ($estaciones)

                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    {{-- <th scope="col"
                                        class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider
                                        cursor-pointer"
                                        wire:click="order('IdEstacion')">
                                        ID
                                        @if ($sort == 'IdEstacion')
                                            @if ($orderBy == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt mt-1"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right hover:float-left mt-1"></i>

                                        @endif
                                    </th> --}}
                                    <th scope="col"
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider
                                        cursor-pointer"
                                        wire:click="order('NumeroSistemaContable')">
                                        <p>Num.Sistema Contable
                                        @if ($sort == 'NumeroSistemaContable')
                                            @if ($orderBy == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt mt-1"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right hover:float-left mt-1"></i>

                                        @endif
                                        </p>
                                    </th>
                                    <th scope="col"
                                    class="w-32 px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider cursor-pointer"
                                    wire:click="order('Estacion')">
                                    <div class="flex items-center">
                                        <span>Estación</span>
                                        @if ($sort == 'Estacion')
                                            @if ($orderBy == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt ml-2"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt ml-2"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort ml-2"></i>
                                        @endif
                                    </div>
                                </th>

                                    <th scope="col"
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider
                                        cursor-pointer"
                                        wire:click="order('NombreEstacion')">
                                        Nombre Estacion
                                        @if ($sort == 'NombreEstacion')
                                            @if ($orderBy == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt mt-1"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right hover:float-left mt-1"></i>

                                        @endif
                                    </th>

                                    <th scope="col"
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider
                                        cursor-pointer"
                                        wire:click="order('DireccionFiscal')">
                                        Direccion Fiscal
                                        @if ($sort == 'DireccionFiscal')
                                            @if ($orderBy == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt mt-1"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right hover:float-left mt-1"></i>

                                        @endif
                                    </th>


                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Detalles
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach ($estaciones as $estacion)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $estacion->IdEstacion }}

                                        </td> --}}
                                        <td class="px-3 py-4 w-10 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $estacion->NumeroSistemaContable }}
                                        </td>
                                        <td class="w-32 px-3 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $estacion->estacion }}
                                        </td>

                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $estacion->NombreEstacion }}
                                        </td>

                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $estacion->DireccionFiscal }}

                                        </td>


                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">

                                            <x-button title="Detalles"
                                                wire:click='detalles({{ $estacion->IdEstacion }})'>
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>

                                            </x-button>
                                            <x-button title="Editar" wire:click='edit({{ $estacion->IdEstacion }})'><i
                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                            </x-button>
                                            <x-danger-button title="Eliminar" wire:click="$dispatch('delete')"><i
                                                    class="fa fa-trash" aria-hidden="true"></i>


                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>



                        </table>

                        @if ($estaciones->hasPages())
                            <div class="px-6 py-3  bg-gray-200">
                                {{ $estaciones->links() }}
                            </div>
                        @endif
                    @else
                        @if ($readyToLoad)
                            <h1 class="px-6 py-3 text-gray-500 ">No hay datos disponibles</h1>
                        @else
                            <!-- Muestra un spinner mientras los datos se cargan -->
                            <div class="flex justify-center items-center h-40">
                                <div
                                    class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-yellow-500">
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
    {{-- MODAL crud --}}
    <x-dialog-modal-xl wire:model.live="open" id="">
        @slot('title')
            <div class="px-6 py-4 items-center  bg-gray-100 overflow-x-auto shadow-md sm:rounded-lg">

                <div class="grid grid-cols-4 gap-6">
                    <div class="col-span-2 ">
                        <h1> {{ $estacion_id ? 'EDITAR ESTACIÓN' : 'AGREGAR ESTACIÓN' }}</h1>

                    </div>
                    <div class="col-span-2 ">
                        <img src="{{ asset('img/logo-transparente.png') }}" alt="Footer Image" class="mx-auto max-h-10">
                    </div>
                </div>
            </div>
        @endslot
        @slot('content')
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <x-label-modal>Estación</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.estacion" />
                        <x-input-error for="catalogos.estacion" />
                </div>
                <div>
                    <x-label-modal>Numero Sistema Contable</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.NumeroSistemaContable" />
                        <x-input-error for="catalogos.NumeroSistemaContable" />
                </div>
                <div>
                    <x-label-modal>Número Destino</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.NumeroDestino" />
                        <x-input-error for="catalogos.NumeroDestino" />
                </div>
                <div>
                    <x-label-modal>Fecha Inicio Operaciones</x-label>
                        <x-input-modal type="date" class="w-full" wire:model="catalogos.FechaInicioOperaciones" />
                        <x-input-error for="catalogos.FechaInicioOperaciones" />
                </div>
                <div>
                    <x-label-modal>PermisoCRE</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.PermisoCRE" />
                        <x-input-error for="catalogos.PermisoCRE" />
                </div>
                <div>
                    <x-label-modal>SIIC</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.SIIC" />
                        <x-input-error for="catalogos.SIIC" />
                </div>
                <div>
                    <x-label-modal>Nombre Estación</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.NombreEstacion" />
                        <x-input-error for="catalogos.NombreEstacion" />
                </div>
                <div>
                    <x-label-modal>RFC</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.RFC" />
                        <x-input-error for="catalogos.RFC" />
                </div>
                <div>
                    <x-label-modal>Dirección Fiscal</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.DireccionFiscal" />
                        <x-input-error for="catalogos.DireccionFiscal" />
                </div>
                <div>
                    <x-label-modal>Analista JR</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.AnalistaJR" />
                        <x-input-error for="catalogos.AnalistaJR" />
                </div>
                <div>
                    <x-label-modal>Correo Analista JR</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.CorreoAnalistaJR" />
                        <x-input-error for="catalogos.CorreoAnalistaJR" />
                </div>
                <div>
                    <x-label-modal>Contador</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.Contador" />
                        <x-input-error for="catalogos.Contador" />
                </div>
                <div>
                    <x-label-modal>Correo Contador</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.CorreoContador" />
                        <x-input-error for="catalogos.CorreoContador" />
                </div>
                <div>
                    <x-label-modal>Analista CtaX Pagar</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.AnalistaCtaXPagar" />
                        <x-input-error for="catalogos.AnalistaCtaXPagar" />
                </div>
                <div>
                    <x-label-modal>Correo CXP</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.CorreoCXP" />
                        <x-input-error for="catalogos.CorreoCXP" />
                </div>
                <div>
                    <x-label-modal>Analista CtaX Cobrar</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.AnalistaCtaXCobrar" />
                        <x-input-error for="catalogos.AnalistaCtaXCobrar" />
                </div>
                <div>
                    <x-label-modal>Correo CXC</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.CorreoCXC" />
                        <x-input-error for="catalogos.CorreoCXC" />
                </div>
                <div>
                    <x-label-modal>Secretaria</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.Secretaria" />
                        <x-input-error for="catalogos.Secretaria" />
                </div>
                <div>
                    <x-label-modal>Correo SCA</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.CorreoSCA" />
                        <x-input-error for="catalogos.CorreoSCA" />
                </div>
                <div>
                    <x-label-modal>Descarga Contra cargos</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="catalogos.DescargaContracargos" />
                        <x-input-error for="catalogos.DescargaContracargos" />
                </div>
            </div>
        @endslot
        @slot('footer')
            <x-secondary-button wire:click="clean">Cancelar</x-secondary-button>
            <x-button wire:click="$dispatch('confirm',{{ $estacion_id }}) "
                class=" ml-3 disabled:opacity-25">Guardar</x-button>
        @endslot
    </x-dialog-modal-xl>

    {{-- modal detalle --}}
    <x-dialog-modal wire:model.live="info" id="">
        @slot('title')
            <div class="px-6 py-4 items-center  bg-gray-100 overflow-x-auto shadow-md sm:rounded-lg">
                <div class="grid grid-cols-4 gap-6">
                    <div class="col-span-2 ">
                        <h1>Detalles de estación
                        </h1>
                    </div>
                    <div class="col-span-2 ">
                        <img src="{{ asset('img/logo-transparente.png') }}" alt="Footer Image" class="mx-auto max-h-10">
                    </div>
                </div>
            </div>
        @endslot
        @slot('content')
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-1">
                    <div class="relative z-0 w-full group">
                        <h2><b>Estación: </b>{{ $catalogos->estacion }}</h2>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="relative z-0 w-full group">
                        <h2><b>Numero Destino: </b>{{ $catalogos->NumeroDestino }}</h2>

                    </div>
                </div>
                <div class="col-span-1">
                    <div class="relative z-0 w-full group">
                        <h2><b>PermisoCRE: </b>{{ $catalogos->PermisoCRE }}</h2>

                    </div>
                </div>

                <div class="col-span-2">
                    <div class="relative z-0 w-full group">
                        <h2><b>Nombre Estacion: </b>{{ $catalogos->NombreEstacion }}</h2>

                    </div>
                </div>
                <div class="col-span-1">
                    <div class="relative z-0 w-full group">
                        <h2><b>SIIC:</b> {{ $catalogos->SIIC }}</h2>

                    </div>
                </div>
                <div class="col-span-3">
                    <div class="relative z-0 w-full group">
                        <h2><b>RFC:</b> {{ $catalogos->RFC }}</h2>

                    </div>
                </div>
                <div class="col-span-3">
                    <div class="relative z-0 w-full group">
                        <h2><b>Direccion Fiscal: </b>{{ $catalogos->DireccionFiscal }}</h2>

                    </div>
                </div>

                <div class="col-span-3">
                    <hr>
                </div>
                {{-- ************************************************* --}}
            </div>
            <div class="grid grid-cols-4 gap-6 mt-5">


                <div class="col-span-2">
                    <div class="relative z-0 w-full group">
                        <h2><b>Contador:</b> {{ $catalogos->Contador }}</h2>

                    </div>
                </div>
                <div class="col-span-2 text-end">
                    <div class="relative z-0 w-full group">
                        <h2><b>Correo Contador: </b>{{ $catalogos->CorreoContador }}</h2>

                    </div>
                </div>
                <div class="col-span-2">
                    <div class="relative z-0 w-full group">
                        <h2><b>Analista JR:</b> {{ $catalogos->AnalistaJR }}</h2>

                    </div>
                </div>
                <div class="col-span-2 text-end">
                    <div class="relative z-0 w-full group">
                        <h2><b>Correo Analista JR: </b>{{ $catalogos->CorreoAnalistaJR }}</h2>

                    </div>
                </div>
                <div class="col-span-2">
                    <div class="relative z-0 w-full group">
                        <h2><b>Analista CtaX Pagar:</b> {{ $catalogos->AnalistaCtaXPagar }}</h2>

                    </div>
                </div>
                <div class="col-span-2 text-end">
                    <div class="relative z-0 w-full group">
                        <h2><b>Correo CXP: </b>{{ $catalogos->CorreoCXP }}</h2>

                    </div>
                </div>
                <div class="col-span-2">
                    <div class="relative z-0 w-full group">
                        <h2><b>Analista CtaX Cobrar: </b>{{ $catalogos->AnalistaCtaXCobrar }}</h2>

                    </div>
                </div>
                <div class="col-span-2 text-end">
                    <div class="relative z-0 w-full group">
                        <h2><b>Correo CXC: </b>{{ $catalogos->CorreoCXC }}</h2>

                    </div>
                </div>
                <div class="col-span-2">
                    <div class="relative z-0 w-full group">
                        <h2><b>Secretaria:</b> {{ $catalogos->Secretaria }}</h2>

                    </div>
                </div>
                <div class="col-span-2 text-end">
                    <div class="relative z-0 w-full group">
                        <h2><b>Correo SCA:</b> {{ $catalogos->CorreoSCA }}</h2>

                    </div>
                </div>
                <div class="col-span-3">
                    <div class="relative z-0 w-full group">
                        <h2><b>Descarga Contra cargos: </b>{{ $catalogos->DescargaContracargos }}</h2>

                    </div>
                </div>
            </div>
        @endslot
        @slot('footer')
            <x-secondary-button wire:click="clean">CERRAR</x-secondary-button>
        @endslot
    </x-dialog-modal>

    @once('js')
        <script>
            document.addEventListener('livewire:initialized', () => {

                @this.on('confirm', (estacion_id) => {

                    var txt = estacion_id != null ? "Actualizado" : "Creado"
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se ha " + txt,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            @this.dispatch('save-estacion');

                        }
                    })
                });


                Livewire.on('alert', function([message]) {
                    Swal.fire({
                        // position: 'top-end',
                        icon: message[1],
                        title: message[0],
                        showConfirmButton: false,
                        timer: 1500
                    })


                });


                @this.on('delete', () => {

                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se eliminara de la base de datos",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire({
                                // position: 'top-end',
                                icon: 'success',
                                title: 'Estación eliminada',
                                showConfirmButton: false,
                                timer: 1500
                            })


                        }
                    })
                });



            });
        </script>
    @endonce


</div>
