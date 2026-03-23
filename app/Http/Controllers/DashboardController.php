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
        return view('dashboards.admin');
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