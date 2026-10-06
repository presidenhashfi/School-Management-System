<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController; // Tambahkan ini
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\PromotionController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

// Route untuk Auth (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Ganti password (semua user yang login)
    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    // Manajemen akun (Hanya Admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

    // ==========================================
    // MODUL STUDENTS (Sesuai Matrix: Admin CRUD, Teacher View)
    // ==========================================
    Route::get('/students', [StudentController::class, 'index'])->middleware('role:admin,teacher')->name('students.index');
    Route::middleware('role:admin')->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    });

    // ==========================================
    // MODUL CLASSES (Admin CRUD, Teacher & Student View)
    // ==========================================
    Route::get('/classes', [ClassesController::class, 'index'])->middleware('role:admin,teacher,student')->name('classes.index');
    Route::middleware('role:admin')->group(function () {
        Route::resource('classes', ClassesController::class)->except(['index', 'show']);
        Route::get('/promotion', [PromotionController::class, 'index'])->name('promotion.index');
        Route::post('/promotion', [PromotionController::class, 'store'])->name('promotion.store');
    });
    Route::get('/classes/{class}', [ClassesController::class, 'show'])->whereNumber('class')
        ->middleware('role:admin,teacher,student')->name('classes.show');

    // ==========================================
    // MODUL SUBJECTS (Admin CRUD, Teacher View)
    // ==========================================
    Route::get('/subjects', [SubjectController::class, 'index'])->middleware('role:admin,teacher')->name('subjects.index');
    Route::middleware('role:admin')->group(function () {
        Route::resource('subjects', SubjectController::class)->except(['index', 'show']);
    });

    // ==========================================
    // MODUL SOAL / ASSIGNMENTS (Admin & Guru buat soal dengan RTE, Siswa upload jawaban PDF)
    // ==========================================
    Route::middleware('role:admin,teacher')->group(function () {
        Route::resource('assignments', AssignmentController::class)->except(['index', 'show']);
    });
    Route::middleware('role:admin,teacher,student')->group(function () {
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->whereNumber('assignment')->name('assignments.show');
        Route::get('/submissions/{submission}/download', [AssignmentController::class, 'download'])->name('submissions.download');
    });
    Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])
        ->middleware('role:student')->name('assignments.submit');

    // ==========================================
    // MODUL TEACHERS (Hanya Admin)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        Route::resource('teachers', TeacherController::class);
    });
});