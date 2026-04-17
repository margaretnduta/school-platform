<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\AcademicRecord;
use App\Models\DormitoryBed;
use App\Models\MealRecord;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private function getStaff()
    {
        return Staff::where('email', auth()->user()->email)->first();
    }

    public function dashboard()
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return view('teacher.no-profile');
        }

        $myClasses = SchoolClass::where('class_teacher_id', $staff->id)
                                ->where('status', 'active')
                                ->get();

        $mySubjects = Subject::where('teacher_id', $staff->id)
                             ->where('status', 'active')
                             ->get();

        $totalStudents = 0;
        foreach ($myClasses as $class) {
            $totalStudents += Student::where('class', $class->name)
                                     ->where('status', 'active')
                                     ->count();
        }

        $todayAttendance = Attendance::where('recorded_by', auth()->id())
                                     ->whereDate('date', today())
                                     ->count();

        return view('teacher.dashboard', compact(
            'staff', 'myClasses', 'mySubjects', 'totalStudents', 'todayAttendance'
        ));
    }

    public function myStudents(Request $request)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return redirect()->route('teacher.dashboard');
        }

        $myClasses = SchoolClass::where('class_teacher_id', $staff->id)
                                ->where('status', 'active')
                                ->get();

        $selectedClass = $request->class ?? $myClasses->first()?->name;

        $students = collect();
        if ($selectedClass) {
            $students = Student::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();
        }

        return view('teacher.students', compact(
            'myClasses', 'students', 'selectedClass', 'staff'
        ));
    }

    public function studentProfile($studentId)
    {
        $staff   = $this->getStaff();
        $student = Student::findOrFail($studentId);

        // Attendance stats
        $attendanceRecords = Attendance::where('student_id', $studentId)
                                       ->orderBy('date', 'desc')
                                       ->get();
        $totalDays    = $attendanceRecords->count();
        $presentDays  = $attendanceRecords->where('status', 'present')->count();
        $absentDays   = $attendanceRecords->where('status', 'absent')->count();
        $lateDays     = $attendanceRecords->where('status', 'late')->count();
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

        // Academic records — current year
        $academicRecords = AcademicRecord::where('student_id', $studentId)
                                         ->where('year', date('Y'))
                                         ->with('subject')
                                         ->get();

        // Meal stats — last 30 days
        $mealRecords  = MealRecord::where('student_id', $studentId)
                                  ->with('meal')
                                  ->whereHas('meal', fn($q) => $q->whereBetween('date', [
                                      now()->subDays(30)->format('Y-m-d'),
                                      now()->format('Y-m-d')
                                  ]))
                                  ->get();
        $totalMeals   = $mealRecords->count();
        $takenMeals   = $mealRecords->where('status', 'taken')->count();
        $mealRate     = $totalMeals > 0 ? round(($takenMeals / $totalMeals) * 100) : 0;

        // Bed assignment
        $bed = DormitoryBed::where('student_id', $studentId)
                           ->with('room', 'dormitory')
                           ->first();

        // Exam eligibility — check attendance rate
        $examEligible   = $attendanceRate >= 75;
        $eligibilityMsg = $examEligible
            ? 'Eligible — Attendance above 75%'
            : 'Not Eligible — Attendance below 75%';

        return view('teacher.student-profile', compact(
            'student', 'staff',
            'attendanceRecords', 'totalDays', 'presentDays',
            'absentDays', 'lateDays', 'attendanceRate',
            'academicRecords',
            'mealRecords', 'totalMeals', 'takenMeals', 'mealRate',
            'bed', 'examEligible', 'eligibilityMsg'
        ));
    }

    public function attendance(Request $request)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return redirect()->route('teacher.dashboard');
        }

        $myClasses = SchoolClass::where('class_teacher_id', $staff->id)
                                ->where('status', 'active')
                                ->get();

        $selectedClass = $request->class ?? $myClasses->first()?->name;
        $selectedDate  = $request->date  ?? date('Y-m-d');
        $students      = collect();
        $existing      = collect();

        if ($selectedClass) {
            $students = Student::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();

            $existing = Attendance::where('class', $selectedClass)
                                  ->where('date', $selectedDate)
                                  ->pluck('status', 'student_id');
        }

        return view('teacher.attendance', compact(
            'myClasses', 'students', 'existing',
            'selectedClass', 'selectedDate', 'staff'
        ));
    }

    public function saveAttendance(Request $request)
    {
        $request->validate([
            'class'      => 'required|string',
            'date'       => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date'       => $request->date,
                ],
                [
                    'class'       => $request->class,
                    'status'      => $status,
                    'remarks'     => $request->remarks[$studentId] ?? null,
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('teacher.attendance', [
            'class' => $request->class,
            'date'  => $request->date,
        ])->with('success', 'Attendance saved for ' . $request->class . ' on ' . $request->date);
    }

   public function marks(Request $request)
{
    $staff = $this->getStaff();

    if (!$staff) {
        return redirect()->route('teacher.dashboard');
    }

    $mySubjects = Subject::where('teacher_id', $staff->id)
                         ->where('status', 'active')
                         ->get();

    $myClasses       = $mySubjects->pluck('class')->unique()->values();
    $selectedClass   = $request->class;
    $selectedTerm    = $request->term;
    $selectedYear    = $request->year ?? date('Y');
    $selectedSubject = $request->subject_id;
    $students        = collect();
    $subject         = null;

    if ($selectedClass && $selectedSubject) {
        $subject = Subject::find($selectedSubject);

        // Extract the level from the subject class
        // e.g. "Form 1" matches "Form 1A", "Form 1B"
        $subjectLevel = $subject ? $subject->class : $selectedClass;

        $students = Student::where('status', 'active')
                           ->where(function($query) use ($selectedClass, $subjectLevel) {
                               // Try exact match first
                               $query->where('class', $selectedClass)
                                     // Also match by level prefix e.g. "Form 1"
                                     ->orWhere('class', 'LIKE', $subjectLevel . '%');
                           })
                           ->get();
    }

    return view('teacher.marks', compact(
        'mySubjects', 'myClasses', 'students', 'subject',
        'selectedClass', 'selectedTerm', 'selectedYear',
        'selectedSubject', 'staff'
    ));
}
    public function saveMarks(Request $request)
    {
        $request->validate([
            'class'      => 'required|string',
            'term'       => 'required|in:term_1,term_2,term_3',
            'year'       => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'marks'      => 'required|array',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        foreach ($request->marks as $studentId => $marks) {
            if ($marks === null || $marks === '') continue;

            $grading = AcademicRecord::calculateGrade($marks, $subject->total_marks);

            AcademicRecord::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'term'       => $request->term,
                    'year'       => $request->year,
                ],
                [
                    'class'       => $request->class,
                    'marks'       => $marks,
                    'total_marks' => $subject->total_marks,
                    'grade'       => $grading['grade'],
                    'points'      => $grading['points'],
                    'status'      => $grading['status'],
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('teacher.marks', [
            'class'      => $request->class,
            'term'       => $request->term,
            'year'       => $request->year,
            'subject_id' => $request->subject_id,
        ])->with('success', 'Marks saved successfully!');
    }
}