<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
        ]);

        Profile::firstOrCreate([
            'user_id' => $admin->id,
        ], [
            'username' => 'admin',
        ]);

        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $admin->roles()->syncWithoutDetaching([$role->id]);
    }
}
