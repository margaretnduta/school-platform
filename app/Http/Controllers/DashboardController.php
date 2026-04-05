<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('parent')) {
            return redirect()->route('parent.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }

    public function adminDashboard()
    {
        $studentCount = \App\Models\Student::count();
        $staffCount = \App\Models\Staff::count();
        $classCount = \App\Models\SchoolClass::count();
        $pendingAdmissions = \App\Models\Admission::where('status', 'pending')->count();
        $recentEvents = \App\Models\Event::where('is_public', true)
                                         ->orderBy('created_at', 'desc')
                                         ->limit(5)
                                         ->get();
        
        // Exam data
        $upcomingExams = \App\Models\Exam::where('status', 'planned')
                                         ->orderBy('start_date', 'asc')
                                         ->limit(5)
                                         ->get();
        $ongoingExams = \App\Models\Exam::where('status', 'ongoing')->count();
        $completedExams = \App\Models\Exam::where('status', 'completed')->count();

        return view('dashboards.admin', compact('studentCount', 'staffCount', 'classCount', 'pendingAdmissions', 'recentEvents', 'upcomingExams', 'ongoingExams', 'completedExams'));
    }

    public function teacherDashboard()
    {
        return view('dashboards.teacher');
    }

    public function parentDashboard()
    {
        $user        = auth()->user();
        $application = \App\Models\Admission::where('guardian_email', $user->email)
                                            ->orWhere('email', $user->email)
                                            ->latest()->first();
        return view('dashboards.parent', compact('application'));
    }

    public function studentDashboard()
    {
        $user        = auth()->user();
        $application = \App\Models\Admission::where('email', $user->email)
                                            ->latest()->first();
        return view('dashboards.student', compact('application'));
    }
}