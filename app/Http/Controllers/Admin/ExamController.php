<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::orderBy('start_date', 'desc')->paginate(15);
        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = ['Form 1', 'Form 2', 'Form 3', 'Form 4'];
        $streams = ['A', 'B'];
        return view('admin.exams.create', compact('levels', 'streams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'term' => 'required|integer|between:1,3',
            'year' => 'required|integer',
            'level' => 'required|string',
            'stream' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Exam::create($validated);
        return redirect()->route('admin.exams.index')->with('success', 'Exam created successfully');
    }

    /**
     * Display the specified resource with eligibility analysis.
     */
    public function show(Exam $exam)
    {
        $students = Student::where('class', 'like', $exam->level . $exam->stream)->get();
        
        $eligible = [];
        $ineligible = [];

        foreach ($students as $student) {
            $attendancePercentage = $this->getAttendancePercentage($student->id);
            
            if ($attendancePercentage >= 80) {
                $eligible[] = [
                    'student' => $student,
                    'attendance' => $attendancePercentage,
                ];
            } else {
                $ineligible[] = [
                    'student' => $student,
                    'attendance' => $attendancePercentage,
                ];
            }
        }

        return view('admin.exams.show', compact('exam', 'eligible', 'ineligible'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $levels = ['Form 1', 'Form 2', 'Form 3', 'Form 4'];
        $streams = ['A', 'B'];
        return view('admin.exams.edit', compact('exam', 'levels', 'streams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'term' => 'required|integer|between:1,3',
            'year' => 'required|integer',
            'level' => 'required|string',
            'stream' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:planned,ongoing,completed',
        ]);

        $exam->update($validated);
        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted successfully');
    }

    /**
     * View student statistics and reports
     */
    public function studentReport(Exam $exam, Student $student)
    {
        $results = ExamResult::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->get();

        $attendancePercentage = $this->getAttendancePercentage($student->id);
        $isEligible = $attendancePercentage >= 80;

        // Calculate statistics
        $totalMarks = $results->sum('marks_obtained');
        $averagePercentage = $results->count() > 0 ? $results->avg('percentage') : 0;
        $gradeBreakdown = $results->groupBy('grade')->map->count();

        return view('admin.exams.student-report', compact(
            'exam',
            'student',
            'results',
            'attendancePercentage',
            'isEligible',
            'totalMarks',
            'averagePercentage',
            'gradeBreakdown'
        ));
    }

    /**
     * Get attendance percentage for a student
     */
    private function getAttendancePercentage($studentId)
    {
        $presentCount = Attendance::where('student_id', $studentId)
            ->whereNotIn('status', ['absent'])
            ->count();

        $totalCount = Attendance::where('student_id', $studentId)->count();

        return $totalCount > 0 ? ($presentCount / $totalCount) * 100 : 0;
    }
}
