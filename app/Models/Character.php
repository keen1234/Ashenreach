<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'race',
        'level',
        'experience',
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
        'gold',
        'stamina',
        'stamina_updated_at',
        'courage',
        'courage_updated_at',
        'focus',
        'focus_updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get final stat including racial bonuses.
     */
    public function getFinalStat(string $stat): int
    {
        $base = $this->$stat ?? 8;
        $races = [
            'human' => ['bonuses' => ['strength' => 1, 'dexterity' => 1, 'constitution' => 1, 'intelligence' => 1, 'wisdom' => 1, 'charisma' => 1]],
            'elf' => ['bonuses' => ['strength' => 0, 'dexterity' => 2, 'constitution' => -1, 'intelligence' => 1, 'wisdom' => 0, 'charisma' => 0]],
            'dwarf' => ['bonuses' => ['strength' => 1, 'dexterity' => 0, 'constitution' => 2, 'intelligence' => 0, 'wisdom' => 0, 'charisma' => -1]],
            'orc' => ['bonuses' => ['strength' => 2, 'dexterity' => 0, 'constitution' => 1, 'intelligence' => -1, 'wisdom' => 0, 'charisma' => 0]],
            'halfling' => ['bonuses' => ['strength' => -1, 'dexterity' => 2, 'constitution' => 0, 'intelligence' => 0, 'wisdom' => 0, 'charisma' => 1]],
            'tiefling' => ['bonuses' => ['strength' => 0, 'dexterity' => 0, 'constitution' => 0, 'intelligence' => 1, 'wisdom' => -1, 'charisma' => 2]],
        ];

        try {
            $configRaces = config('game.races', []);
            if (!empty($configRaces)) {
                $races = $configRaces;
            }
        } catch (\Throwable $e) {
            // fallback to array above
        }

        $bonus = $races[$this->race]['bonuses'][$stat] ?? 0;

        return min(20, $base + $bonus);
    }

    /**
     * Calculate stat modifier: floor((stat - 10) / 2)
     */
    public function getModifier(string $stat): int
    {
        $final = $this->getFinalStat($stat);
        return (int) floor(($final - 10) / 2);
    }
}
