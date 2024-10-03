<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Agrega el estilo de la fuente Mulish */
        @import url('https://fonts.googleapis.com/css2?family=Mulish:wght@800&display=swap');

        .font-mulish {
            font-family: 'Mulish', sans-serif;
        }
    </style>
    <style>
       .custom-input:focus {
    border-color: #4f46e5; /* Morado */
    box-shadow: 0 0 0 1px #4f46e5; /* Morado */
    outline: none; /* Elimina el contorno predeterminado del navegador */
}

/* Estilo por defecto del borde */
.custom-input {
    border-color: #d1d5db; /* Gris claro */
    transition: border-color 0.3s, box-shadow 0.3s; /* Transición suave */
}

/* Estilo del borde en rojo para indicar un error */
.custom-input.error {
    border-color: #ef4444; /* Rojo */
    box-shadow: 0 0 0 1px #ef4444; /* Rojo */
}
        

    </style>
<style>
    /* Ocultar el ícono de contraseña por defecto */
    input[type="password"]::-ms-reveal {
        display: none; /* Para navegadores basados en Microsoft */
    }
    
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none; /* Para navegadores basados en WebKit como Chrome y Safari */
    }
    
    /* Para ocultar el ícono de contraseñas en otros navegadores */
    .custom-input::-webkit-inner-spin-button,
    .custom-input::-webkit-calendar-picker-indicator,
    .custom-input::-webkit-search-clear-button,
    .custom-input::-webkit-search-decoration,
    .custom-input::-webkit-search-results-button,
    .custom-input::-webkit-search-results-decoration {
        display: none;
    }
    
    /* Estilo del ícono del ojo personalizado */
    .password-toggle-icon {
        color: #9ca3af; /* Gris para el ícono */
        transition: color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .password-toggle-icon:hover {
        color: #6b7280; /* Gris más claro al pasar el cursor */
 /* Gris claro para el borde */
    }
</style>

</head>
<body class="bg-gray-100">

    <div class="flex flex-col md:flex-row w-full min-h-screen">
        
        <!-- Columna del formulario -->
        <div class="w-full md:w-1/2 flex items-center justify-center md:justify-end p-8 bg-white min-h-screen">
            <!-- Card en pantallas medianas y pequeñas -->
            <div class="w-full max-w-md p-8 rounded-lg shadow-md bg-white md:bg-transparent md:shadow-none md:p-0 md:ml-auto lg:w-1/2">
                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <div class="py-4">
                    <img src="{{ asset('img/synergo_icon_permision.png') }}" alt="Footer Image" class="mx-auto max-h-50">
                </div>
                <h2 class="mt-4 text-4xl tracking-tight leading-tight mb-6 font-mulish text-left" style="font-weight:800;letter-spacing:-.03em;line-height:2.25;">
                    Iniciar sesión
                </h2>
                <x-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('login') }}" class="w-full">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email *') }}</label>
                        <input id="email" 
                               class="block h-12 w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm custom-input"
                               type="email" 
                               name="email" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="ejemplo@ejemplo.com"/>
                        <p id="email-error" class="text-red-600 text-sm mt-1 hidden">El correo electrónico no es válido.</p>
                    </div>
                    
                    <div class="mb-4 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Contraseña *') }}</label>
                        <input id="password" 
                               class="block h-12 w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm custom-input pr-12"
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"/>
                        <span id="togglePassword" class="password-toggle-icon absolute inset-y-0 right-0 flex items-center justify-center pr-4 pt-6 cursor-pointer rounded-full">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    
                    
                                             
                    
                    

                    <div class="mb-4">
                        <a href="#" class="text-sm text-blue-600 hover:underline">Olvidaste contraseña?</a>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="w-full px-4 py-2 text-white rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2" style="background-color: #4f46e5">
                            {{ __('Ingresar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de la imagen -->
<div class="hidden md:flex w-1/2 relative overflow-hidden min-h-screen pl-8" style="background-color: #1e293b">
    <svg viewBox="0 0 960 540" class="absolute inset-0 w-full h-full object-cover text-gray-700 opacity-25" xmlns="http://www.w3.org/2000/svg">
        <g fill="none" stroke="currentColor" stroke-width="180">
            <!-- Primer círculo en la esquina superior izquierda -->
            <circle r="334" cx="40" cy="-100"></circle>
            <!-- Segundo círculo en la esquina inferior derecha -->
            <circle r="334" cx="940" cy="590"></circle>
        </g>
    </svg>
    <svg viewBox="0 0 220 192" width="220" height="192" fill="none" class="absolute -top-16 -right-16 text-gray-700">
        <defs>
            <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" fill="currentColor"></rect>
            </pattern>
        </defs>
        <rect width="220" height="192" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)"></rect>
    </svg>
    <div class="absolute inset-y-1/3 transform -translate-y-1/3 left-8">
        <div class="max-w-md mx-auto">
            <img src="{{ asset('img/synergo_icon_sup_left.png') }}" alt="Footer Image" class="max-h-10 max-w-28">
            <div class="text-5xl font-bold leading-none text-gray-100 pt-30 md:pt-40 text-justify">
                <div>
                    Bienvenido a
                </div>
                <div>
                    nuestra comunidad
                </div>
            </div>
            <div class="mt-6 text-lg tracking-tight leading-6 text-gray-400">
                SSO (Single Sign On), es el punto de entrada para acceder a la diversidad de sistemas del Corporativo.
            </div>
            <div class="flex items-center mt-8">
                <!-- Contenedor de imágenes -->
                <div class="flex items-center space-x-[-0.75rem] flex-shrink-0">
                    <img src="{{ asset('img/female-18.jpg') }}" class="w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover">
                    <img src="{{ asset('img/female-11.jpg') }}" class="w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover">
                    <img src="{{ asset('img/male-09.jpg') }}" class="w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover">
                    <img src="{{ asset('img/male-16.jpg') }}" class="w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover">
                </div>
                
                <!-- Texto -->
                <div class="ml-4 flex-grow font-medium tracking-tight text-gray-400">
                    Más de 17k personas se unieron a nosotros, es tu turno
                </div>
            </div>
            
            
        </div>
    </div>
</div>


               
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');

        emailInput.addEventListener('input', function () {
            const emailValue = emailInput.value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para correo electrónico

            if (emailPattern.test(emailValue)) {
                emailInput.classList.remove('error');
                emailError.classList.add('hidden');
            } else {
                emailInput.classList.add('error');
                emailError.classList.remove('hidden');
            }
        });
    });
</script>

    
    
</body>
</html>
