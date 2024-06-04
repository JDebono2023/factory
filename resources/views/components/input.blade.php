@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-400 rounded-md shadow-sm shadow-gray-400 ',
]) !!}>
