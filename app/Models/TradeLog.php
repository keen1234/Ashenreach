<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'item_id',
        'quantity',
        'total_price',
        'tax_paid',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'seller_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'buyer_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
