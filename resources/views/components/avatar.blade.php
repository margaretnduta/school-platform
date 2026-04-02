@props(['photo' => null, 'name' => 'User', 'size' => 'sm'])

@php
    $initials = collect(explode(' ', $name))
                ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                ->take(2)
                ->implode('');

    $colors = [
        'bg-blue-500', 'bg-green-500', 'bg-purple-500',
        'bg-red-500',  'bg-yellow-500','bg-pink-500',
        'bg-indigo-500','bg-teal-500',
    ];
    $color = $colors[ord($name[0]) % count($colors)];

    // Fixed pixel sizes — not tied to Tailwind dynamic classes
    $sizes = [
        'xs'  => ['box' => '28px',  'font' => '11px'],
        'sm'  => ['box' => '36px',  'font' => '13px'],
        'md'  => ['box' => '56px',  'font' => '18px'],
        'lg'  => ['box' => '80px',  'font' => '26px'],
        'xl'  => ['box' => '110px', 'font' => '34px'],
    ];

    $box  = $sizes[$size]['box']  ?? '36px';
    $font = $sizes[$size]['font'] ?? '13px';
@endphp

@if($photo)
    <img src="{{ Storage::url($photo) }}"
         alt="{{ $name }}"
         style="width: {{ $box }}; height: {{ $box }}; min-width: {{ $box }}; min-height: {{ $box }};"
         class="rounded-full object-cover object-center border-2 border-gray-200 shadow-sm flex-shrink-0">
@else
    <div class="{{ $color }} rounded-full flex items-center justify-center
                text-white font-semibold border-2 border-gray-200 shadow-sm flex-shrink-0"
         style="width: {{ $box }}; height: {{ $box }}; min-width: {{ $box }};
                min-height: {{ $box }}; font-size: {{ $font }};">
        {{ $initials }}
    </div>
@endif