<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'result_item_id',
        'focus_cost',
        'difficulty_class',
        'skill_required',
    ];

    public function resultItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'result_item_id');
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}
