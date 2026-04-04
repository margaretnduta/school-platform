@props(['compact' => false])

@php
$class = $compact ? 'card-compact' : 'card';
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</div>
