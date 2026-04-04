@props(['type' => 'button', 'variant' => 'primary'])

@php
$variants = [
    'primary' => 'bg-gradient-to-r from-primary-500 to-primary-600 text-white hover:shadow-lg',
    'secondary' => 'bg-gradient-to-r from-secondary-500 to-secondary-600 text-white hover:shadow-lg',
    'success' => 'bg-gradient-to-r from-success-600 to-success-500 text-white hover:shadow-lg',
    'danger' => 'bg-gradient-to-r from-danger-600 to-danger-500 text-white hover:shadow-lg',
    'warning' => 'bg-gradient-to-r from-warning-500 to-warning-400 text-white hover:shadow-lg',
    'gray' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
    'white' => 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50',
];

$class = $variants[$variant] ?? $variants['primary'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn ' . $class]) }}>
    {{ $slot }}
</button>
