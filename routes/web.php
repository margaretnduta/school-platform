<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DormitoryController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Parent\ParentAdmissionController;
use App\Http\Controllers\Student\StudentAdmissionController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $upcomingEvents = Event::where('is_public', true)
        ->orderBy('event_date', 'asc')
        ->limit(3)
        ->get();
    return view('welcome', compact('upcomingEvents'));
});

// Public Events Routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Admin Routes ──────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        Route::resource('students', StudentController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('events', AdminEventController::class);

        // Exams
        Route::resource('exams', ExamController::class);
        Route::get('/exams/{exam}/student/{student}/report', [ExamController::class, 'studentReport'])->name('exams.student-report');

        // Dormitory
        Route::resource('dormitories', DormitoryController::class);
        Route::post('/dormitories/assign-bed', [DormitoryController::class, 'assignBed'])->name('dormitories.assign-bed');
        Route::post('/dormitories/release-bed/{bed}', [DormitoryController::class, 'releaseBed'])->name('dormitories.release-bed');

        // Admissions
        Route::resource('admissions', AdmissionController::class);
        Route::post('/admissions/{admission}/approve', [AdmissionController::class, 'approve'])->name('admissions.approve');
        Route::post('/admissions/{admission}/reject', [AdmissionController::class, 'reject'])->name('admissions.reject');

        // Attendance — custom before resource
        Route::post('/attendance/load', [AttendanceController::class, 'load'])->name('attendance.load');
        Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('/attendance/student/{id}', [AttendanceController::class, 'show'])->name('attendance.student');
        Route::resource('attendance', AttendanceController::class);

        // Meals — custom before resource
        Route::post('/meals/load', [MealController::class, 'load'])->name('meals.load');
        Route::get('/meals/report', [MealController::class, 'report'])->name('meals.report');
        Route::get('/meals/student/{id}', [MealController::class, 'studentProfile'])->name('meals.student');
        Route::resource('meals', MealController::class);

        // Academics — custom before resource
        Route::get('/academics/enter-marks', [AcademicController::class, 'enterMarks'])->name('academics.enter-marks');
        Route::post('/academics/save-marks', [AcademicController::class, 'saveMarks'])->name('academics.save-marks');
        Route::get('/academics/class-results', [AcademicController::class, 'classResults'])->name('academics.class-results');
        Route::get('/academics/report-card/{id}', [AcademicController::class, 'reportCard'])->name('academics.report-card');
        Route::resource('academics', AcademicController::class);

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