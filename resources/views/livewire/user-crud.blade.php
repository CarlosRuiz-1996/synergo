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
            <h2 class="text-2xl font-bold text-white mb-4"><a href="{{ route('dashboard') }}" title="ATRAS" class="me-2">
                <i class="fa fa-arrow-left"></i>
            </a>
            Usuarios</h2>
            
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Crear Usuario</button>

            @if($isOpen)
                @include('livewire.create')
            @endif



            <div class="flex flex-col space-y-1">
                <div class="flex items-center justify-end space-x-1">
                    <div class="w-full overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full divide-y divide-gray-200 text-center text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-200 px-2 py-1">ID</th>
                        <th class="border border-gray-200 px-2 py-1">Nombre</th>
                        <th class="border border-gray-200 px-2 py-1">Email</th>
                        <th class="border border-gray-200 px-2 py-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($users as $user)
                    <tr>
                        <td class="border border-gray-200 px-2 py-1">{{ $user->id }}</td>
                        <td class="border border-gray-200 px-2 py-1">{{ $user->name }}</td>
                        <td class="border border-gray-200 px-2 py-1">{{ $user->email }}</td>
                        <td class="border border-gray-200 px-2 py-1">
                            <button wire:click="edit({{ $user->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                            <button wire:click="delete({{ $user->id }})" class="bg-blue-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
