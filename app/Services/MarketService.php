<?php

namespace App\Services;

use App\Models\Character;
use App\Models\MarketListing;
use App\Models\TradeLog;
use Illuminate\Support\Facades\DB;
use Exception;

class MarketService
{
    public function __construct(protected InventoryService $inventoryService) {}

    /**
     * Buy an item from the market atomically.
     */
    public function buy(Character $buyer, MarketListing $listing, int $quantity = 1): bool
    {
        return DB::transaction(function () use ($buyer, $listing, $quantity) {
            // Lock listing and inventory for update
            $listing = MarketListing::where('id', $listing->id)->lockForUpdate()->first();

            if (!$listing || !$listing->is_active || $listing->quantity < $quantity) {
                throw new Exception('Listing is no longer available or insufficient quantity.');
            }

            if ($buyer->id === $listing->character_id) {
                throw new Exception('Cannot buy your own listing.');
            }

            $totalCost = $listing->price * $quantity;

            // Atomic conditional update for buyer gold protection
            $updatedRows = Character::where('id', $buyer->id)
                ->where('gold', '>=', $totalCost)
                ->update(['gold' => DB::raw('gold - ' . $totalCost)]);

            if ($updatedRows === 0) {
                throw new Exception('Insufficient gold.');
            }

            // 5% sales tax (destroyed as a money sink per decision #2)
            $taxPaid = (int) round($totalCost * 0.05);
            $sellerRevenue = $totalCost - $taxPaid;

            // Pay seller
            $seller = Character::where('id', $listing->character_id)->first();
            if ($seller) {
                $seller->gold += $sellerRevenue;
                $seller->save();
            }

            // Transfer item to buyer
            $sellerInventory = $listing->inventory;
            $this->inventoryService->addItem($buyer, $sellerInventory->item, $quantity, $sellerInventory->rarity);

            // Update or close listing quantity
            $listing->quantity -= $quantity;
            if ($listing->quantity === 0) {
                $listing->is_active = false;
                $sellerInventory->delete(); // remove source inventory entry if fully sold
            } else {
                $sellerInventory->decrement('quantity', $quantity);
            }
            $listing->save();

            // Log trade
            TradeLog::create([
                'seller_id' => $listing->character_id,
                'buyer_id' => $buyer->id,
                'item_id' => $sellerInventory->item_id,
                'quantity' => $quantity,
                'total_price' => $totalCost,
                'tax_paid' => $taxPaid,
            ]);

            return true;
        });
    }
}
