<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
        'price',
        'status',
        'category',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getImageUrl(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('storage/images/placeholder.png');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isSold(): bool
    {
        return $this->status === 'sold';
    }

    public function isTraded(): bool
    {
        return $this->status === 'traded';
    }

    public function canBeTraded(): bool
    {
        return $this->status === 'available';
    }

    public function markAsSold(): bool
    {
        return $this->update(['status' => 'sold']);
    }

    public function markAsTraded(): bool
    {
        return $this->update(['status' => 'traded']);
    }

    public function markAsAvailable(): bool
    {
        return $this->update(['status' => 'available']);
    }
}