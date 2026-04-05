<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        // Get all teachers
        $teachers = Staff::where('role', 'teacher')->get();

        // Define subjects by class
        $subjects = [
            'Form 1' => [
                ['name' => 'English Language', 'code' => 'ENG101'],
                ['name' => 'Mathematics', 'code' => 'MAT101'],
                ['name' => 'Integrated Science', 'code' => 'SCI101'],
                ['name' => 'Social Studies', 'code' => 'SOC101'],
                ['name' => 'Kiswahili', 'code' => 'KIS101'],
                ['name' => 'Business Studies', 'code' => 'BUS101'],
            ],
            'Form 2' => [
                ['name' => 'English Language', 'code' => 'ENG201'],
                ['name' => 'Mathematics', 'code' => 'MAT201'],
                ['name' => 'Biology', 'code' => 'BIO201'],
                ['name' => 'Chemistry', 'code' => 'CHE201'],
                ['name' => 'Physics', 'code' => 'PHY201'],
                ['name' => 'History & Government', 'code' => 'HIS201'],
            ],
            'Form 3' => [
                ['name' => 'English Language', 'code' => 'ENG301'],
                ['name' => 'Mathematics', 'code' => 'MAT301'],
                ['name' => 'Biology', 'code' => 'BIO301'],
                ['name' => 'Chemistry', 'code' => 'CHE301'],
                ['name' => 'Physics', 'code' => 'PHY301'],
                ['name' => 'Literature in English', 'code' => 'LIT301'],
            ],
            'Form 4' => [
                ['name' => 'English Language', 'code' => 'ENG401'],
                ['name' => 'Mathematics', 'code' => 'MAT401'],
                ['name' => 'Biology', 'code' => 'BIO401'],
                ['name' => 'Chemistry', 'code' => 'CHE401'],
                ['name' => 'Physics', 'code' => 'PHY401'],
                ['name' => 'Computer Studies', 'code' => 'CMP401'],
            ],
        ];

        $teacherIndex = 0;
        $totalTeachers = $teachers->count();

        foreach ($subjects as $class => $classSubjects) {
            foreach ($classSubjects as $subject) {
                // Cycle through teachers to assign each subject
                $teacher = $teachers->get($teacherIndex % $totalTeachers);
                $teacherIndex++;

                Subject::create([
                    'name' => $subject['name'],
                    'code' => $subject['code'],
                    'class' => $class,
                    'total_marks' => 100,
                    'pass_marks' => 40,
                    'teacher_id' => $teacher->id,
                    'status' => 'active',
                ]);
            }
        }
    }
}
