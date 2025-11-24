<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::where('email', 'user1@example.com')->first();
        $user2 = User::where('email', 'user2@example.com')->first();

        if ($user1) {
            Item::create([
                'user_id' => $user1->id,
                'name' => 'Legendary Sword',
                'description' => 'A powerful sword forged by the ancient smiths. Deals extra damage to undead.',
                'image' => null,
                'price' => 5000.00,
                'status' => 'available',
            ]);

            Item::create([
                'user_id' => $user1->id,
                'name' => 'Enchanted Shield',
                'description' => 'A magical shield that reflects spells. Perfect for mages.',
                'image' => null,
                'price' => 3500.00,
                'status' => 'available',
            ]);
        }

        if ($user2) {
            Item::create([
                'user_id' => $user2->id,
                'name' => 'Dragon Scale Armor',
                'description' => 'Rare armor made from dragon scales. Provides excellent protection.',
                'image' => null,
                'price' => 8000.00,
                'status' => 'available',
            ]);

            Item::create([
                'user_id' => $user2->id,
                'name' => 'Healing Potion Pack',
                'description' => 'Pack of 10 powerful healing potions. Restores 500 HP each.',
                'image' => null,
                'price' => 1000.00,
                'status' => 'available',
            ]);
        }
    }
}
