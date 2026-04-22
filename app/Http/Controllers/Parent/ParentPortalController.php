<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\AcademicRecord;
use App\Models\MealRecord;
use App\Models\DormitoryBed;
use App\Models\Event;
use Illuminate\Http\Request;

class ParentPortalController extends Controller
{
    // Find the child linked to this parent
    private function getChild()
    {
        $user = auth()->user();

        // Find approved admission linked to this parent's email
        $admission = Admission::where('guardian_email', $user->email)
                              ->where('status', 'approved')
                              ->with('student')
                              ->latest()
                              ->first();

        return $admission?->student ?? null;
    }

    // Dashboard
    public function dashboard()
    {
        $user        = auth()->user();
        $application = Admission::where('guardian_email', $user->email)
                                ->orWhere('email', $user->email)
                                ->latest()
                                ->first();

        $child = $this->getChild();

        $attendanceSummary = null;
        $recentEvents      = collect();
        $upcomingEvents    = collect();

        if ($child) {
            $attendanceSummary = [
                'total'   => Attendance::where('student_id', $child->id)->count(),
                'present' => Attendance::where('student_id', $child->id)->where('status', 'present')->count(),
                'absent'  => Attendance::where('student_id', $child->id)->where('status', 'absent')->count(),
            ];
        }

        // School events
        $upcomingEvents = Event::where('is_public', true)
                               ->where('event_date', '>=', now())
                               ->orderBy('event_date', 'asc')
                               ->limit(5)
                               ->get();

        return view('parent.dashboard', compact(
            'application', 'child', 'attendanceSummary', 'upcomingEvents'
        ));
    }

    // Child's attendance
    public function attendance()
    {
        $child = $this->getChild();

        if (!$child) {
            return redirect()->route('parent.dashboard');
        }

        $records = Attendance::where('student_id', $child->id)
                             ->orderBy('date', 'desc')
                             ->paginate(30);

        $total    = Attendance::where('student_id', $child->id)->count();
        $present  = Attendance::where('student_id', $child->id)->where('status', 'present')->count();
        $absent   = Attendance::where('student_id', $child->id)->where('status', 'absent')->count();
        $late     = Attendance::where('student_id', $child->id)->where('status', 'late')->count();
        $rate     = $total > 0 ? round(($present / $total) * 100) : 0;

        return view('parent.attendance', compact(
            'child', 'records', 'total', 'present', 'absent', 'late', 'rate'
        ));
    }

    // Child's report card
    public function reportCard(Request $request)
    {
        $child = $this->getChild();

        if (!$child) {
            return redirect()->route('parent.dashboard');
        }

        $selectedTerm = $request->term ?? 'term_1';
        $selectedYear = $request->year ?? date('Y');

        $records = AcademicRecord::where('student_id', $child->id)
                                 ->where('term', $selectedTerm)
                                 ->where('year', $selectedYear)
                                 ->with('subject')
                                 ->get();

        $totalMarks   = $records->sum('marks');
        $totalPoints  = $records->sum('points');
        $subjectCount = $records->count();
        $meanScore    = $subjectCount > 0 ? round($totalMarks / $subjectCount, 1) : 0;
        $meanGrade    = $subjectCount > 0
            ? AcademicRecord::calculateGrade($meanScore)['grade']
            : 'N/A';

        return view('parent.report-card', compact(
            'child', 'records', 'selectedTerm', 'selectedYear',
            'totalMarks', 'totalPoints', 'subjectCount', 'meanScore', 'meanGrade'
        ));
    }

    // Child's meals
    public function meals()
    {
        $child = $this->getChild();

        if (!$child) {
            return redirect()->route('parent.dashboard');
        }

        $records = MealRecord::where('student_id', $child->id)
                             ->with('meal')
                             ->orderByDesc('created_at')
                             ->paginate(30);

        $total     = MealRecord::where('student_id', $child->id)->count();
        $taken     = MealRecord::where('student_id', $child->id)->where('status', 'taken')->count();
        $notTaken  = $total - $taken;
        $mealRate  = $total > 0 ? round(($taken / $total) * 100) : 0;

        return view('parent.meals', compact(
            'child', 'records', 'total', 'taken', 'notTaken', 'mealRate'
        ));
    }

    // Child's dormitory
    public function dormitory()
    {
        $child = $this->getChild();

        if (!$child) {
            return redirect()->route('parent.dashboard');
        }

        $bed = DormitoryBed::where('student_id', $child->id)
                           ->with('room', 'dormitory')
                           ->first();

        return view('parent.dormitory', compact('child', 'bed'));
    }

    // School events & important dates
    public function events()
    {
        $upcomingEvents = Event::where('is_public', true)
                               ->where('event_date', '>=', now())
                               ->orderBy('event_date', 'asc')
                               ->get();

        $pastEvents = Event::where('is_public', true)
                           ->where('event_date', '<', now())
                           ->orderBy('event_date', 'desc')
                           ->limit(10)
                           ->get();

        return view('parent.events', compact('upcomingEvents', 'pastEvents'));
    }
}