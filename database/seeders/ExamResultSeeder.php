<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExamResultSeeder extends Seeder
{
    public function run()
    {
        $subjects = ['Mathematics', 'English', 'Science', 'History', 'Geography', 'Biology', 'Chemistry', 'Physics', 'Computer Studies', 'Business Studies'];
        
        // Get all exams for Term 1 (completed exams)
        $exams = Exam::where('term', 1)->get();

        foreach ($exams as $exam) {
            // Get students in this exam's level and stream
            $students = Student::where('class', 'like', $exam->level . $exam->stream)->get();

            foreach ($students as $student) {
                // Check attendance percentage
                $attendanceRecords = Attendance::where('student_id', $student->id)
                    ->whereNotIn('status', ['absent'])
                    ->count();
                    
                $totalAttendanceRecords = Attendance::where('student_id', $student->id)->count();
                
                $attendancePercentage = $totalAttendanceRecords > 0 
                    ? ($attendanceRecords / $totalAttendanceRecords) * 100 
                    : 0;

                // Only eligible students (80%+ attendance) get exam results
                if ($attendancePercentage >= 80) {
                    // Generate results for 6-8 subjects
                    $examSubjects = array_slice($subjects, 0, rand(6, 8));
                    
                    foreach ($examSubjects as $subject) {
                        $marksObtained = rand(25, 100);
                        $percentage = ($marksObtained / 100) * 100;
                        $grade = $this->calculateGrade($percentage);

                        ExamResult::create([
                            'student_id' => $student->id,
                            'exam_id' => $exam->id,
                            'subject' => $subject,
                            'marks_obtained' => $marksObtained,
                            'total_marks' => 100,
                            'percentage' => $percentage,
                            'grade' => $grade,
                            'comments' => $this->generateComments($grade),
                        ]);
                    }
                }
            }
        }
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        if ($percentage >= 40) return 'E';
        return 'F';
    }

    private function generateComments($grade)
    {
        $comments = [
            'A' => 'Excellent performance',
            'B' => 'Good performance',
            'C' => 'Satisfactory performance',
            'D' => 'Needs improvement',
            'E' => 'Require remedial attention',
            'F' => 'Poor performance',
        ];

        return $comments[$grade] ?? 'Average performance';
    }
}
