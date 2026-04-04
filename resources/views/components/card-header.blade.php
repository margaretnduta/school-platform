<div {{ $attributes->merge(['class' => 'px-6 py-4 border-b border-gray-200 bg-gray-50']) }}>
    <div class="flex items-center justify-between">
        {{ $slot }}
    </div>
</div>
