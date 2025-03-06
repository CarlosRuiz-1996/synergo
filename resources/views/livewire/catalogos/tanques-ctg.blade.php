<div>
    <div class="flex justify-center min-h-full mb-4 max-w-full ">
        <div class="w-full max-w-xl max-h-full" style="width: 100%; 
           max-width: 100%; 
           ">


            <div class=" py-6 px-4 bg-gray-200 rounded-lg flex space-x-4">

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

                <x-input-filtro type="text" placeholder="Buscar" class="w-full ml-4 " wire:model.live='search' />

                <x-button class="ml-4" wire:click="create">Nuevo</x-button>
            </div>

            <div class="mt-2 " wire:init='loadData'>
                <div class="overflow-x-auto shadow-md rounded-lg">

                    @if (count($catalogos))

                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider
                                        cursor-pointer"
                                        wire:click="order('id')">
                                        ID
                                        @if ($sort_tanque == 'id')
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
                                        wire:click="order('capacidad')">
                                        <p>Capacidad
                                            @if ($sort_tanque == 'capacidad')
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
                                        wire:click="order('diametro')">
                                        <div class="flex items-center">
                                            <span>Diametro</span>
                                            @if ($sort_tanque == 'diametro')
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
                                        wire:click="order('niv_seg')">
                                        niv_seg
                                        @if ($sort_tanque == 'niv_seg')
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
                                        wire:click="order('niv_op')">
                                        niv_op
                                        @if ($sort_tanque == 'niv_op')
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
                                        wire:click="order('edo')">
                                        Estado
                                        @if ($sort_tanque == 'edo')
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
                                        wire:click="order('fondaje')">
                                        Fondaje
                                        @if ($sort_tanque == 'fondaje')
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
                                        wire:click="order('capa_oper')">
                                        capa_oper
                                        @if ($sort_tanque == 'capa_oper')
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
                                        wire:click="order('tan_dt_alta')">
                                        tan_dt_alta
                                        @if ($sort_tanque == 'tan_dt_alta')
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

                                @foreach ($catalogos as $catalogo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $catalogo->id }}

                                        </td>
                                        <td class="px-3 py-4 w-10 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $catalogo->capacidad }}
                                        </td>
                                        <td class="w-32 px-3 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $catalogo->diametro }}
                                        </td>

                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $catalogo->niv_seg }}
                                        </td>

                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->niv_op }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->edo }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->fondaje }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->capa_oper }}

                                        </td>
                                        
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->tan_dt_alta }}

                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">


                                            <x-button title="Editar" wire:click='edit({{ $catalogo->id }})'><i
                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                            </x-button>
                                            <x-danger-button title="Eliminar"
                                                wire:click="$dispatch('delete-tanques',{{ $catalogo->id }})"><i
                                                    class="fa fa-trash" aria-hidden="true"></i>


                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>



                        </table>

                        @if ($catalogos->hasPages())
                            <div class="px-6 py-3  bg-gray-200">
                                {{ $catalogos->links() }}
                            </div>
                        @endif
                    @else
                        @if ($readyToLoad)
                            <h1 class="px-6 py-3 text-dark ">No hay datos disponibles</h1>
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
                    <x-label-modal>Capacidad</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="capacidad" />

                        <x-input-error for="capacidad" />
                </div>
                <div>
                    <x-label-modal>Diametro</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="diametro" />

                        <x-input-error for="diametro" />
                </div>
                <div>
                    <x-label-modal>niv_seg</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="niv_seg" />

                        <x-input-error for="niv_seg" />
                </div>
                <div>
                    <x-label-modal>niv_op</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="niv_op" />

                        <x-input-error for="niv_op" />
                </div>
                <div>
                    <x-label-modal>Estado</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="edo" />

                        <x-input-error for="edo" />
                </div>

                <div>
                    <x-label-modal>Fondaje</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="fondaje" />

                        <x-input-error for="fondaje" />
                </div>
                <div>
                    <x-label-modal>capa_oper</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="capa_oper" />

                        <x-input-error for="capa_oper" />
                </div>
                <div>
                    <x-label-modal>tan_dt_alta</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="tan_dt_alta" />

                        <x-input-error for="tan_dt_alta" />
                </div>
            </div>
        @endslot
        @slot('footer')
            <x-secondary-button wire:click="clean">Cancelar</x-secondary-button>
            <x-button wire:click="$dispatch('confirm-tanques',{{ $ctg_id }}) "
                class=" ml-3 disabled:opacity-25">Guardar</x-button>
        @endslot
    </x-dialog-modal-xl>



</div>
