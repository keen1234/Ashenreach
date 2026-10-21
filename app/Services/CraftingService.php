<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Exception;

class CraftingService
{
    public function __construct(
        protected BarService $barService,
        protected DiceService $diceService,
        protected InventoryService $inventoryService,
        protected SkillService $skillService
    ) {}

    /**
     * Craft an item from a recipe.
     */
    public function craft(Character $character, Recipe $recipe): array
    {
        return DB::transaction(function () use ($character, $recipe) {
            // 1. Verify Focus
            $currentFocus = $this->barService->getCurrentValue($character, 'focus');
            if ($currentFocus < $recipe->focus_cost) {
                throw new Exception('Not enough focus.');
            }

            // 2. Verify ingredients in inventory
            foreach ($recipe->ingredients as $ingredient) {
                $inv = $character->inventories()
                    ->where('item_id', $ingredient->item_id)
                    ->first();

                if (!$inv || $inv->quantity < $ingredient->quantity) {
                    throw new Exception("Missing required ingredients for crafting: {$ingredient->item->name}");
                }
            }

            // 3. Deduct focus
            $this->barService->consume($character, 'focus', $recipe->focus_cost);

            // 4. Deduct ingredients
            foreach ($recipe->ingredients as $ingredient) {
                $inv = $character->inventories()
                    ->where('item_id', $ingredient->item_id)
                    ->first();

                if ($inv->quantity == $ingredient->quantity) {
                    $inv->delete();
                } else {
                    $inv->decrement('quantity', $ingredient->quantity);
                }
            }

            // 5. Roll Dice (Intelligence mod + skill level bonus)
            $statMod = $character->getModifier('intelligence');
            $skill = $character->skills()->where('name', $recipe->skill_required)->first();
            $skillBonus = $skill ? (int) floor($skill->level / 5) : 0;

            $rollResult = $this->diceService->check($recipe->difficulty_class, $statMod, $skillBonus);

            $rarity = 'common';
            $success = $rollResult['success'];

            if ($success) {
                if ($rollResult['crit_success']) {
                    $rarity = 'rare'; // Natural 20 gives higher tier
                } elseif ($rollResult['total'] >= $recipe->difficulty_class + 5) {
                    $rarity = 'uncommon';
                }

                // Add crafted item to inventory
                $this->inventoryService->addItem($character, $recipe->resultItem, 1, $rarity);

                // Gain skill XP
                $this->skillService->addSkillXp($character, $recipe->skill_required, 25);
            }

            return [
                'success' => $success,
                'roll' => $rollResult,
                'rarity' => $rarity,
                'item' => $recipe->resultItem,
            ];
        });
    }
}
