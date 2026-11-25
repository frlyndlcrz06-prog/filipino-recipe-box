<?php

namespace App\Livewire;

use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RecipeBox extends Component
{
    public string $title = '';

    public $minutes = '';

    public string $search = '';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:60'],
            'minutes' => ['required', 'integer', 'min:1', 'max:1440'],
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Every dish needs a name!',
            'title.min' => 'That name is too short. Use at least 3 characters.',
            'title.max' => 'That name is too long. Keep it under 60 characters.',
            'minutes.required' => 'How many minutes does it take to cook?',
            'minutes.integer' => 'Minutes must be a whole number.',
            'minutes.min' => 'Minutes must be at least 1.',
            'minutes.max' => 'That is more than a day! Use 1440 minutes or less.',
        ];
    }

    public function save(): void
    {
        $this->title = trim($this->title);

        $validated = $this->validate();

        Recipe::create([
            'title' => $validated['title'],
            'minutes' => (int) $validated['minutes'],
        ]);

        $this->reset('title', 'minutes');
    }

    public function toggleFavourite(int $id): void
    {
        $recipe = Recipe::findOrFail($id);

        $recipe->update(['is_favourite' => ! $recipe->is_favourite]);
    }

    public function render(): View
    {
        $term = addcslashes(trim($this->search), '%_\\');

        $recipes = Recipe::query()
            ->when($term !== '', fn ($query) => $query->where('title', 'ilike', "%{$term}%"))
            ->latest('id')
            ->get();

        return view('livewire.recipe-box', [
            'recipes' => $recipes,
            'favouriteCount' => Recipe::where('is_favourite', true)->count(),
        ]);
    }
}