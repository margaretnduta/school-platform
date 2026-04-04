@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'input ' . ($errors->has($attributes->get('name')) ? 'input-error' : '')]) !!}>
