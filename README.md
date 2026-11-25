# Fiesta Recipe Box (Week 14)

A small reactive Recipe Box for Filipino dishes, built with Laravel, Livewire, Blade components, Tailwind CSS, and PostgreSQL. A person adds recipes, searches them as they type, and marks favourites. The page updates without reloading.

## Run it

```bash
composer install
npm install
cp .env.example .env        # set the PostgreSQL DB_* values (database: recipe_box)
php artisan key:generate
php artisan migrate:fresh   # no seeder needed
npm run build               # or "npm run dev" while developing
php artisan serve
```

Then open `http://127.0.0.1:8000`. The `.env` file is not in the repository.

## How it is built

- **Table:** `recipes` has `title`, `minutes`, and `is_favourite`. A database CHECK constraint refuses minutes that are zero or negative.
- **Livewire component:** `App\Livewire\RecipeBox` handles adding a recipe (with validation), live search, and toggling a favourite.
- **Blade components:** `<x-recipe-card>` shows one recipe, and `<x-badge>` is the small coloured label used for minutes, favourites, and the favourite count. Both accept props and merge the classes they are given.
- **Styling:** Tailwind CSS with a Filipino fiesta theme (banderitas, the colours of the flag, and warm cream). The layout works on a phone and on a wide screen.

## Manual tests

| Case | What was done | Expected result |
|---|---|---|
| Empty page | Opened the page after `migrate:fresh` | The empty message is shown |
| Empty form | Submitted with no title | Error next to the title, nothing saved |
| Short title | Submitted the title `ab` | Error about at least 3 characters, nothing saved |
| Minutes of zero | Submitted minutes `0` | Error next to minutes, nothing saved |
| Search with matches | Typed `adobo` | Only matching dishes are listed |
| Search with no matches | Typed `pizza` | The "no dishes match" message is shown |
| Favourite and reload | Marked a favourite, then reloaded the page | The favourite and the count are still there |
| Phone width | Viewed the page at phone width | One column, nothing cut off |

## Questions

**What is the difference between `wire:model` and `wire:model.live`, and which one did we use for the search box and why?**
`wire:model` is deferred: the typed value stays in the browser and is only sent to the server together with the next action, such as submitting the form. `wire:model.live` sends a request to the server whenever the input changes, so the component updates while the person types. For the search box we used `wire:model.live.debounce.400ms`. The list has to filter as the person types, and the debounce waits until they pause for 400 milliseconds, so the page does not send a request for every key press. The form fields use plain `wire:model` because they only need to be sent when the form is submitted.

**Why must the add action validate even though the form already shows errors?**
The errors on the page come from the server, but the form is not a safety barrier. Anyone can send their own request to the component with any values, for example from the browser's developer tools, and skip the form completely. The `save` action must validate before it saves, so an empty title or zero minutes never reaches the database. The database CHECK constraint on `minutes` is a second line of defence. The same idea applies to `toggleFavourite`, which receives an id from the browser and uses `findOrFail` instead of trusting it.

**What did our Blade component save us from repeating?**
`<x-recipe-card>` holds the whole card (the layout, the border that changes for a favourite, the title, the minutes badge, and a slot for the star button), so we write it once and loop it instead of copying that markup for every recipe. `<x-badge>` holds the pill styling and the colour choices, and it is reused for the minutes, the "Paborito" label, and the favourite count. Because both components merge the classes they are given, a page can adjust one place without copying the markup.
