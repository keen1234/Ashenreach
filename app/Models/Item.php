<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'rarity',
        'base_value',
        'max_durability',
        'weight',
        'is_bound',
        'stats',
    ];

    protected $casts = [
        'stats' => 'array',
        'is_bound' => 'boolean',
    ];
}
