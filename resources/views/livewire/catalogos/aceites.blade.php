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

            <h2 class="text-2xl font-bold text-white mb-4">
                <a href="{{ route('ctg.index') }}" title="ATRAS" class="me-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
                Catalogos de Aceites
            </h2>


            <div class=" py-6 px-4 bg-gray-200 flex">

                <div class="flex items-center">
                    <span style="font-size: 12px;">Mostrar</span>

                    <select
                        class="
                            border-gray-300 
                            text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500"
                        wire:model.live='list'>
                        @foreach ($entrada as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <span style="font-size: 12px;">Entradas</span>
                </div>

                <x-input-filtro type="text" placeholder="Buscar" class="w-full ml-4 "
                    wire:model.live='search' />

                <x-button class="ml-4" wire:click="create">Nuevo</x-button>
            </div>

            <div class="mt-2 " wire:init='loadData'>
                <div class="overflow-x-auto shadow-md rounded-lg">

                    @if (count($aceites))

                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider
                                        cursor-pointer"
                                        wire:click="order('id')">
                                        ID
                                        @if ($sort == 'id')
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
                                        wire:click="order('tipo')">
                                        <p>Tipo
                                            @if ($sort == 'tipo')
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
                                        wire:click="order('corta')">
                                        <div class="flex items-center">
                                            <span>Corta</span>
                                            @if ($sort == 'corta')
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
                                        wire:click="order('description')">
                                        Descripción
                                        @if ($sort == 'description')
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
                                        wire:click="order('costo')">
                                        Costo
                                        @if ($sort == 'costo')
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
                                        wire:click="order('existencia')">
                                        Existencia
                                        @if ($sort == 'existencia')
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
                                        wire:click="order('status')">
                                        Estatus
                                        @if ($sort == 'status')
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

                                @foreach ($aceites as $aceite)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $aceite->id }}

                                        </td>
                                        <td class="px-3 py-4 w-10 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $aceite->tipo }}
                                        </td>
                                        <td class="w-32 px-3 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $aceite->corta }}
                                        </td>

                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $aceite->description }}
                                        </td>

                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $aceite->costo }}

                                        </td>


                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $aceite->existencia }}

                                        </td>

                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $aceite->status }}

                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">

                                            {{-- <x-button title="Detalles" wire:click='detalles({{ $aceite->id }})'>
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>

                                            </x-button> --}}
                                            <x-button title="Editar" wire:click='edit({{ $aceite->id }})'><i
                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                            </x-button>
                                            <x-danger-button title="Eliminar" wire:click="$dispatch('delete',{{ $aceite->id }})"><i
                                                    class="fa fa-trash" aria-hidden="true"></i>


                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>



                        </table>

                        @if ($aceites->hasPages())
                            <div class="px-6 py-3  bg-gray-200">
                                {{ $aceites->links() }}
                            </div>
                        @endif
                    @else
                        @if ($readyToLoad)
                            <h1 class="px-6 py-3 text-white ">No hay datos disponibles</h1>
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
                        <h1> {{ $ctg_id ? 'EDITAR ACEITE' : 'AGREGAR ACEITE' }}</h1>

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
                    <x-label-modal>Tipo</x-label>
                        {{-- <x-input-modal type="text" class="w-full" wire:model="tipo" /> --}}
                        <select class="w-full" wire:model="tipo">
                            <option value="" selected>Selecciona</option>
                            <option value="1">Ac</option>
                            <option value="2">Ad</option>
                            <option value="3">Ot</option>
                        </select>
                        <x-input-error for="tipo" />
                </div>
                {{-- <div>
                <x-label-modal>Numero de aceite</x-label>
                    <x-input-modal type="text" class="w-full" wire:model="no" />
                   
                    <x-input-error for="no" />
            </div> --}}

                <div>
                    <x-label-modal>Descripcion</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="desc" />

                        <x-input-error for="desc" />
                </div>
                <div>
                    <x-label-modal>Corta</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="corta" />

                        <x-input-error for="corta" />
                </div>
                <div>
                    <x-label-modal>Costo</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="costo" />

                        <x-input-error for="costo" />
                </div>
                <div>
                    <x-label-modal>Existencias</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="existencia" />

                        <x-input-error for="existencia" />
                </div>

            </div>
        @endslot
        @slot('footer')
            <x-secondary-button wire:click="clean">Cancelar</x-secondary-button>
            <x-button wire:click="$dispatch('confirm',{{ $ctg_id }}) "
                class=" ml-3 disabled:opacity-25">Guardar</x-button>
        @endslot
    </x-dialog-modal-xl>


    @once('js')
        <script>
            document.addEventListener('livewire:initialized', () => {

                @this.on('confirm', (ctg_id) => {

                    var txt = ctg_id != null ? "Actualizado" : "Creado"
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

                            @this.dispatch('save-ctg');

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


                @this.on('delete', (ctg) => {
                    console.log(ctg)
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

                            @this.dispatch('delete-ctg',{ctg:ctg});

                        }
                    })
                });



            });
        </script>
    @endonce


</div>
