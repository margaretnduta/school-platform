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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // General dashboard redirect
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('students', StudentController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('dormitories', DormitoryController::class);
        Route::resource('admissions', AdmissionController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('meals', MealController::class);
        Route::resource('academics', AcademicController::class);
        Route::resource('events', EventController::class);
    });

});

require __DIR__.'/auth.php';