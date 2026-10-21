<?php

use App\Services\BarService;
use App\Models\Character;
use Carbon\Carbon;

test('bar service calculates max capacity correctly', function () {
    $barService = new BarService();
    $character = new Character([
        'level' => 1,
        'stamina' => 100,
        'courage' => 20,
        'focus' => 50,
    ]);

    expect($barService->getMaxCapacity($character, 'stamina'))->toBe(105);
    expect($barService->getMaxCapacity($character, 'courage'))->toBe(21);
    expect($barService->getMaxCapacity($character, 'focus'))->toBe(52);
});

test('bar service calculates regeneration over elapsed time', function () {
    $barService = new BarService();

    // Last updated 9 minutes ago (540 seconds / 180 seconds per stamina = +3 stamina)
    // If last value was 50, current value should be 53.
    $now = Carbon::now();
    $character = new Character([
        'level' => 1,
        'stamina' => 50,
        'stamina_updated_at' => $now->copy()->subMinutes(9),
    ]);

    expect($barService->getCurrentValue($character, 'stamina'))->toBe(53);
});

test('bar service consumes stamina correctly', function () {
    $barService = new BarService();

    $character = new Character([
        'level' => 1,
        'stamina' => 100,
        'stamina_updated_at' => Carbon::now(),
    ]);

    $success = $barService->consume($character, 'stamina', 10);
    expect($success)->toBeTrue();
    expect($character->stamina)->toBe(90);

    // Try consuming more than available
    $fail = $barService->consume($character, 'stamina', 200);
    expect($fail)->toBeFalse();
});
