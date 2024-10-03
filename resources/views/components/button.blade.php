<button {{ $attributes->merge([
    'style' => '', 
    'type' => 'submit', 
    'class' => 'inline-flex items-center justify-center px-4 py-4 border border-transparent font-semibold text-sm text-white uppercase tracking-wider shadow-sm  focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
