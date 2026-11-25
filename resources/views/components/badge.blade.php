@props(['color' => 'blue'])

@php
    $tones = [
        'blue' => 'bg-fiesta-blue text-white',
        'red' => 'bg-fiesta-red text-white',
        'gold' => 'bg-fiesta-gold text-fiesta-brown',
        'leaf' => 'bg-fiesta-leaf text-white',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block rounded-full px-3 py-1 text-sm font-semibold '.($tones[$color] ?? $tones['blue'])]) }}>
    {{ $slot }}
</span>