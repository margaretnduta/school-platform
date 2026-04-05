<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            ['name' => 'Form 1A', 'level' => 'Form 1', 'stream' => 'A', 'capacity' => 50],
            ['name' => 'Form 1B', 'level' => 'Form 1', 'stream' => 'B', 'capacity' => 50],
            ['name' => 'Form 2A', 'level' => 'Form 2', 'stream' => 'A', 'capacity' => 50],
            ['name' => 'Form 2B', 'level' => 'Form 2', 'stream' => 'B', 'capacity' => 50],
            ['name' => 'Form 3A', 'level' => 'Form 3', 'stream' => 'A', 'capacity' => 45],
            ['name' => 'Form 3B', 'level' => 'Form 3', 'stream' => 'B', 'capacity' => 45],
            ['name' => 'Form 4A', 'level' => 'Form 4', 'stream' => 'A', 'capacity' => 40],
            ['name' => 'Form 4B', 'level' => 'Form 4', 'stream' => 'B', 'capacity' => 40],
        ];

        foreach ($classes as $classData) {
            SchoolClass::create([
                'name' => $classData['name'],
                'level' => $classData['level'],
                'stream' => $classData['stream'],
                'capacity' => $classData['capacity'],
                'room_number' => rand(101, 108),
                'status' => 'active',
            ]);
        }
    }
}
