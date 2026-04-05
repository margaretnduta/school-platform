<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create classes first (required for students)
        $this->call([
            ClassSeeder::class,
            StudentSeeder::class,
            StaffSeeder::class,
            AttendanceSeeder::class,
            ExamSeeder::class,
            ExamResultSeeder::class,
            DormitorySeeder::class,
            SubjectSeeder::class,
            EventSeeder::class,
        ]);
    }
}
