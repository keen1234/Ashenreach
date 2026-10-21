<?php

namespace App\Services;

use App\Models\Character;
use Illuminate\Support\Facades\DB;
use App\Models\ActionLog;

class ActionService
{
    public function __construct(
        protected BarService $barService,
        protected DiceService $diceService
    ) {}

    /**
     * Perform Gather action (spends 5 stamina, checks Wisdom or Strength, grants materials and gold).
     */
    public function gather(Character $character, string $zone = 'whispering_woods'): array
    {
        $staminaCost = 5;

        // Verify & spend stamina atomically
        return DB::transaction(function () use ($character, $zone, $staminaCost) {
            // Re-fetch with lock or check current value
            $currentStamina = $this->barService->getCurrentValue($character, 'stamina');
            if ($currentStamina < $staminaCost) {
                throw new \Exception('Not enough stamina.');
            }

            // Deduct stamina
            $this->barService->consume($character, 'stamina', $staminaCost);

            // DC for gathering (Medium = 12)
            $dc = 12;
            $statMod = $character->getModifier('wisdom'); // Herbalism / foraging uses Wisdom

            $rollResult = $this->diceService->check($dc, $statMod);

            $rewards = [];
            $goldEarned = 0;
            $xpEarned = 10;

            if ($rollResult['success']) {
                $goldEarned = $rollResult['crit_success'] ? random_int(10, 25) : random_int(3, 8);
                $rewards['gold'] = $goldEarned;
                $rewards['materials'] = ['herb' => $rollResult['crit_success'] ? 2 : 1];

                $character->gold += $goldEarned;
            } else {
                $rewards['materials'] = [];
                // Crit fail penalty: extra fatigue or minor loss
                if ($rollResult['crit_fail']) {
                    $rewards['penalty'] = 'Found nothing and bruised your fingers.';
                }
            }

            $character->experience += $xpEarned;
            $character->save();

            // Log action
            ActionLog::create([
                'character_id' => $character->id,
                'action_type' => 'gather',
                'roll_die' => $rollResult['die'],
                'stat_modifier' => $statMod,
                'skill_bonus' => 0,
                'total_roll' => $rollResult['total'],
                'difficulty_class' => $dc,
                'success' => $rollResult['success'],
                'rewards' => $rewards,
                'description' => $rollResult['success']
                    ? "Successfully foraged in {$zone}, earning {$goldEarned} gold."
                    : "Failed to forage in {$zone}.",
            ]);

            return [
                'roll' => $rollResult,
                'rewards' => $rewards,
                'character' => $character->fresh(),
            ];
        });
    }
}
