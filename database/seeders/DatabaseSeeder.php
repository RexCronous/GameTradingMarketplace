<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'username' => 'admin',
            'bio' => 'System Administrator',
        ]);

        // Create test user 1
        $user1 = User::create([
            'name' => 'John Trader',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $user1->id,
            'username' => 'john_trader',
            'bio' => 'Passionate item collector',
        ]);

        // Create test user 2
        $user2 = User::create([
            'name' => 'Jane Merchant',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $user2->id,
            'username' => 'jane_merchant',
            'bio' => 'Professional trader',
        ]);

        // Sample items for user 1
        Item::create([
            'user_id' => $user1->id,
            'name' => 'Legendary Sword',
            'description' => 'A powerful sword that glows with blue light. Perfect for combat.',
            'price' => 500,
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user1->id,
            'name' => 'Magic Shield',
            'description' => 'Protective shield with magical properties',
            'price' => 350,
            'status' => 'available',
        ]);

        // Sample items for user 2
        Item::create([
            'user_id' => $user2->id,
            'name' => 'Dragon Helmet',
            'description' => 'Crafted from dragon scales',
            'price' => 600,
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user2->id,
            'name' => 'Phoenix Wings',
            'description' => 'Rare item from slain phoenix',
            'price' => 800,
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user2->id,
            'name' => 'Enchanted Boots',
            'description' => 'Boots that increase movement speed',
            'price' => 250,
            'status' => 'available',
        ]);
    }
}
