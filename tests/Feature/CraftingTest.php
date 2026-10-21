<?php

use App\Models\Character;
use App\Models\Item;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Services\CraftingService;
use App\Services\InventoryService;

test('character can craft an item when ingredients and focus are available', function () {
    $character = Character::factory()->create([
        'focus' => 50,
        'intelligence' => 14, // mod +2
    ]);

    $ore = Item::create(['name' => 'Iron Ore', 'type' => 'material', 'weight' => 1]);
    $sword = Item::create(['name' => 'Iron Longsword', 'type' => 'weapon', 'base_value' => 50, 'max_durability' => 50]);

    $recipe = Recipe::create([
        'name' => 'Forge Iron Longsword',
        'result_item_id' => $sword->id,
        'focus_cost' => 10,
        'difficulty_class' => 8, // Easy DC so test reliably passes
        'skill_required' => 'blacksmithing',
    ]);

    RecipeIngredient::create([
        'recipe_id' => $recipe->id,
        'item_id' => $ore->id,
        'quantity' => 2,
    ]);

    $inventoryService = app(InventoryService::class);
    $inventoryService->addItem($character, $ore, 2);

    $craftingService = app(CraftingService::class);
    $result = $craftingService->craft($character, $recipe);

    expect($result['success'])->toBeTrue();
    expect($character->fresh()->focus)->toBe(40); // 50 - 10 focus cost

    // Check item added to inventory
    $hasSword = $character->inventories()->where('item_id', $sword->id)->exists();
    expect($hasSword)->toBeTrue();
});
