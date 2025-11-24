<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create profile for admin
        Profile::firstOrCreate([
            'user_id' => $admin->id,
        ], [
            'username' => 'admin',
            'bio' => 'System Administrator',
        ]);

        // Create sample users
        $user1 = User::firstOrCreate([
            'email' => 'user1@example.com',
        ], [
            'name' => 'John Trader',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        Profile::firstOrCreate([
            'user_id' => $user1->id,
        ], [
            'username' => 'john_trader',
            'bio' => 'Game item collector and trader',
        ]);

        $user2 = User::firstOrCreate([
            'email' => 'user2@example.com',
        ], [
            'name' => 'Jane Collector',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        Profile::firstOrCreate([
            'user_id' => $user2->id,
        ], [
            'username' => 'jane_collector',
            'bio' => 'Rare item collector',
        ]);
    }
}

