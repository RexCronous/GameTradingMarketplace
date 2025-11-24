<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'buyer_id',
        'seller_id',
        'offer_item_id',
        'offer_amount',
        'total_price',
        'type',
        'status',
        'notes',
        'accepted_at',
        'rejected_at',
        'completed_at',
    ];

    protected $casts = [
        'offer_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function offerItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'offer_item_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isBuyType(): bool
    {
        return $this->type === 'buy';
    }

    public function isTradeType(): bool
    {
        return $this->type === 'trade';
    }

    public function canBeAccepted(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeRejected(): bool
    {
        return $this->status === 'pending';
    }

    public function accept(): bool
    {
        return $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);
    }

    public function reject(): bool
    {
        return $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);
    }

    public function complete(): bool
    {
        $result = $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        if ($result) {
            if ($this->isBuyType()) {
                $this->item->markAsSold();
            } elseif ($this->isTradeType()) {
                $this->item->markAsTraded();
                if ($this->offerItem) {
                    $this->offerItem->markAsTraded();
                }
            }
        }

        return $result;
    }

    public function cancel(): bool
    {
        return $this->update(['status' => 'cancelled']);
    }
}