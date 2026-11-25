@props(['recipe'])

<article {{ $attributes->class([
    'flex items-start justify-between gap-3 rounded-2xl border-4 bg-white p-4 shadow-md',
    'border-fiesta-gold' => $recipe->is_favourite,
    'border-fiesta-blue/20' => ! $recipe->is_favourite,
]) }}>
    <div class="min-w-0">
        <h3 class="break-words text-xl font-extrabold text-fiesta-blue">{{ $recipe->title }}</h3>
        <div class="mt-2 flex flex-wrap gap-2">
            <x-badge color="blue">{{ $recipe->minutes }} min</x-badge>
            @if ($recipe->is_favourite)
                <x-badge color="gold">Paborito</x-badge>
            @endif
        </div>
    </div>
    <div>{{ $slot }}</div>
</article>