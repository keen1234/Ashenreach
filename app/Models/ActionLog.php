<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'action_type',
        'roll_die',
        'stat_modifier',
        'skill_bonus',
        'total_roll',
        'difficulty_class',
        'success',
        'rewards',
        'description',
    ];

    protected $casts = [
        'rewards' => 'array',
        'success' => 'boolean',
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
