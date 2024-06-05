@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-transparent text-white border-0 border-b-2 border-gray-300 focus:border-indigo-500 focus:ring-0 focus:outline-none py-2']) !!}>
