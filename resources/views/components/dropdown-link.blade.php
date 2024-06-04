@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-blue-6 text-left text-base font-medium text-blue-6 bg-gray-200 focus:outline-none focus:text-gray-800 focus:bg-blue-1 focus:border-blue-6 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base  text-gray-900 hover:text-gray-500 hover:bg-gray-50 hover:border-gray-500 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>




{{-- <a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>{{ $slot }}</a> --}}
