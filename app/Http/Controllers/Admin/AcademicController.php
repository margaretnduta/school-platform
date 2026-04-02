<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Staff;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    // Subjects list
    public function index()
    {
        $subjects = Subject::with('teacher')->latest()->get();
        $classes  = SchoolClass::where('status', 'active')->get();
        $teachers = Staff::where('role', 'teacher')->where('status', 'active')->get();
        return view('admin.academics.index', compact('subjects', 'classes', 'teachers'));
    }

    // Save new subject
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:20|unique:subjects,code',
            'class'      => 'required|string',
            'total_marks'=> 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1',
        ]);

        Subject::create($request->all());

        return redirect()->route('admin.academics.index')
                         ->with('success', 'Subject created successfully!');
    }

    // Enter marks page
    public function enterMarks(Request $request)
    {
        $classes  = SchoolClass::where('status', 'active')->get();
        $students = collect();
        $subjects = collect();

        $selectedClass = $request->class;
        $selectedTerm  = $request->term;
        $selectedYear  = $request->year ?? date('Y');

        if ($selectedClass && $selectedTerm) {
            $students = Student::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();

            $subjects = Subject::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();
        }

        return view('admin.academics.enter-marks', compact(
            'classes', 'students', 'subjects',
            'selectedClass', 'selectedTerm', 'selectedYear'
        ));
    }

    // Save marks
    public function saveMarks(Request $request)
    {
        $request->validate([
            'class'      => 'required|string',
            'term'       => 'required|in:term_1,term_2,term_3',
            'year'       => 'required|string',
            'marks'      => 'required|array',
        ]);

        foreach ($request->marks as $studentId => $subjectMarks) {
            foreach ($subjectMarks as $subjectId => $marks) {
                if ($marks === null || $marks === '') continue;

                $subject = Subject::findOrFail($subjectId);
                $grading = AcademicRecord::calculateGrade($marks, $subject->total_marks);

                AcademicRecord::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
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
                        'remarks'     => $request->remarks[$studentId][$subjectId] ?? null,
                        'recorded_by' => auth()->id(),
                    ]
                );
            }
        }

        return redirect()->route('admin.academics.enter-marks', [
            'class' => $request->class,
            'term'  => $request->term,
            'year'  => $request->year,
        ])->with('success', 'Marks saved successfully!');
    }

    // Class results overview
    public function classResults(Request $request)
    {
        $classes       = SchoolClass::where('status', 'active')->get();
        $selectedClass = $request->class;
        $selectedTerm  = $request->term;
        $selectedYear  = $request->year ?? date('Y');
        $results       = collect();

        if ($selectedClass && $selectedTerm) {
            $students = Student::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();

            $subjects = Subject::where('class', $selectedClass)
                               ->where('status', 'active')
                               ->get();

            $results = $students->map(function ($student) use ($selectedTerm, $selectedYear, $subjects) {
                $records     = AcademicRecord::where('student_id', $student->id)
                                             ->where('term', $selectedTerm)
                                             ->where('year', $selectedYear)
                                             ->get()
                                             ->keyBy('subject_id');

                $totalPoints = $records->sum('points');
                $totalMarks  = $records->sum('marks');
                $subjectCount= $records->count();
                $meanScore   = $subjectCount > 0 ? round($totalMarks / $subjectCount, 1) : 0;
                $meanGrade   = $subjectCount > 0
                    ? AcademicRecord::calculateGrade($meanScore)['grade']
                    : 'N/A';

                return [
                    'student'      => $student,
                    'records'      => $records,
                    'total_points' => $totalPoints,
                    'mean_score'   => $meanScore,
                    'mean_grade'   => $meanGrade,
                    'subject_count'=> $subjectCount,
                ];
            })->sortByDesc('total_points')->values();
        }

        return view('admin.academics.class-results', compact(
            'classes', 'results', 'selectedClass',
            'selectedTerm', 'selectedYear',
        ));
    }

    // Individual student report card
    public function reportCard(Request $request, $studentId)
    {
        $student       = Student::findOrFail($studentId);
        $selectedTerm  = $request->term  ?? 'term_1';
        $selectedYear  = $request->year  ?? date('Y');

        $subjects = Subject::where('class', $student->class)
                           ->where('status', 'active')
                           ->get();

        $records = AcademicRecord::where('student_id', $studentId)
                                 ->where('term', $selectedTerm)
                                 ->where('year', $selectedYear)
                                 ->with('subject')
                                 ->get()
                                 ->keyBy('subject_id');

        $totalMarks   = $records->sum('marks');
        $totalPoints  = $records->sum('points');
        $subjectCount = $records->count();
        $meanScore    = $subjectCount > 0 ? round($totalMarks / $subjectCount, 1) : 0;
        $meanGrade    = $subjectCount > 0
            ? AcademicRecord::calculateGrade($meanScore)['grade']
            : 'N/A';

        // All terms for this year — for chart
        $allTerms = ['term_1', 'term_2', 'term_3'];
        $chartData = [];
        foreach ($allTerms as $term) {
            $termRecords = AcademicRecord::where('student_id', $studentId)
                                         ->where('year', $selectedYear)
                                         ->where('term', $term)
                                         ->get();
            $termCount  = $termRecords->count();
            $chartData[$term] = $termCount > 0
                ? round($termRecords->sum('marks') / $termCount, 1)
                : 0;
        }

        return view('admin.academics.report-card', compact(
            'student', 'subjects', 'records',
            'totalMarks', 'totalPoints', 'subjectCount',
            'meanScore', 'meanGrade', 'selectedTerm',
            'selectedYear', 'chartData'
        ));
    }

    // Required by resource
    public function create()  { return redirect()->route('admin.academics.index'); }
    public function show($id) { return redirect()->route('admin.academics.index'); }
    public function edit($id) { return redirect()->route('admin.academics.index'); }
    public function update(Request $request, $id) { return redirect()->route('admin.academics.index'); }
    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->route('admin.academics.index')
                         ->with('success', 'Subject deleted.');
    }
}