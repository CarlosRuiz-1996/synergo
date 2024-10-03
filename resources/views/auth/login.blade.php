

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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="flex flex-col h-screen" >
    <div class="flex-grow font-sans text-gray-900 antialiased">
        <div class="min-h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-image: url('{{ asset('img/bg.png') }}'); background-size: cover; background-position: center;">
            <!-- Ajustar el ancho a un tamaño mayor, como max-w-lg o max-w-xl -->
            <div class="w-full sm:max-w-xl lg:max-w-2xl mt-6 px-6 py-6 overflow-hidden">
                <p class="text-white text-4xl mb-6 text-center">Iniciar sesión</p> <!-- Centrar el título y agregar margen inferior -->
                
                <x-validation-errors class="mb-4" />
        
                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession
        
                <form method="POST" action="{{ route('login') }}" class="space-y-6"> <!-- Agregar la clase space-y-6 para separar los campos -->
                    @csrf
        
                    <div>
                        <label class="block font-medium text-md text-white" for="email">Correo</label>
                        <input id="email" class="bg-transparent text-white border-0 border-b-2 border-gray-300 focus:border-indigo-500 focus:ring-0 focus:outline-none w-full py-2 px-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
        
                    <div class="mt-4">
                        <label class="block font-medium text-md text-white" for="password">Contraseña</label>
                        <input id="password" class="bg-transparent text-white border-0 border-b-2 border-gray-300 focus:border-indigo-500 focus:ring-0 focus:outline-none w-full py-2 px-3" type="password" name="password" required autocomplete="current-password" />
                    </div>
        
                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-md text-white">{{ __('Recordar') }}</span>
                        </label>
                    </div>
        
                    <div class="flex items-center justify-end mt-6 mb-4">
                        <div class="w-full">
                            <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-wider shadow-sm hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                                {{ __('Ingresar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        </div>

    <footer class="bg-gray-100 text-white">
        <div class="container mx-auto text-center">
            <img src="{{ asset('img/logo-transparente.png') }}" alt="Footer Image" class="mx-auto max-h-20">
        </div>
    </footer>

    @livewireScripts
</body>
</html>