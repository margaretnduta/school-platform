<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\MealRecord;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $classes    = SchoolClass::where('status', 'active')->get();
        $today      = date('Y-m-d');
        $todayMeals = Meal::where('date', $today)->withCount('records')->get();
        return view('admin.meals.index', compact('classes', 'today', 'todayMeals'));
    }

    public function load(Request $request)
    {
        $request->validate([
            'class'   => 'required|string',
            'date'    => 'required|date',
            'session' => 'required|in:breakfast,lunch,dinner',
        ]);

        $classes = SchoolClass::where('status', 'active')->get();
        $today   = date('Y-m-d');

        $students = Student::where('class', $request->class)
                           ->where('status', 'active')
                           ->get();

        $meal = Meal::where('date', $request->date)
                    ->where('session', $request->session)
                    ->where('class', $request->class)
                    ->first();

        $existing = $meal
            ? MealRecord::where('meal_id', $meal->id)->pluck('status', 'student_id')
            : collect();

        $todayMeals = Meal::where('date', $today)->withCount('records')->get();

        return view('admin.meals.index', compact(
            'classes', 'students', 'existing', 'todayMeals', 'today'
        ))->with([
            'selectedClass'   => $request->class,
            'selectedDate'    => $request->date,
            'selectedSession' => $request->session,
            'existingMeal'    => $meal,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class'   => 'required|string',
            'date'    => 'required|date',
            'session' => 'required|in:breakfast,lunch,dinner',
            'meals'   => 'required|array',
        ]);

        $meal = Meal::firstOrCreate(
            [
                'date'    => $request->date,
                'session' => $request->session,
                'class'   => $request->class,
            ],
            ['created_by' => auth()->id()]
        );

        foreach ($request->meals as $studentId => $status) {
            MealRecord::updateOrCreate(
                ['meal_id' => $meal->id, 'student_id' => $studentId],
                [
                    'status'  => $status,
                    'remarks' => $request->remarks[$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('admin.meals.index')
                         ->with('success', ucfirst($request->session) . ' records saved for ' . $request->class . ' on ' . $request->date);
    }

    public function report(Request $request)
    {
        $classes         = SchoolClass::where('status', 'active')->get();
        $selectedClass   = $request->class;
        $selectedSession = $request->session;
        $from            = $request->from ?? date('Y-m-01');
        $to              = $request->to   ?? date('Y-m-d');

        $query = Meal::with(['records.student'])
                     ->whereBetween('date', [$from, $to]);

        if ($selectedClass)   $query->where('class', $selectedClass);
        if ($selectedSession) $query->where('session', $selectedSession);

        $records = $query->orderBy('date', 'desc')->get();

        return view('admin.meals.report', compact(
            'classes', 'records', 'selectedClass', 'selectedSession', 'from', 'to'
        ));
    }

    // Single meal session details
    public function show($id)
    {
        $meal = Meal::with('records.student')->findOrFail($id);
        return view('admin.meals.show', compact('meal'));
    }

    // Student meal profile with stats and graph
    public function studentProfile(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);

        $from = $request->from ?? date('Y-m-01', strtotime('-3 months'));
        $to   = $request->to   ?? date('Y-m-d');

        // All meal records for this student
        $records = MealRecord::where('student_id', $studentId)
                             ->with('meal')
                             ->whereHas('meal', function ($q) use ($from, $to) {
                                 $q->whereBetween('date', [$from, $to]);
                             })
                             ->get();

        // Overall stats
        $totalRecords    = $records->count();
        $totalTaken      = $records->where('status', 'taken')->count();
        $totalNotTaken   = $records->where('status', 'not_taken')->count();
        $mealPercentage  = $totalRecords > 0 ? round(($totalTaken / $totalRecords) * 100) : 0;

        // Breakdown by session
        $breakfastTaken  = $records->filter(fn($r) => $r->meal->session == 'breakfast' && $r->status == 'taken')->count();
        $breakfastTotal  = $records->filter(fn($r) => $r->meal->session == 'breakfast')->count();
        $lunchTaken      = $records->filter(fn($r) => $r->meal->session == 'lunch' && $r->status == 'taken')->count();
        $lunchTotal      = $records->filter(fn($r) => $r->meal->session == 'lunch')->count();
        $dinnerTaken     = $records->filter(fn($r) => $r->meal->session == 'dinner' && $r->status == 'taken')->count();
        $dinnerTotal     = $records->filter(fn($r) => $r->meal->session == 'dinner')->count();

        // Daily chart data — group by date
        $dailyData = $records->groupBy(fn($r) => $r->meal->date->format('Y-m-d'))
                             ->map(fn($dayRecords) => [
                                 'taken'     => $dayRecords->where('status', 'taken')->count(),
                                 'not_taken' => $dayRecords->where('status', 'not_taken')->count(),
                             ])
                             ->sortKeys();

        $chartLabels = $dailyData->keys()->values()->toArray();
        $chartTaken  = $dailyData->pluck('taken')->values()->toArray();
        $chartMissed = $dailyData->pluck('not_taken')->values()->toArray();

        // Recent records
        $recentRecords = MealRecord::where('student_id', $studentId)
                                   ->with('meal')
                                   ->whereHas('meal', function ($q) use ($from, $to) {
                                       $q->whereBetween('date', [$from, $to]);
                                   })
                                   ->orderByDesc('created_at')
                                   ->paginate(20);

        return view('admin.meals.student-profile', compact(
            'student', 'totalRecords', 'totalTaken', 'totalNotTaken',
            'mealPercentage', 'breakfastTaken', 'breakfastTotal',
            'lunchTaken', 'lunchTotal', 'dinnerTaken', 'dinnerTotal',
            'chartLabels', 'chartTaken', 'chartMissed',
            'recentRecords', 'from', 'to'
        ));
    }

    public function create()  { return redirect()->route('admin.meals.index'); }
    public function edit($id) { return redirect()->route('admin.meals.index'); }
    public function update(Request $request, $id) { return redirect()->route('admin.meals.index'); }
    public function destroy($id)
    {
        Meal::findOrFail($id)->delete();
        return redirect()->route('admin.meals.index')->with('success', 'Meal session deleted.');
    }
}