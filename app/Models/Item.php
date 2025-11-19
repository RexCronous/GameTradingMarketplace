<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'image_path', 'price', 'status'];
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}