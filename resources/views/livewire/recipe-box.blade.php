<div class="mx-auto max-w-5xl px-4 py-8">
    <div class="grid gap-8 lg:grid-cols-3">

        <section class="lg:col-span-1">
            <form wire:submit="save" novalidate
                  class="space-y-4 rounded-2xl border-4 border-fiesta-gold bg-white p-5 shadow-lg">
                <h2 class="text-2xl font-extrabold text-fiesta-red">Add a dish to the feast</h2>

                <div>
                    <label for="title" class="block font-semibold">Dish name</label>
                    <input id="title" type="text" wire:model="title" placeholder="e.g. Chicken Adobo"
                           class="mt-1 w-full rounded-lg border-2 border-fiesta-blue/30 px-3 py-2 focus:border-fiesta-blue focus:outline-none">
                    @error('title')
                        <p class="mt-1 text-sm font-semibold text-fiesta-red">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minutes" class="block font-semibold">Cooking time (minutes)</label>
                    <input id="minutes" type="number" wire:model="minutes" placeholder="e.g. 60"
                           class="mt-1 w-full rounded-lg border-2 border-fiesta-blue/30 px-3 py-2 focus:border-fiesta-blue focus:outline-none">
                    @error('minutes')
                        <p class="mt-1 text-sm font-semibold text-fiesta-red">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                        class="w-full rounded-full bg-fiesta-red px-5 py-2 text-lg font-extrabold text-white transition hover:bg-fiesta-blue disabled:opacity-60">
                    <span wire:loading.remove wire:target="save">Add to the feast</span>
                    <span wire:loading wire:target="save">Cooking...</span>
                </button>
            </form>
        </section>

        <section class="lg:col-span-2">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <input type="search" wire:model.live.debounce.400ms="search" placeholder="Search the fiesta table..."
                       class="w-full rounded-full border-2 border-fiesta-blue/30 bg-white px-4 py-2 focus:border-fiesta-blue focus:outline-none sm:max-w-sm">
                <x-badge color="red">{{ $favouriteCount }} {{ $favouriteCount === 1 ? 'favourite' : 'favourites' }}</x-badge>
            </div>

            <p wire:loading wire:target="search" class="mb-3 text-sm font-semibold text-fiesta-blue">
                Searching the fiesta table...
            </p>

            <div class="grid gap-4 sm:grid-cols-2">
                @forelse ($recipes as $recipe)
                    <x-recipe-card :recipe="$recipe" wire:key="recipe-{{ $recipe->id }}">
                        <button type="button"
                                wire:click="toggleFavourite({{ $recipe->id }})"
                                wire:loading.class="opacity-40"
                                wire:target="toggleFavourite({{ $recipe->id }})"
                                aria-label="{{ $recipe->is_favourite ? 'Remove from favourites' : 'Mark as favourite' }}"
                                class="text-4xl leading-none text-fiesta-gold transition hover:scale-110">
                            {{ $recipe->is_favourite ? '★' : '☆' }}
                        </button>
                    </x-recipe-card>
                @empty
                    <div class="rounded-2xl border-4 border-dashed border-fiesta-gold bg-white p-8 text-center sm:col-span-2">
                        @if ($search !== '')
                            <p class="text-xl font-extrabold text-fiesta-red">No dishes match "{{ $search }}"</p>
                            <p>Try another name, or add it to the feast!</p>
                        @else
                            <p class="text-xl font-extrabold text-fiesta-red">The fiesta table is empty</p>
                            <p>Add your first Filipino dish to start the handaan!</p>
                        @endif
                    </div>
                @endforelse
            </div>
        </section>

    </div>
</div>