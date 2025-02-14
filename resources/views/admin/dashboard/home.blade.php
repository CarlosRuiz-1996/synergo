<x-app-layout>

    <div class="bg-gray-100 min-h-screen p-6">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Administración</h1>
            {{-- <input type="text" placeholder="Buscar..." class="px-4 py-2 border rounded-lg shadow-sm"> --}}
        </div>


        <!-- Sección de Gráficos y Tabla -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Top 10 ventas / estaciones (espacio para Chart.js) -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Top 10 ventas / estaciones</h2>
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <canvas id="top10"></canvas>

                </div>
            </div>
            <!-- Evolución costo promedio (espacio para Chart.js) -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Evolución costo promedio</h2>
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <canvas id="costo_promedio"></canvas>
                </div>
            </div>
            <!-- Historial de ventas Ganancia estimada (espacio para Chart.js) -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Historial de ventas Ganancia estimada
                </h2>
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <canvas id="historial"></canvas>
                </div>
            </div>
            <!-- Ganancia estimada (espacio para Chart.js) -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Ganancia estimada</h2>
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <canvas id="ganancia"></canvas>
                </div>
            </div>

        </div>
    </div>
   
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('top10').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Tipos: bar, line, pie, etc.
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                        datasets: [{
                            label: 'Ventas',
                            data: [12, 19, 3, 5, 2],
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            });
                document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('costo_promedio').getContext('2d');
                new Chart(ctx, {
                    type: 'line', // Tipos: bar, line, pie, etc.
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                        datasets: [{
                            label: 'Ventas',
                            data: [12, 19, 3, 5, 2],
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

            });
                document.addEventListener("DOMContentLoaded", function() {


                const ctx = document.getElementById('historial').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Tipos: bar, line, pie, etc.
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                        datasets: [{
                            label: 'Ventas',
                            data: [12, 19, 3, 5, 2],
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });


            });
            document.addEventListener("DOMContentLoaded", function() {

                const ctx = document.getElementById('ganancia').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Tipos: bar, line, pie, etc.
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                        datasets: [{
                            label: 'Ventas',
                            data: [12, 19, 3, 5, 2],
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            });
        </script>
   


</x-app-layout>