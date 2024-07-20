<x-app-layout>
    <div class="flex items-center justify-center min-h-screen" style="background-image: url('{{ asset('img/bg.png') }}'); background-size: cover; background-position: center;">
        <div class="">
            <!-- Sidebar -->
            <div class="w-full md:w-4/4">
                <div class="flex flex-col items-center justify-center mb-4">
                    <img class="h-auto max-w-full mb-4" src="{{ asset('img/logo-transparente.png') }}" width="400" alt="logo" style="filter: brightness(0) invert(1);">
                </div>
                <div class="menu-grid text-white">
                    <div class="menu-column mb-8">
                        <ul class="menu">
                            <li class="menu-item text-lg" data-submenu="submenu-3"><i class="fas fa-address-card mr-2"></i><a href="{{route('usuarios')}}">Catálogo de Perfiles</a></li>
                            <li class="menu-item text-lg" data-submenu="submenu-4"><i class="fas fa-search-dollar mr-2"></i><a href="{{ route('reporte.reporteResumenCompras') }}">Consulta Determinacion de costo promedio</a></li>
                            <li class="menu-item text-lg" data-submenu="submenu-5"><i class="fas fa-wallet mr-2"></i>Establecer Presupuesto</li>
                            <li class="menu-item text-lg" data-submenu="submenu-6"><i class="fas fa-file-invoice-dollar mr-2"></i>Presupuesto de Gastos</li>
                            <li class="menu-item text-lg" data-submenu="submenu-7">
                                <a href="{{route('cuentas.pagar')}}">
                                    <i class="fas fa-file-alt mr-2"></i>Cuentas Por Pagar
                                </a>
                            </li>
                            <li class="menu-item text-lg" data-submenu="submenu-8">
                                <a href="{{route('catalogos.estaciones')}}">
                                    <i class="fas fa-gas-pump mr-2"></i>Estaciones
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu-column mb-8 ml-4">
                        <ul class="menu ml-4">
                            <li class="menu-item text-lg" data-submenu="submenu-9"><i class="fas fa-coins ml-6"></i>Tesorería</li>
                            <li class="menu-item text-lg" data-submenu="submenu-10"><i class="fas fa-user-tie ml-6"></i>Administrativo</li>
                            <li class="menu-item text-lg" data-submenu="submenu-11"><i class="fas fa-chart-pie ml-6"></i>Reporte</li>
                            <li class="menu-item text-lg" data-submenu="submenu-12"><i class="fas fa-tachometer-alt ml-6"></i>Dashboard</li>
                            <li class="menu-item text-lg" data-submenu="submenu-13"><i class="fas fa-boxes ml-6"></i>Inventario</li>
                        </ul>
                    </div>
                    <div class="menu-column">
                        <ul class="menu">
                            <li class="menu-item text-lg" data-submenu="submenu-1"><i class="fas fa-book"></i>Catálogos</li>
                            <li class="menu-item text-lg" data-submenu="submenu-2"><i class="fas fa-piggy-bank"></i>Bancos
                                <ul class="submenu-items" id="submenu-2">
                                    <a href="{{route('reporte.cajas')}}">
                                        <li class="submenu-item text-lg"><i class="fas fa-file-invoice"></i><a href="{{ route('subir-archivo') }}">Subir factura</a></li>
                                        <li class="submenu-item text-lg"><i class="fas fa-list-alt"></i>Clasificar pagos</li>
                                        <li class="submenu-item text-lg"><i class="fas fa-clipboard-check"></i>Pendientes de pagos</li>
                                        <li class="submenu-item text-lg"><i class="fas fa-hand-holding-usd"></i>Pagos por autorizar</li>
                                        <li class="submenu-item text-lg"><i class="fas fa-file-signature"></i>Pago autorizado por definir</li>
                                        <li class="submenu-item text-lg"><i class="fas fa-file"></i>Pago sin registro</li>
                                    </a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .menu-grid {
            display: flex;
        }

        .menu-column {
            flex: 1;
            margin-right: 20px;
        }

        .menu {
            list-style: none;
            padding: 0;
        }

        .menu-item {
            margin-bottom: 10px;
            cursor: pointer;
        }

        .submenu-items {
            list-style: none;
            padding-left: 20px;
            display: none;
        }

        .submenu-item {
            margin-bottom: 5px;
        }

        .show {
            display: block !important;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener("click", function() {
                    const submenuId = item.getAttribute('data-submenu');
                    const submenu = document.getElementById(submenuId);
                    if (submenu) {
                        submenu.classList.toggle('show');
                    }
                });
            });
        });
    </script>
</x-app-layout>
