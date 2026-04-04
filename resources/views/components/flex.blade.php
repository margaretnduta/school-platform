@props(['alignment' => 'center'])

@php
$alignmentClasses = match($alignment) {
    'start' => 'justify-start',
    'between' => 'justify-between',
    'end' => 'justify-end',
    default => 'justify-center',
};
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3 ' . $alignmentClasses]) }}>
    {{ $slot }}
</div>
