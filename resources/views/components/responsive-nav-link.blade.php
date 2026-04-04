@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-primary-500 text-left text-base font-medium text-primary-700 bg-primary-50 focus:outline-none transition duration-200'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-primary-700 hover:bg-gray-50 hover:border-primary-400 focus:outline-none focus:text-primary-800 focus:bg-gray-50 focus:border-primary-500 transition duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
