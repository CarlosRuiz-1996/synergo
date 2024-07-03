<x-app-layout>
  <div class="flex items-center justify-center min-h-screen" style="background-image: url('{{ asset('img/bg.png') }}'); background-size: cover; background-position: center;" >
      <div class="">
          <!-- Sidebar -->
          <div class="w-full md:w-4/4">
              <div class="flex flex-col items-center justify-center mb-4">
                  <img class="h-auto max-w-full mb-4" src="{{ asset('img/logo-transparente.png') }}" width="400" alt="logo" style="filter: brightness(0) invert(1);">
              </div>
              <div class="menu-grid text-white">
                  <div class="menu-column">
                      <ul class="menu">
                          <li class="menu-item" data-submenu="submenu-1"><i class="fas fa-book mr-2"></i>CATÁLOGOS</li>
                          <li class="menu-item" data-submenu="submenu-2"><i class="fas fa-piggy-bank mr-2"></i>BANCOS
                              <ul class="submenu-items" id="submenu-2">
                                <a href="{{route('reporte.cajas')}}">
                                  <li class="submenu-item"><i class="fas fa-file-invoice mr-2"></i>Subir factura</li>
                                  <li class="submenu-item"><i class="fas fa-list-alt mr-2"></i>
                                   Clasificar pagos</li>
                                  <li class="submenu-item"><i class="fas fa-clipboard-check mr-2"></i>Pendientes de pagos</li>
                                  <li class="submenu-item"><i class="fas fa-hand-holding-usd mr-2"></i>Pagos por autorizar</li>
                                  <li class="submenu-item"><i class="fas fa-file-signature mr-2"></i>Pago autorizado por definir</li>
                                  <li class="submenu-item"><i class="fas fa-file mr-2"></i>Pago sin registro</li>
                                </a>
                              </ul>
                          </li>
                      </ul>
                  </div>
                  <div class="menu-column">
                      <ul class="menu">
                          <li class="menu-item" data-submenu="submenu-3"><i class="fas fa-address-card mr-2"></i>CATÁLOGO DE PERFILES</li>
                          <li class="menu-item" data-submenu="submenu-4"><i class="fas fa-search-dollar mr-2"></i>CONSULTA COSTO MAGNA</li>
                          <li class="menu-item" data-submenu="submenu-5"><i class="fas fa-wallet mr-2"></i>ESTABLECER PRESUPUESTO</li>
                          <li class="menu-item" data-submenu="submenu-6"><i class="fas fa-file-invoice-dollar mr-2"></i>PRESUPUESTO DE GASTOS</li>
                          <li class="menu-item" data-submenu="submenu-7">
                          <a href="{{route('cuentas.pagar')}}">
                            <i class="fas fa-file-alt mr-2"></i>CUENTAS POR PAGAR
                          </a>
                          </li>
                          <li class="menu-item" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>ESTACIONES</li>
                      </ul>
                  </div>
                  <div class="menu-column">
                      <ul class="menu">
                          <li class="menu-item" data-submenu="submenu-9"><i class="fas fa-coins mr-2"></i>TESORERÍA</li>
                          <li class="menu-item" data-submenu="submenu-10"><i class="fas fa-user-tie mr-2"></i>ADMINISTRATIVO</li>
                          <li class="menu-item" data-submenu="submenu-11"><i class="fas fa-chart-pie mr-2"></i>REPORTE</li>
                          <li class="menu-item" data-submenu="submenu-12"><i class="fas fa-tachometer-alt mr-2"></i>DASHBOARD</li>
                          <li class="menu-item" data-submenu="submenu-13"><i class="fas fa-boxes mr-2"></i>INVENTARIO</li>
                          <li class="menu-item" data-submenu="submenu-13"><i class="fas fa-boxes mr-2"></i><a href="{{ route('subir-archivo') }}">Ir a la página de subida de archivos</a></li>
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
