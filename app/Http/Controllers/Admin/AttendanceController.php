<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes  = SchoolClass::where('status', 'active')->get();
        $today    = date('Y-m-d');
        $students = collect();
        $existing = collect();
        $selectedClass = null;
        $selectedDate  = $today;

        return view('admin.attendance.index', compact(
            'classes', 'today', 'students', 'existing', 'selectedClass', 'selectedDate'
        ));
    }

    public function load(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'date'  => 'required|date',
        ]);

        $classes  = SchoolClass::where('status', 'active')->get();
        $today    = date('Y-m-d');

        $students = Student::where('class', $request->class)
                           ->where('status', 'active')
                           ->get();

        $existing = Attendance::where('class', $request->class)
                              ->where('date', $request->date)
                              ->pluck('status', 'student_id');

        $selectedClass = $request->class;
        $selectedDate  = $request->date;

        return view('admin.attendance.index', compact(
            'classes', 'today', 'students', 'existing', 'selectedClass', 'selectedDate'
        ));
    }

    public function store(Request $request)
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

        return redirect()->route('admin.attendance.index')
                         ->with('success', 'Attendance saved for ' . $request->class . ' on ' . $request->date);
    }

    public function report(Request $request)
    {
        $classes       = SchoolClass::where('status', 'active')->get();
        $selectedClass = $request->class;
        $from          = $request->from ?? date('Y-m-01');
        $to            = $request->to   ?? date('Y-m-d');

        $query = Attendance::with('student')
                           ->whereBetween('date', [$from, $to]);

        if ($selectedClass) $query->where('class', $selectedClass);

        $records = $query->orderBy('date', 'desc')->get();

        return view('admin.attendance.report', compact(
            'classes', 'records', 'selectedClass', 'from', 'to'
        ));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        $records = Attendance::where('student_id', $id)
                             ->orderBy('date', 'desc')
                             ->paginate(30);

        return view('admin.attendance.show', compact('student', 'records'));
    }

    public function create()  { return redirect()->route('admin.attendance.index'); }
    public function edit($id) { return redirect()->route('admin.attendance.index'); }
    public function update(Request $request, $id) { return redirect()->route('admin.attendance.index'); }
    public function destroy($id) { return redirect()->route('admin.attendance.index'); }
}