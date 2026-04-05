<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExamSeeder extends Seeder
{
    public function run()
    {
        $exams = [
            // Term 1 Exams
            ['name' => 'Term 1 - Form 1', 'term' => 1, 'year' => 2026, 'level' => 'Form 1', 'stream' => 'A', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 1', 'term' => 1, 'year' => 2026, 'level' => 'Form 1', 'stream' => 'B', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 2', 'term' => 1, 'year' => 2026, 'level' => 'Form 2', 'stream' => 'A', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 2', 'term' => 1, 'year' => 2026, 'level' => 'Form 2', 'stream' => 'B', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 3', 'term' => 1, 'year' => 2026, 'level' => 'Form 3', 'stream' => 'A', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 3', 'term' => 1, 'year' => 2026, 'level' => 'Form 3', 'stream' => 'B', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 4', 'term' => 1, 'year' => 2026, 'level' => 'Form 4', 'stream' => 'A', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            ['name' => 'Term 1 - Form 4', 'term' => 1, 'year' => 2026, 'level' => 'Form 4', 'stream' => 'B', 'start_date' => '2026-03-15', 'end_date' => '2026-03-27'],
            
            // Term 2 Exams (upcoming)
            ['name' => 'Term 2 - Form 1', 'term' => 2, 'year' => 2026, 'level' => 'Form 1', 'stream' => 'A', 'start_date' => '2026-06-01', 'end_date' => '2026-06-12'],
            ['name' => 'Term 2 - Form 1', 'term' => 2, 'year' => 2026, 'level' => 'Form 1', 'stream' => 'B', 'start_date' => '2026-06-01', 'end_date' => '2026-06-12'],
        ];

        foreach ($exams as $examData) {
            Exam::create([
                'name' => $examData['name'],
                'term' => $examData['term'],
                'year' => $examData['year'],
                'level' => $examData['level'],
                'stream' => $examData['stream'],
                'description' => 'Examination for ' . $examData['level'] . ' Stream ' . $examData['stream'],
                'start_date' => $examData['start_date'],
                'end_date' => $examData['end_date'],
                'status' => 'planned',
            ]);
        }
    }
}
