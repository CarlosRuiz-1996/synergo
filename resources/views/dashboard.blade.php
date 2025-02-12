<x-app-layout>
    <div class="bg-gray-100 min-h-screen p-6">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Gasolineras</h1>
            <input type="text" placeholder="Buscar..." class="px-4 py-2 border rounded-lg shadow-sm">
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total de Ventas -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <i class="fas fa-dollar-sign text-4xl text-green-500"></i>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-lg">Total Ventas</h2>
                    <p class="text-2xl font-semibold">$1,250,000</p>
                </div>
            </div>
            
            <!-- Estaciones Activas -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <i class="fas fa-gas-pump text-4xl text-blue-500"></i>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-lg">Estaciones Activas</h2>
                    <p class="text-2xl font-semibold">12</p>
                </div>
            </div>
            
            <!-- Inventario de Combustible -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <i class="fas fa-chart-line text-4xl text-orange-500"></i>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-lg">Inventario Disponible</h2>
                    <p class="text-2xl font-semibold">320,000 L</p>
                </div>
            </div>
        </div>

        <!-- Sección de Gráficos y Tabla -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Gráfica de Ventas (espacio para Chart.js) -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Gráfica de Ventas</h2>
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">[Gráfica aquí]</span>
                </div>
            </div>

            <!-- Últimas Transacciones -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Últimas Transacciones</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 text-left text-gray-600">Fecha</th>
                            <th class="p-2 text-left text-gray-600">Concepto</th>
                            <th class="p-2 text-right text-gray-600">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="p-2">10 Feb 2025</td>
                            <td class="p-2">Compra de Combustible</td>
                            <td class="p-2 text-right">$50,000</td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-2">9 Feb 2025</td>
                            <td class="p-2">Mantenimiento</td>
                            <td class="p-2 text-right">$15,000</td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-2">8 Feb 2025</td>
                            <td class="p-2">Pago de Nómina</td>
                            <td class="p-2 text-right">$120,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
