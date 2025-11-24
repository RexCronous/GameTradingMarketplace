<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles are now using enum in User model
        // No need to seed a separate roles table
    }
}

