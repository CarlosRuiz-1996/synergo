<div>
    <div x-data="{
        openWindows: [],
        minimizedWindows: [],
        activeWindow: null
        }"
        @open-window.window="event => {
            let newWin = {
                name: event.detail.name,
                title: event.detail.title
            };
            if (!openWindows.some(win => win.name === newWin.name) && !minimizedWindows.includes(newWin.name)) {
                if (activeWindow) minimizedWindows.push(activeWindow.name);
                openWindows.push(newWin);
                activeWindow = newWin;
            }
        }"
    
    >

        <!-- Menú de opciones -->
        <div x-show="openWindows.length === 0 || openWindows.every(win => minimizedWindows.some(minWin => minWin.name === win.name))"
            class="space-x-4">


            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Catalogos de Gasolineras</h1>
            </div>
            <ul class="menu">
                <li class="menu-item text-lg" data-submenu="submenu-3"><i class="fas fa-address-card mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.aceites', title:'Catalogos Aceites' })" class="cursor-pointer">Catálogo de Aceites</a>

                </li>
                <li class="menu-item text-lg" data-submenu="submenu-4"><i class="fas fa-search-dollar mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.bancos-ctg', title:'Catalogos Bancos' })" class="cursor-pointer">Catálogo de Bancos</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-5"><i class="fas fa-wallet mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.combustibles-ctg', title:'Catalogos Combistibles' })" class="cursor-pointer">Catálogo de Combustibles</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-6"><i class="fas fa-file-invoice-dollar mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.con-gastos-ctg', title:'Catalogos conGastos' })" class="cursor-pointer">Catálogo de conGastos</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-7"><i class="fas fa-file-alt mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.despachadores-ctg', title:'Catalogos Despachadores' })" class="cursor-pointer">Catálogo de Despachadores</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.formas-pago-ctg', title:'Catalogos Formas de pago' })" class="cursor-pointer">Catálogo de Formas de pago</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.fp-divicions-ctg', title:'Catalogos FP Divisiones' })" class="cursor-pointer">Catálogo de FP Divicions</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.gastos-ctg', title:'Catalogos Gastos' })" class="cursor-pointer">Catálogo de Gastos</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.mangueras-ctg', title:'Catalogos Mangueras' })" class="cursor-pointer">Catálogo de Mangueras</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.provedores-ctg', title:'Catalogos Provedores' })" class="cursor-pointer">Catálogo de Provedores</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.reportes-ctg', title:'Catalogos Reportes' })" class="cursor-pointer">Catálogo de Reportes</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.tablas-ctg', title:'Catalogos Tablas' })" class="cursor-pointer">Catálogo de Tablas</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.tanques-ctg', title:'Catalogos Tanques' })" class="cursor-pointer">Catálogo de Tanques</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.tipos-ctg', title:'Catalogos Tipos' })" class="cursor-pointer">Catálogo de Tipos</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.turnos-ctg', title:'Catalogos Turnos' })" class="cursor-pointer">Catálogo de Turnos</a>
                </li>
                <li class="menu-item text-lg" data-submenu="submenu-8"><i class="fas fa-gas-pump mr-2"></i>
                    <a @click="$dispatch('open-window', { name: 'catalogos.vales-gases-ctg', title:'Catalogos Vales de Gas' })" class="cursor-pointer">Catálogo de Vales de gas</a>
                </li>
            </ul>

        </div>

        <!-- Ventanas flotantes -->
        <template x-for="(win, index) in openWindows" :key="index">
            <div x-show="activeWindow && activeWindow.name === win.name" class="fixed top-40 ml-5 p-4 bg-white shadow-lg border rounded-lg" style="width: 90%">

                <div class="flex justify-between items-center p-4 mb-4 bg-black rounded-2xl shadow-md">
                    <h2 class="text-xl font-bold text-white" x-text="win.title"></h2>
                    
                    <div class="space-x-2">
                        <button @click="minimizedWindows.push({ name: win.name, title: win.title }); activeWindow = null"
                            class="text-gray-400 hover:text-white">
                            <i class="fa-solid fa-square-minus"></i>
                        </button>
                        
                        <button @click="openWindows.splice(index, 1); activeWindow = null"
                            class="text-red-500 hover:text-red-300">
                            <i class="fa-solid fa-rectangle-xmark"></i>
                        </button>
                    </div>
                </div>
                
                <div class="overflow-auto h-[calc(100%-4rem)]">
                    <template x-if="win.name === 'catalogos.aceites'">
                        @livewire('catalogos.aceites')
                    </template>
                    <template x-if="win.name === 'catalogos.bancos-ctg'">
                        @livewire('catalogos.estaciones')
                    </template>
                    <template x-if="win.name === 'catalogos.combustibles-ctg'">
                        @livewire('catalogos.combustibles-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.con-gastos-ctg'">
                        @livewire('catalogos.con-gastos-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.despachadores-ctg'">
                        @livewire('catalogos.despachadores-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.formas-pago-ctg'">
                        @livewire('catalogos.formas-pago-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.fp-divicions-ctg'">
                        @livewire('catalogos.fp-divicions-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.gastos-ctg'">
                        @livewire('catalogos.gastos-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.mangueras-ctg'">
                        @livewire('catalogos.mangeras-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.provedores-ctg'">
                        @livewire('catalogos.provedores-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.reportes-ctg'">
                        @livewire('catalogos.reportes-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.tablas-ctg'">
                        @livewire('catalogos.tablas-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.tanques-ctg'">
                        @livewire('catalogos.tanques-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.tipos-ctg'">
                        @livewire('catalogos.tipos-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.turnos-ctg'">
                        @livewire('catalogos.turnos-ctg')
                    </template>
                    <template x-if="win.name === 'catalogos.vales-gases-ctg'">
                        @livewire('catalogos.vales-gases-ctg')
                    </template>
                </div>
                
            </div>
        </template>

        <!-- Pestañas minimizadas -->
        <div class="fixed bottom-0 w-full bg-gray-100 border-t p-2 flex space-x-2">
            <template x-for="(minWin, minIndex) in minimizedWindows" :key="minIndex">
                <button @click="activeWindow = minWin; minimizedWindows.splice(minIndex, 1)"
                        class="bg-black px-4 py-2 rounded-lg flex items-center space-x-2">
                    <span x-text="minWin.title" class="text-white"></span>
                    <i class="fa-solid fa-maximize text-white"></i>
                </button>
            </template>
        </div>
        

    </div>

    @pushOnce('js')
        <script>
            document.addEventListener('livewire:initialized', () => {

                @this.on('confirm', (ctg_id) => {

                    var txt = ctg_id != null ? "Actualizado" : "Creado"
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se ha " + txt,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            @this.dispatch('save-ctg');

                        }
                    })
                });


                Livewire.on('alert', function([message]) {
                    Swal.fire({
                        // position: 'top-end',
                        icon: message[1],
                        title: message[0],
                        showConfirmButton: false,
                        timer: 1500
                    })


                });


                @this.on('delete', (ctg) => {
                    console.log(ctg)
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se eliminara de la base de datos",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                      
                        if (result.isConfirmed) {

                            @this.dispatch('delete-ctg',{ctg:ctg});

                        }
                    })
                });

                @this.on('confirm-combustible', (ctg_id) => {

                    var txt = ctg_id != null ? "Actualizado" : "Creado"
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se ha " + txt,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            @this.dispatch('save-combustible');

                        }
                    })
                });

                @this.on('delete-combustible', (ctg) => {
                    console.log(ctg)
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se eliminara de la base de datos",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                      
                        if (result.isConfirmed) {

                            @this.dispatch('delete-combustible',{ctg:ctg});

                        }
                    })
                });
                @this.on('confirm-proveedor', (ctg_id) => {

                    var txt = ctg_id != null ? "Actualizado" : "Creado"
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se ha " + txt,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            @this.dispatch('save-proveedor');

                        }
                    })
                });

                @this.on('delete-proveedor', (ctg) => {
                    console.log(ctg)
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: "La estación se eliminara de la base de datos",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, adelante!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    
                        if (result.isConfirmed) {

                            @this.dispatch('delete-proveedor',{ctg:ctg});

                        }
                    })
                });


            });
        </script>
    @endPushOnce

</div>
