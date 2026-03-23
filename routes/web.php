<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DormitoryController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Parent\ParentAdmissionController;
use App\Http\Controllers\Student\StudentAdmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Central dashboard redirect based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Admin Routes ──────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('students', StudentController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('meals', MealController::class);
        Route::resource('academics', AcademicController::class);
        Route::resource('events', EventController::class);
        Route::resource('dormitories', DormitoryController::class);
        Route::post('/dormitories/assign-bed', [DormitoryController::class, 'assignBed'])->name('dormitories.assign-bed');
        Route::post('/dormitories/release-bed/{bed}', [DormitoryController::class, 'releaseBed'])->name('dormitories.release-bed');
        Route::resource('admissions', AdmissionController::class)->except(['create', 'store']);
        Route::post('/admissions/{admission}/approve', [AdmissionController::class, 'approve'])->name('admissions.approve');
        Route::post('/admissions/{admission}/reject', [AdmissionController::class, 'reject'])->name('admissions.reject');
    });

    // ── Teacher Routes ────────────────────────────────────────
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'teacherDashboard'])->name('dashboard');
    });

    // ── Parent Routes ─────────────────────────────────────────
    Route::prefix('parent')->name('parent.')->middleware('role:parent')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'parentDashboard'])->name('dashboard');
        Route::resource('admissions', ParentAdmissionController::class)->only(['index', 'create', 'store', 'show']);
    });

    // ── Student Routes ────────────────────────────────────────
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
        Route::resource('admissions', StudentAdmissionController::class)->only(['index', 'create', 'store', 'show']);
    });

});

require __DIR__.'/auth.php';