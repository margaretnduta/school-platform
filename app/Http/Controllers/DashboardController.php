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
            return view('dashboards.teacher');
        } elseif ($user->hasRole('parent')) {
            return view('dashboards.parent');
        } else {
            return view('dashboards.student');
        }
    }

    public function adminDashboard()
    {
        return view('dashboards.admin');
    }
}