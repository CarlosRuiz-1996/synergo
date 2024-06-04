<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-welcome /> --} }
            </div>
        </div>
    </div> --}}
    <div class="flex items-center justify-center h-screen bg-blue-800">
        <div class="">
          <!-- Sidebar -->
          <div class="w-full md:w-4/4 border-r p-4">
            <div class=" flex flex-col items-center justify-center mb-4">
              <img class="h-auto max-w-full mb-4" src="{{ asset('img/logo-transparente.png') }}" width="150" alt="logo">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
              <ul class="list-none p-0">
                <li class="mb-2"><strong>BANCOS</strong></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">SUBIR FACTURA</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">CLASIFICAR PAGOS</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">PENDIENTE DE PAGO</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">PAGO POR AUTORIZAR</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">PAGO AUTORIZADO POR DEFINIR</a></li>
              </ul>
              <ul class="list-none p-0">
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">PAGOS SIN REGISTRO</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">CATALOGO DE PERFILES</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">CONSULTA COSTO MAGNA</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">ESTABLECER PRESUPUESTO</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">PRESUPUESTO DE GASTOS</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">CUENTAS POR PAGAR</a></li>
              </ul>
              <ul class="list-none p-0">
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">TESORERIA</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">ADMINISTRATIVO</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">REPORTES</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">DASHBOARD</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">INVENTARIO</a></li>
                <li class="mb-2"><a href="#" class="text-blue-500 hover:underline">ESTACIONES</a></li>
              </ul>
            </div>
          </div>
         
        </div>
    </div>
</x-app-layout>
