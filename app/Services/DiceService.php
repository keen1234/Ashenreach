<?php

namespace App\Services;

class DiceService
{
    /**
     * Roll a d20 using cryptographic/secure random_int.
     */
    public function rollD20(bool $advantage = false, bool $disadvantage = false): int
    {
        $roll1 = random_int(1, 20);

        if ($advantage && !$disadvantage) {
            $roll2 = random_int(1, 20);
            return max($roll1, $roll2);
        }

        if ($disadvantage && !$advantage) {
            $roll2 = random_int(1, 20);
            return min($roll1, $roll2);
        }

        return $roll1;
    }

    /**
     * Roll damage dice (e.g. 1d6, 2d6).
     */
    public function rollDamage(string $diceNotation): int
    {
        // e.g. "1d6", "2d6", "1d8"
        if (!preg_match('/^(\d+)d(\d+)$/', strtolower($diceNotation), $matches)) {
            return 1;
        }

        $count = (int) $matches[1];
        $sides = (int) $matches[2];
        $total = 0;

        for ($i = 0; $i < $count; $i++) {
            $total += random_int(1, $sides);
        }

        return max(1, $total);
    }

    /**
     * Perform a skill or action check.
     *
     * @return array Breakdown of the roll for the UI and logging.
     */
    public function check(int $dc, int $statModifier, int $skillBonus = 0, bool $advantage = false, bool $disadvantage = false): array
    {
        $die = $this->rollD20($advantage, $disadvantage);

        $isCritSuccess = ($die === 20);
        $isCritFail = ($die === 1);

        $total = $die + $statModifier + $skillBonus;

        $success = false;
        if ($isCritSuccess) {
            $success = true;
        } elseif ($isCritFail) {
            $success = false;
        } else {
            $success = $total >= $dc;
        }

        return [
            'die' => $die,
            'stat_modifier' => $statModifier,
            'skill_bonus' => $skillBonus,
            'total' => $total,
            'dc' => $dc,
            'success' => $success,
            'crit_success' => $isCritSuccess,
            'crit_fail' => $isCritFail,
        ];
    }
}
