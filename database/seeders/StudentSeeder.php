<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $classes = ['Form 1A', 'Form 1B', 'Form 2A', 'Form 2B', 'Form 3A', 'Form 3B', 'Form 4A', 'Form 4B'];
        $dormitories = ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru'];

        for ($i = 0; $i < 200; $i++) {
            Student::create([
                'admission_number' => 'ADM-' . str_pad($i + 1001, 4, '0', STR_PAD_LEFT),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'gender' => $faker->randomElement(['male', 'female']),
                'date_of_birth' => $faker->dateTimeBetween('-20 years', '-15 years')->format('Y-m-d'),
                'guardian_name' => $faker->name(),
                'guardian_phone' => $faker->phoneNumber(),
                'guardian_email' => $faker->safeEmail(),
                'class' => $faker->randomElement($classes),
                'dormitory' => $faker->randomElement($dormitories),
                'status' => 'active',
                'address' => $faker->address(),
            ]);
        }
    }
}
