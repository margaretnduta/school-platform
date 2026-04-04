@props(['active' => false])

@php
$class = $active ?? false
    ? 'inline-block px-3 py-1.5 rounded-lg border-2 border-primary-200 bg-primary-50 text-xs font-semibold text-primary-700 uppercase tracking-wide'
    : 'inline-block px-3 py-1.5 rounded-lg border-2 border-transparent text-xs font-semibold text-gray-700 uppercase tracking-wide hover:border-gray-300 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
