<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-white']) }}>
    {{ $slot }}
</button>
