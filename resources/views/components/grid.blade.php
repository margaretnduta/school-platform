@props(['cols' => '3', 'gap' => '6'])

@php
$gridColsClasses = match($cols) {
    '1' => 'grid-cols-1',
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
    '5' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-5',
    '6' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6',
    default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
};

$gapClass = 'gap-' . $gap;
@endphp

<div {{ $attributes->merge(['class' => 'grid ' . $gridColsClasses . ' ' . $gapClass]) }}>
    {{ $slot }}
</div>
