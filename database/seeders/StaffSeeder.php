<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $subjects = ['Mathematics', 'English', 'Science', 'History', 'Geography', 'Biology', 'Chemistry', 'Physics', 'Computer Studies', 'Business Studies'];

        // Create 30 Teachers
        for ($i = 0; $i < 30; $i++) {
            Staff::create([
                'staff_number' => 'STF-' . str_pad($i + 2001, 4, '0', STR_PAD_LEFT),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'gender' => $faker->randomElement(['male', 'female']),
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),
                'national_id' => $faker->numerify('########'),
                'role' => 'teacher',
                'department' => 'Academic',
                'subject' => $faker->randomElement($subjects),
                'joining_date' => $faker->dateTimeBetween('-15 years', '-1 years')->format('Y-m-d'),
                'employment_type' => $faker->randomElement(['full_time', 'part_time', 'contract']),
                'status' => 'active',
                'address' => $faker->address(),
            ]);
        }

        // Create Additional Staff (Admin, Nurse, Librarian, Counselor)
        $staffRoles = ['admin_staff', 'nurse', 'librarian', 'counselor'];
        foreach ($staffRoles as $role) {
            Staff::create([
                'staff_number' => 'STF-' . str_pad(2031 + array_search($role, $staffRoles), 4, '0', STR_PAD_LEFT),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'gender' => $faker->randomElement(['male', 'female']),
                'date_of_birth' => $faker->dateTimeBetween('-55 years', '-30 years')->format('Y-m-d'),
                'national_id' => $faker->numerify('########'),
                'role' => $role,
                'department' => 'Support',
                'subject' => null,
                'joining_date' => $faker->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),
                'employment_type' => 'full_time',
                'status' => 'active',
                'address' => $faker->address(),
            ]);
        }
    }
}
