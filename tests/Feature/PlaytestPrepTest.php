<?php

use App\Models\Character;
use App\Models\Item;
use App\Models\Recipe;
use App\Services\OnboardingService;

test('game seeder seeds starting items and crafting recipes', function () {
    $this->seed(\Database\Seeders\GameSeeder::class);

    expect(Item::count())->toBeGreaterThanOrEqual(20);
    expect(Recipe::count())->toBeGreaterThanOrEqual(6);
});

test('onboarding service initializes starter kit and quest', function () {
    $character = Character::factory()->create(['gold' => 0]);
    $onboarding = new OnboardingService();

    $onboarding->initializeOnboarding($character);

    expect($character->fresh()->gold)->toBe(100);
    expect($character->quests()->count())->toBe(1);
    expect($character->quests()->first()->name)->toContain('First Gathering');
});
