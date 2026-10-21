<?php

namespace App\Services;

use App\Models\Character;
use Carbon\Carbon;

class BarService
{
    public function getCurrentValue(Character $character, string $bar): int
    {
        $max = $this->getMaxCapacity($character, $bar);
        $lastValue = $character->{$bar};
        $lastUpdated = Carbon::parse($character->{$bar . '_updated_at'});

        $regenRate = $this->getRegenRate($bar);
        $elapsed = $lastUpdated->diffInSeconds(Carbon::now(), false);

        if ($elapsed <= 0) {
            return $lastValue;
        }

        $regenAmount = (int) floor($elapsed / $regenRate);

        return min($max, $lastValue + $regenAmount);
    }

    public function getMaxCapacity(Character $character, string $bar): int
    {
        $base = match ($bar) {
            'stamina' => 100,
            'courage' => 20,
            'focus' => 50,
            default => 0,
        };

        $levelBonus = match ($bar) {
            'stamina' => $character->level * 5,
            'courage' => $character->level * 1,
            'focus' => $character->level * 2,
            default => 0,
        };

        return $base + $levelBonus;
    }

    public function getRegenRate(string $bar): int
    {
        return match ($bar) {
            'stamina' => 180, // 3 min
            'courage' => 600, // 10 min
            'focus' => 300,   // 5 min
            default => 60,
        };
    }

    public function consume(Character $character, string $bar, int $amount): bool
    {
        $current = $this->getCurrentValue($character, $bar);

        if ($current < $amount) {
            return false;
        }

        $character->{$bar} = $current - $amount;
        $character->{$bar . '_updated_at'} = Carbon::now();

        if ($character->exists) {
            return $character->save();
        }

        return true;
    }
}
