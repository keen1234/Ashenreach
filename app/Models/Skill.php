<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'name',
        'level',
        'experience',
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
