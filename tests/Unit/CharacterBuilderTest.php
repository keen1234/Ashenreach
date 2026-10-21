<?php

use App\Services\CharacterBuilder;
use App\Models\Character;

test('valid point buy totals 27 points', function () {
    $builder = new CharacterBuilder();

    // Default 8 for all six stats costs 0 points
    $stats = [
        'strength' => 8,
        'dexterity' => 8,
        'constitution' => 8,
        'intelligence' => 8,
        'wisdom' => 8,
        'charisma' => 8,
    ];
    expect($builder->calculatePointCost($stats))->toBe(0);
    expect($builder->validatePointBuy($stats))->toBeFalse();

    // Allocate 27 points: e.g. three 15s (9*3 = 27) and three 8s (0)
    $validStats = [
        'strength' => 15,
        'dexterity' => 15,
        'constitution' => 15,
        'intelligence' => 8,
        'wisdom' => 8,
        'charisma' => 8,
    ];

    expect($builder->calculatePointCost($validStats))->toBe(27);
    expect($builder->validatePointBuy($validStats))->toBeTrue();
});

test('stat modifier calculations are correct', function () {
    $character = new Character([
        'race' => 'human',
        'strength' => 10, // +1 racial = 11 -> mod 0
        'dexterity' => 14, // +1 racial = 15 -> mod +2
        'constitution' => 8, // +1 racial = 9 -> mod -1
        'intelligence' => 12, // +1 racial = 13 -> mod +1
        'wisdom' => 15, // +1 racial = 16 (capped or uncapped base before cap) -> base 15+1=16 -> mod +3
        'charisma' => 10,
    ]);

    expect($character->getFinalStat('strength'))->toBe(11);
    expect($character->getModifier('strength'))->toBe(0);

    expect($character->getFinalStat('dexterity'))->toBe(15);
    expect($character->getModifier('dexterity'))->toBe(2);

    expect($character->getFinalStat('constitution'))->toBe(9);
    expect($character->getModifier('constitution'))->toBe(-1);

    expect($character->getFinalStat('wisdom'))->toBe(16);
    expect($character->getModifier('wisdom'))->toBe(3);
});
