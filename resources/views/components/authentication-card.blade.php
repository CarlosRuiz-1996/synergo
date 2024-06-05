<div class="min-h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-image: url('{{ asset('img/bg.png') }}'); background-size: cover; background-position: center;">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4">
        {{ $slot }}
    </div>
</div>
