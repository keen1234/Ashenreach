<?php

use App\Models\Character;
use App\Models\Item;
use App\Models\MarketListing;
use App\Models\TradeLog;
use App\Services\InventoryService;
use App\Services\MarketService;

test('player can buy market item atomically with 5% tax sink', function () {
    $seller = Character::factory()->create(['gold' => 100]);
    $buyer = Character::factory()->create(['gold' => 500]);

    $item = Item::create([
        'name' => 'Steel Sword',
        'type' => 'weapon',
        'base_value' => 100,
    ]);

    $inventoryService = app(InventoryService::class);
    $sellerInv = $inventoryService->addItem($seller, $item, 1);

    $listing = MarketListing::create([
        'character_id' => $seller->id,
        'inventory_id' => $sellerInv->id,
        'price' => 200,
        'quantity' => 1,
        'is_active' => true,
    ]);

    $marketService = app(MarketService::class);
    $success = $marketService->buy($buyer, $listing, 1);

    expect($success)->toBeTrue();

    // Buyer paid 200 gold: 500 - 200 = 300
    expect($buyer->fresh()->gold)->toBe(300);

    // Seller received 200 - 5% tax (10) = 190 gold: 100 + 190 = 290
    expect($seller->fresh()->gold)->toBe(290);

    // Trade logged
    expect(TradeLog::count())->toBe(1);
    $log = TradeLog::first();
    expect($log->tax_paid)->toBe(10);
});
