<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin   = Role::create(['name' => 'admin']);
        $teacher = Role::create(['name' => 'teacher']);
        $parent  = Role::create(['name' => 'parent']);
        $student = Role::create(['name' => 'student']);

        // Create default admin user
        $adminUser = User::create([
            'name'     => 'System Admin',
            'email'    => 'admin@school.com',
            'password' => Hash::make('admin1234'),
            'role'     => 'admin',
        ]);

        // Assign admin role
        $adminUser->assignRole('admin');
    }
}