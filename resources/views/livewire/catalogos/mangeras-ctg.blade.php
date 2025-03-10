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
                                        @if ($sort_manguera == 'id')
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
                                        wire:click="order('nu_isla')">
                                        <p>Nu isla
                                            @if ($sort_manguera == 'nu_isla')
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
                                        wire:click="order('nu_combustible')">
                                        <div class="flex items-center">
                                            <span>Nu factura</span>
                                            @if ($sort_manguera == 'nu_combustible')
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
                                        wire:click="order('nu_pos_carga')">
                                        nu_pos_carga
                                        @if ($sort_manguera == 'nu_pos_carga')
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
                                        wire:click="order('lec_ini')">
                                        lec_ini
                                        @if ($sort_manguera == 'lec_ini')
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
                                        wire:click="order('estado')">
                                        Estado
                                        @if ($sort_manguera == 'estado')
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
                                        wire:click="order('nu_cliente')">
                                        Nu cliente
                                        @if ($sort_manguera == 'nu_cliente')
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
                                        wire:click="order('nu_tarjeta')">
                                        Nu tarjeta
                                        @if ($sort_manguera == 'nu_tarjeta')
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
                                        wire:click="order('bnd_miles')">
                                        bnd_miles
                                        @if ($sort_manguera == 'bnd_miles')
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
                                        wire:click="order('nu_antena')">
                                        Nu antena
                                        @if ($sort_manguera == 'nu_antena')
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
                                        wire:click="order('nu_pistola')">
                                        Nu pistola
                                        @if ($sort_manguera == 'nu_pistola')
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
                                        wire:click="order('man_dt_alta')">
                                        man_dt_alta
                                        @if ($sort_manguera == 'man_dt_alta')
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
                                            {{ $catalogo->nu_isla }}
                                        </td>
                                        <td class="w-32 px-3 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $catalogo->nu_combustible }}
                                        </td>

                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $catalogo->nu_pos_carga }}
                                        </td>

                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->lec_ini }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->estado }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->nu_cliente }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->nu_tarjeta }}

                                        </td> <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->bnd_miles }}

                                        </td> <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->nu_antena }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->nu_pistola }}

                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $catalogo->man_dt_alta }}

                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">


                                            <x-button title="Editar" wire:click='edit({{ $catalogo->id }})'><i
                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                            </x-button>
                                            <x-danger-button title="Eliminar"
                                                wire:click="$dispatch('delete-mangueras',{{ $catalogo->id }})"><i
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
                    <x-label-modal>Nu Isla</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_isla" />

                        <x-input-error for="nu_isla" />
                </div>
                <div>
                    <x-label-modal>Nu Combustible</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_combustible" />

                        <x-input-error for="nu_combustible" />
                </div>
                <div>
                    <x-label-modal>Nu pos carga</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_pos_carga" />

                        <x-input-error for="nu_pos_carga" />
                </div>
                <div>
                    <x-label-modal>lec_ini</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="lec_ini" />

                        <x-input-error for="lec_ini" />
                </div>
                <div>
                    <x-label-modal>Estado</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="estado" />

                        <x-input-error for="estado" />
                </div>

                <div>
                    <x-label-modal>Nu Cliente</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_cliente" />

                        <x-input-error for="nu_cliente" />
                </div>
                
                <div>
                    <x-label-modal>Nu Tarjeta</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_tarjeta" />

                        <x-input-error for="nu_tarjeta" />
                </div>
                <div>
                    <x-label-modal>bnd_miles</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="bnd_miles" />

                        <x-input-error for="bnd_miles" />
                </div>
                <div>
                    <x-label-modal>Nu Antena</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_antena" />

                        <x-input-error for="nu_antena" />
                </div>
                <div>
                    <x-label-modal>Nu Pistola</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="nu_pistola" />

                        <x-input-error for="nu_pistola" />
                </div>
                <div>
                    <x-label-modal>man_dt_alta</x-label>
                        <x-input-modal type="text" class="w-full" wire:model="man_dt_alta" />

                        <x-input-error for="man_dt_alta" />
                </div>
            </div>
        @endslot
        @slot('footer')
            <x-secondary-button wire:click="clean">Cancelar</x-secondary-button>
            <x-button wire:click="$dispatch('confirm-mangueras',{{ $ctg_id }}) "
                class=" ml-3 disabled:opacity-25">Guardar</x-button>
        @endslot
    </x-dialog-modal-xl>



</div>
