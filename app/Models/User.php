<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function buyerTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    public function sellerTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canEditItem(Item $item): bool
    {
        return $this->id === $item->user_id || $this->isAdmin();
    }

    public function canDeleteItem(Item $item): bool
    {
        return $this->id === $item->user_id || $this->isAdmin();
    }

    public function canBuyItem(Item $item): bool
    {
        return $this->id !== $item->user_id;
    }

    public function getAvatarUrl()
    {
        return $this->profile?->avatar ? asset('storage/' . $this->profile->avatar) : asset('storage/images/default-avatar.png');
    }

    public function getStatistics(): array
    {
        return [
            'total_items' => $this->items()->count(),
            'available_items' => $this->items()->where('status', 'available')->count(),
            'total_sales' => $this->sellerTransactions()->where('status', 'completed')->sum('total_price'),
            'pending_trades' => $this->buyerTransactions()->where('status', 'pending')->count(),
            'completed_trades' => $this->buyerTransactions()->where('status', 'completed')->count(),
        ];
    }
    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
