@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-md text-black']) }}  style="font-family:Mulish">
    {{ $value ?? $slot }}
</label>
