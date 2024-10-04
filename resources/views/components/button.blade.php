<button {{ $attributes->merge([
    'style' => '', 
    'type' => 'submit', 
    'class' => 'inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-wider shadow-sm hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>