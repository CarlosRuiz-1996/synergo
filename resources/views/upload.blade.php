<x-app-layout>
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
                Cargar Factura(s)</h2>
                
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        
            <form action="{{ route('procesar-archivos') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="archivo_zip">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Subir archivo ZIP</button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>
