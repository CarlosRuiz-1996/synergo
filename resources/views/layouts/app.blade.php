<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script><!-- excel -->
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Styles -->
    @livewireStyles
 </head>
    <body class="font-sans antialiased">
<header class="text-black pt-4 fixed top-0 left-0 w-full z-10 bg-white shadow-md">
    <!-- Logo -->
    <div class="flex justify-between items-center ml-8 mb-2">
        <!--
        <div class="flex items-center space-x-2">
            <span class="text-2xl font-bold tracking-wide">
                SYNER<span class="text-gray-400 text-xs align-super">.GO</span>
            </span>
        </div>
        -->
          <img src="{{ asset('img/Logotipo Synergo.png') }}" class="mr-4 md:w-34 md:h-6 w-34 h-12 inline">
    </div>

    <!-- Barra gris ocupando todo el ancho -->
    <div class="w-full py-2" style="background-color:#333">
        <div class="flex items-center justify-between w-full px-4 md:px-8">
            
            <!-- Espacio vacío para mantener alineación -->
            <div class="flex-1"></div>

            <!-- Precios de combustibles centrados -->
            <div class="flex-1 flex flex-wrap justify-center space-x-4 text-sm text-white">
                <span style="color:#8CC63F" class="font-bold">$20.38 <span class="text-white">Magna</span></span>
                <span style="color:#FF0000" class="font-bold">$22.30 <span class="text-white">Premium</span></span>
                <span class="text-gray-300 font-bold">$21.30 <span class="text-white">Diésel</span></span>
                <span class="text-gray-300 font-bold">$20.85 <span class="text-white">Dólar</span></span>
            </div>

            <!-- Barra de búsqueda ocupando toda la tercera columna -->
            <div class="relative flex-1 flex justify-center">
                <input type="text" placeholder="Buscar..." 
                    class="w-full max-w-md md:max-w-lg lg:max-w-xl min-w-[200px] pl-12 md:pl-14 pr-4 py-2 rounded-full bg-white text-gray-800 focus:outline-none focus:ring focus:ring-gray-500 shadow">
                <svg class="absolute left-4 md:left-5 lg:left-6 xl:left-14 top-1/2 -translate-y-1/2 w-5 md:w-6 h-5 md:h-6 text-gray-500" 
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M21 21l-4.35-4.35M15 10a5 5 0 11-10 0 5 5 0 0110 0z"/>
                </svg>
            </div>

        </div>
    </div>
</header>


        <x-banner />
 <div class="flex " style="margin-top:2.5rem">
        <div class="min-h-screen bg-gray-100 h-screen fixed top-18 w-screen pt-18  mt-16">
            <div x-data="{ open: false }" x-cloak class="flex h-screen pt-18 bg-gray-100">
                <!-- Sidebar -->
                <div :class="{'w-64': open, 'w-16': !open}" style="background-color:#E6E6E6" class="text-black h-full transition-all duration-300 ease-in-out fixed md:relative z-10">
                    <!-- Toggle Button -->
                    <div class="flex justify-between p-4">
                        <button @click="open = !open" class="text-black">
                            <!-- Ícono de abrir el menú -->
                            <svg x-show="!open" x-cloak x-transition:enter="transform transition ease-in-out duration-300"
                                x-transition:enter-start="rotate-0" x-transition:enter-end="rotate-180" 
                                class="h-12 w-12 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <!-- Ícono de cerrar el menú -->
                            <svg x-show="open" x-cloak x-transition:enter="transform transition ease-in-out duration-300"
                                x-transition:enter-start="rotate-180" x-transition:enter-end="rotate-0" 
                                class="h-12 w-12 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                       <!-- Información del usuario, solo se muestra cuando está expandido -->
                       <div x-show="open" class="text-center w-full overflow-hidden mb-2">
                            <div class="text-sm font-semibold text-center px-2 truncate capitalize" title="{{ Auth::user()->name }}">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs text-center px-2 truncate" title="{{ Auth::user()->email }}">
                                {{ Auth::user()->email }}
                            </div>
                        </div>

                    

                    <!-- Sidebar Links -->
                    <div class="space-y-2">
                        <a  href="{{ route('dashboard') }}" class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                            <img src="{{ asset('img/icocno_panel.png') }}" class="mr-4 md:w-6 md:h-6 w-12 h-12 inline">
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                Panel
                            </span>
                        </a>
                        <a href="{{route('catalogos.estaciones')}}" class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                            <img src="{{ asset('img/Icono_estación.png') }}" class="mr-4 md:w-6 md:h-6 w-12 h-12 inline">
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                Estaciones
                            </span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                            <img src="{{ asset('img/Icono_finanzas.png') }}" class="mr-4 md:w-6 md:h-6 w-12 h-12 inline">
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                Finanzas
                            </span>
                        </a>
                        <a href="{{route('cuentas.tesoreria')}}" class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                       <img src="{{ asset('img/Icono_tesoreria.png') }}" class="mr-4 md:w-6 md:h-6 w-12 h-12 inline">
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                Tesorería
                            </span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                             <img src="{{ asset('img/Icono_administración.png') }}" class="mr-4 md:w-6 md:h-6 w-12 h-12 inline">
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                Administración
                            </span>
                        </a>
                        <a href="{{ route('profile.show') }}"  class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                            <svg class="mr-2 h-12 w-12 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.41 0-8 2.69-8 6v2h16v-2c0-3.31-3.59-6-8-6z"></path>
                            </svg>
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                Perfil
                            </span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <a href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();" class="flex items-center px-4 py-8 text-black hover:bg-white transition-all duration-200 ease-in-out">
                            <svg class="h-12 w-12 mr-2 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3M14 5v3h-4V5h4z"></path>
                            </svg>
                            <span class="break-words whitespace-normal flex-1" x-show="open" 
                                x-transition:enter="transition-opacity ease-in-out duration-300" 
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                x-transition:leave="transition-opacity ease-in-out duration-300" 
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                               Cerrar Sesion
                            </span>
                        </a>
                        </form>
                        


                        
                    </div>
                </div>

                <!-- Page Content -->
               <main class="flex-1 px-4 py-6 sm:px-6 lg:px-1 overflow-auto h-full w-full ml-16 md:ml-0 transition-all duration-300 ease-in-out">
                    {{ $slot }}
                </main>

            </div>
        </div>
</div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
