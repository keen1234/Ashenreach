<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class SkillService
{
    /**
     * Add XP to a character skill and handle level ups (+1 level per threshold).
     */
    public function addSkillXp(Character $character, string $skillName, int $amount): Skill
    {
        return DB::transaction(function () use ($character, $skillName, $amount) {
            $skill = Skill::firstOrCreate(
                ['character_id' => $character->id, 'name' => $skillName],
                ['level' => 1, 'experience' => 0]
            );

            // Apply racial skill XP multiplier if human
            $multiplier = ($character->race === 'human') ? 1.05 : 1.0;
            $adjustedAmount = (int) round($amount * $multiplier);

            $skill->experience += $adjustedAmount;

            // Simple skill leveling curve: level * 100 XP per level
            $requiredXp = $skill->level * 100;
            while ($skill->experience >= $requiredXp) {
                $skill->experience -= $requiredXp;
                $skill->level++;
                $requiredXp = $skill->level * 100;
            }

            $skill->save();
            return $skill;
        });
    }

    /**
     * Add XP to character and handle level ups (+2 free stat points per level).
     */
    public function addCharacterXp(Character $character, int $amount): array
    {
        return DB::transaction(function () use ($character, $amount) {
            $character->experience += $amount;

            // Formula: PreviousLevelXP * 1.2 (Base level 1 requires 100 XP)
            $requiredXp = (int) (100 * pow(1.2, $character->level - 1));
            $leveledUp = false;

            while ($character->experience >= $requiredXp) {
                $character->experience -= $requiredXp;
                $character->level++;
                $leveledUp = true;

                // Refill bars on level up per spec
                $character->stamina = 100 + ($character->level * 5);
                $character->courage = 20 + ($character->level * 1);
                $character->focus = 50 + ($character->level * 2);

                $requiredXp = (int) (100 * pow(1.2, $character->level - 1));
            }

            $character->save();

            return [
                'character' => $character->fresh(),
                'leveled_up' => $leveledUp,
            ];
        });
    }
}
