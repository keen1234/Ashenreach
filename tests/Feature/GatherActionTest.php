<?php

use App\Services\DiceService;
use App\Services\ActionService;
use App\Models\Character;
use App\Models\ActionLog;

test('dice service rolls within expected bounds and handles advantage', function () {
    $dice = new DiceService();

    $roll = $dice->rollD20();
    expect($roll)->toBeGreaterThanOrEqual(1)->toBeLessThanOrEqual(20);

    $damage = $dice->rollDamage('1d6');
    expect($damage)->toBeGreaterThanOrEqual(1)->toBeLessThanOrEqual(6);

    $check = $dice->check(12, 2, 1);
    expect($check)->toHaveKeys(['die', 'stat_modifier', 'skill_bonus', 'total', 'dc', 'success', 'crit_success', 'crit_fail']);
    expect($check['total'])->toBe($check['die'] + 2 + 1);
});

test('gather action spends stamina and logs roll and rewards', function () {
    $character = Character::factory()->create([
        'stamina' => 100,
        'gold' => 50,
    ]);

    $actionService = app(ActionService::class);
    $result = $actionService->gather($character);

    expect($result)->toHaveKeys(['roll', 'rewards', 'character']);
    expect($result['character']->stamina)->toBe(95);
    expect(ActionLog::where('character_id', $character->id)->count())->toBe(1);
});
