<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Starter & Crafting Items (approx 20 items)
        $items = [
            // Materials
            ['name' => 'Iron Ore', 'type' => 'material', 'rarity' => 'common', 'base_value' => 5, 'weight' => 2],
            ['name' => 'Copper Ore', 'type' => 'material', 'rarity' => 'common', 'base_value' => 3, 'weight' => 2],
            ['name' => 'Oak Wood', 'type' => 'material', 'rarity' => 'common', 'base_value' => 2, 'weight' => 1],
            ['name' => 'Iron Ingot', 'type' => 'material', 'rarity' => 'common', 'base_value' => 15, 'weight' => 3],
            ['name' => 'Silver Bar', 'type' => 'material', 'rarity' => 'uncommon', 'base_value' => 45, 'weight' => 3],
            ['name' => 'Wild Herb', 'type' => 'material', 'rarity' => 'common', 'base_value' => 2, 'weight' => 1],
            ['name' => 'Ginseng', 'type' => 'material', 'rarity' => 'uncommon', 'base_value' => 12, 'weight' => 1],
            ['name' => 'Leather Scraps', 'type' => 'material', 'rarity' => 'common', 'base_value' => 4, 'weight' => 1],
            ['name' => 'Dragon Scale', 'type' => 'material', 'rarity' => 'legendary', 'base_value' => 1000, 'weight' => 5],
            ['name' => 'Magic Essence', 'type' => 'material', 'rarity' => 'rare', 'base_value' => 100, 'weight' => 1],

            // Weapons
            ['name' => 'Iron Dagger', 'type' => 'weapon', 'rarity' => 'common', 'base_value' => 25, 'max_durability' => 40, 'weight' => 2],
            ['name' => 'Shortbow', 'type' => 'weapon', 'rarity' => 'common', 'base_value' => 30, 'max_durability' => 45, 'weight' => 3],
            ['name' => 'Iron Longsword', 'type' => 'weapon', 'rarity' => 'common', 'base_value' => 60, 'max_durability' => 60, 'weight' => 4],
            ['name' => 'Greataxe', 'type' => 'weapon', 'rarity' => 'uncommon', 'base_value' => 120, 'max_durability' => 70, 'weight' => 8],
            ['name' => 'Staff of Fire', 'type' => 'weapon', 'rarity' => 'rare', 'base_value' => 250, 'max_durability' => 50, 'weight' => 4],

            // Armor & Gear
            ['name' => 'Leather Tunic', 'type' => 'armor', 'rarity' => 'common', 'base_value' => 35, 'max_durability' => 50, 'weight' => 5],
            ['name' => 'Chainmail Hauberk', 'type' => 'armor', 'rarity' => 'uncommon', 'base_value' => 140, 'max_durability' => 80, 'weight' => 15],
            ['name' => 'Steel Shield', 'type' => 'armor', 'rarity' => 'common', 'base_value' => 50, 'max_durability' => 60, 'weight' => 6],

            // Potions
            ['name' => 'Minor Health Potion', 'type' => 'potion', 'rarity' => 'common', 'base_value' => 20, 'weight' => 1],
            ['name' => 'Stamina Elixir', 'type' => 'potion', 'rarity' => 'uncommon', 'base_value' => 50, 'weight' => 1],
        ];

        $createdItems = [];
        foreach ($items as $itemData) {
            $createdItems[$itemData['name']] = Item::firstOrCreate(['name' => $itemData['name']], $itemData);
        }

        // 2. Crafting Recipes (6 recipes)
        $recipes = [
            [
                'name' => 'Smelt Iron Ingot',
                'result' => 'Iron Ingot',
                'focus_cost' => 5,
                'dc' => 8,
                'skill' => 'blacksmithing',
                'ingredients' => ['Iron Ore' => 2],
            ],
            [
                'name' => 'Forge Iron Dagger',
                'result' => 'Iron Dagger',
                'focus_cost' => 10,
                'dc' => 10,
                'skill' => 'blacksmithing',
                'ingredients' => ['Iron Ingot' => 2, 'Oak Wood' => 1],
            ],
            [
                'name' => 'Forge Iron Longsword',
                'result' => 'Iron Longsword',
                'focus_cost' => 15,
                'dc' => 12,
                'skill' => 'blacksmithing',
                'ingredients' => ['Iron Ingot' => 4, 'Leather Scraps' => 1],
            ],
            [
                'name' => 'Craft Leather Tunic',
                'result' => 'Leather Tunic',
                'focus_cost' => 10,
                'dc' => 10,
                'skill' => 'blacksmithing',
                'ingredients' => ['Leather Scraps' => 5],
            ],
            [
                'name' => 'Brew Minor Health Potion',
                'result' => 'Minor Health Potion',
                'focus_cost' => 8,
                'dc' => 10,
                'skill' => 'alchemy',
                'ingredients' => ['Wild Herb' => 2],
            ],
            [
                'name' => 'Brew Stamina Elixir',
                'result' => 'Stamina Elixir',
                'focus_cost' => 15,
                'dc' => 14,
                'skill' => 'alchemy',
                'ingredients' => ['Ginseng' => 2, 'Magic Essence' => 1],
            ],
        ];

        foreach ($recipes as $recipeData) {
            $resultItem = $createdItems[$recipeData['result']] ?? null;
            if (!$resultItem) continue;

            $recipe = Recipe::firstOrCreate(
                ['name' => $recipeData['name']],
                [
                    'result_item_id' => $resultItem->id,
                    'focus_cost' => $recipeData['focus_cost'],
                    'difficulty_class' => $recipeData['dc'],
                    'skill_required' => $recipeData['skill'],
                ]
            );

            // Add ingredients
            foreach ($recipeData['ingredients'] as $ingName => $qty) {
                $ingItem = $createdItems[$ingName] ?? null;
                if ($ingItem) {
                    RecipeIngredient::firstOrCreate([
                        'recipe_id' => $recipe->id,
                        'item_id' => $ingItem->id,
                    ], [
                        'quantity' => $qty,
                    ]);
                }
            }
        }
    }
}
