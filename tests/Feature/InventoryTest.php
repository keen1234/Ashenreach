<?php

use App\Models\Character;
use App\Models\Item;
use App\Services\InventoryService;

test('inventory service adds items and respects stacking', function () {
    $character = Character::factory()->create();
    $item = Item::create([
        'name' => 'Healing Potion',
        'type' => 'potion',
        'rarity' => 'common',
        'base_value' => 10,
        'max_durability' => 1,
        'weight' => 1,
    ]);

    $service = app(InventoryService::class);
    $inv1 = $service->addItem($character, $item, 5);
    expect($inv1->quantity)->toBe(5);

    // Adding more should stack
    $inv2 = $service->addItem($character, $item, 3);
    expect($inv2->id)->toBe($inv1->id);
    expect($inv2->fresh()->quantity)->toBe(8);
});

test('inventory service calculates carry weight correctly', function () {
    $character = Character::factory()->create(['strength' => 12]); // mod +1 -> max weight 35
    $item = Item::create([
        'name' => 'Iron Ore',
        'type' => 'material',
        'weight' => 2,
    ]);

    $service = app(InventoryService::class);
    $service->addItem($character, $item, 10); // weight 20

    expect($service->getMaxWeight($character))->toBe(35);
    expect($service->getTotalWeight($character))->toBe(20);
});
