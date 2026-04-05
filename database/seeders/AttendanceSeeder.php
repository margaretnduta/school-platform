<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        $classes = ['Form 1A', 'Form 1B', 'Form 2A', 'Form 2B', 'Form 3A', 'Form 3B', 'Form 4A', 'Form 4B'];
        $statuses = ['present', 'absent', 'late', 'excused'];

        // Generate attendance for the entire term (80 school days in March)
        $startDate = Carbon::parse('2026-03-01');
        $endDate = Carbon::parse('2026-03-27'); // Exam starts March 28

        foreach ($students as $student) {
            $attendanceCount = 0;
            $totalDays = 0;

            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                $totalDays++;
                
                // 85% of students have 85%+ attendance (eligible)
                // 15% of students have <80% attendance (ineligible)
                $random = rand(1, 100);
                
                if ($random <= 85) {
                    // Eligible students - 85-95% attendance
                    $eligibleRandom = rand(1, 100);
                    if ($eligibleRandom <= 90) {
                        $status = 'present';
                        $attendanceCount++;
                    } else {
                        $status = $eligibleRandom <= 95 ? 'late' : 'excused';
                        $attendanceCount++;
                    }
                } else {
                    // Ineligible students - 60-75% attendance
                    $ineligibleRandom = rand(1, 100);
                    if ($ineligibleRandom <= 70) {
                        $status = 'present';
                        $attendanceCount++;
                    } else {
                        $status = $ineligibleRandom <= 85 ? 'absent' : 'late';
                    }
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'class' => $student->class,
                    'date' => $date->toDateString(),
                    'status' => $status,
                    'remarks' => null,
                    'recorded_by' => null,
                ]);
            }
        }
    }
}
