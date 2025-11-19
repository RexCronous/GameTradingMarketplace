<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['item_id', 'offerer_id', 'cash_amount', 'offered_item_ids', 'status'];
    protected $casts = ['offered_item_ids' => 'array'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function offerer()
    {
        return $this->belongsTo(User::class, 'offerer_id');
    }
}
