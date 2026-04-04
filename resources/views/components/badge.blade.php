@props(['variant' => 'primary'])

@php
$variants = [
    'primary' => 'badge-primary',
    'secondary' => 'badge-secondary',
    'success' => 'badge-success',
    'danger' => 'badge-danger',
    'warning' => 'badge-warning',
    'gray' => 'badge-gray',
];

$class = $variants[$variant] ?? $variants['primary'];
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $class]) }}>
    {{ $slot }}
</span>
