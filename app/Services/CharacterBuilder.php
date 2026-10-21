<?php

namespace App\Services;

use InvalidArgumentException;

class CharacterBuilder
{
    protected function getConfig(): array
    {
        try {
            return config('game.point_buy') ?? [
                'min_stat' => 8,
                'max_stat' => 15,
                'total_points' => 27,
                'costs' => [
                    8 => 0, 9 => 1, 10 => 2, 11 => 3, 12 => 4, 13 => 5, 14 => 7, 15 => 9,
                ],
            ];
        } catch (\Throwable $e) {
            return [
                'min_stat' => 8,
                'max_stat' => 15,
                'total_points' => 27,
                'costs' => [
                    8 => 0, 9 => 1, 10 => 2, 11 => 3, 12 => 4, 13 => 5, 14 => 7, 15 => 9,
                ],
            ];
        }
    }

    /**
     * Validate point buy allocation and calculate total point cost.
     */
    public function calculatePointCost(array $stats): int
    {
        $config = $this->getConfig();
        $min = $config['min_stat'] ?? 8;
        $max = $config['max_stat'] ?? 15;
        $costs = $config['costs'] ?? [8 => 0, 9 => 1, 10 => 2, 11 => 3, 12 => 4, 13 => 5, 14 => 7, 15 => 9];

        $totalCost = 0;

        foreach (['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'] as $stat) {
            $value = $stats[$stat] ?? $min;

            if ($value < $min || $value > $max) {
                throw new InvalidArgumentException("Stat {$stat} must be between {$min} and {$max}.");
            }

            $totalCost += $costs[$value] ?? 0;
        }

        return $totalCost;
    }

    /**
     * Validate whether given stats meet point buy budget (27 points).
     */
    public function validatePointBuy(array $stats): bool
    {
        $config = $this->getConfig();
        $cost = $this->calculatePointCost($stats);

        return $cost === ($config['total_points'] ?? 27);
    }
}
