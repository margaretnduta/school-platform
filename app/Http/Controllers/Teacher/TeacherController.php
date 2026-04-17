<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\AcademicRecord;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Get the staff record linked to the logged in user by email
    private function getStaff()
    {
        return Staff::where('email', auth()->user()->email)->first();
    }

    // Dashboard
    public function dashboard()
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return view('teacher.no-profile');
        }

        // Get classes where this teacher is class teacher
        $myClasses = SchoolClass::where('class_teacher_id', $staff->id)
                                ->where('status', 'active')
                                ->get();

        // Get subjects assigned to this teacher
        $mySubjects = Subject::where('teacher_id', $staff->id)
                             ->where('status', 'active')
                             ->get();

        // Total students across all my classes
        $totalStudents = 0;
        foreach ($myClasses as $class) {
            $totalStudents += Student::where('class', $class->name)
                                     ->where('status', 'active')
                                     ->count();
        }

        // Today's attendance already taken
        $todayAttendance = Attendance::where('recorded_by', auth()->id())
                                     ->whereDate('date', today())
                                     ->count();

        return view('teacher.dashboard', compact(
            'staff', 'myClasses', 'mySubjects', 'totalStudents', 'todayAttendance'
        ));
    }

    // View students in teacher's class
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

        $students = $selectedClass
            ? Student::where('class', $selectedClass)
                     ->where('status', 'active')
                     ->get()
            : collect();

        return view('teacher.students', compact('myClasses', 'students', 'selectedClass', 'staff'));
    }

    // Attendance — load form
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

    // Save attendance
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

    // Marks — entry page
    public function marks(Request $request)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return redirect()->route('teacher.dashboard');
        }

        // Subjects this teacher teaches
        $mySubjects    = Subject::where('teacher_id', $staff->id)
                                ->where('status', 'active')
                                ->get();

        $selectedClass   = $request->class;
        $selectedTerm    = $request->term;
        $selectedYear    = $request->year ?? date('Y');
        $selectedSubject = $request->subject_id;
        $students        = collect();
        $subject         = null;

        if ($selectedClass && $selectedTerm && $selectedSubject) {
            $subject  = Subject::findOrFail($selectedSubject);
            $students = Student::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();
        }

        // Unique classes from teacher's subjects
        $myClasses = $mySubjects->pluck('class')->unique()->values();

        return view('teacher.marks', compact(
            'mySubjects', 'myClasses', 'students', 'subject',
            'selectedClass', 'selectedTerm', 'selectedYear',
            'selectedSubject', 'staff'
        ));
    }

    // Save marks
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