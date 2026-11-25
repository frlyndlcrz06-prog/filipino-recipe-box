<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['title', 'minutes', 'is_favourite'];

    protected function casts(): array
    {
        return ['is_favourite' => 'boolean'];
    }
}