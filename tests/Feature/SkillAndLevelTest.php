<?php

use App\Models\Character;
use App\Services\SkillService;

test('skill service handles skill experience and level ups', function () {
    $character = Character::factory()->create(['race' => 'human']);
    $service = app(SkillService::class);

    // Level 1 skill requires 100 XP. Human gets 1.05x multiplier.
    $skill = $service->addSkillXp($character, 'herbalism', 105); // 105 * 1.05 = ~110 XP -> levels up to 2, 10 XP remainder

    expect($skill->level)->toBe(2);
    expect($skill->experience)->toBe(10);
});

test('character level up refills bars and increments level', function () {
    $character = Character::factory()->create(['level' => 1, 'experience' => 50]);
    $service = app(SkillService::class);

    // Level 1 requires 100 XP
    $result = $service->addCharacterXp($character, 100);

    expect($result['leveled_up'])->toBeTrue();
    expect($result['character']->level)->toBe(2);
    expect($result['character']->stamina)->toBe(110); // 100 + 2*5
});
