<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create or update admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@school-platform.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Admin123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role using Spatie
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
