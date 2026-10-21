<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Add an item to character inventory.
     */
    public function addItem(Character $character, Item $item, int $quantity = 1, string $rarity = 'common'): Inventory
    {
        return DB::transaction(function () use ($character, $item, $quantity, $rarity) {
            $inventory = $character->inventories()
                ->where('item_id', $item->id)
                ->where('rarity', $rarity)
                ->first();

            if ($inventory && $item->type !== 'weapon' && $item->type !== 'armor') {
                $inventory->increment('quantity', $quantity);
                return $inventory;
            }

            return Inventory::create([
                'character_id' => $character->id,
                'item_id' => $item->id,
                'quantity' => $quantity,
                'current_durability' => $item->max_durability,
                'rarity' => $rarity,
            ]);
        });
    }

    /**
     * Calculate total current inventory weight.
     */
    public function getTotalWeight(Character $character): int
    {
        return $character->inventories()->join('items', 'inventories.item_id', '=', 'items.id')
            ->sum(DB::raw('inventories.quantity * items.weight'));
    }

    /**
     * Get maximum carry weight (Base 30 + STR modifier * 5).
     */
    public function getMaxWeight(Character $character): int
    {
        return 30 + ($character->getModifier('strength') * 5);
    }
}
