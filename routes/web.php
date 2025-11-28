<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\LessonController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\ContentController as TeacherContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [HomeController::class, 'catalog'])->name('courses.catalog');
Route::get('/courses/{id}', [HomeController::class, 'show'])->name('courses.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register/success', [AuthController::class, 'registerSuccess'])->name('register.success');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/courses/{id}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{id}/unenroll', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', AdminUserController::class);
    Route::get('/teachers/pending', [AdminUserController::class, 'pendingTeachers'])->name('teachers.pending');
    Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    
    // Course Management
    Route::resource('courses', AdminCourseController::class)->except(['create', 'store']);
    Route::post('/courses/{course}/toggle-status', [AdminCourseController::class, 'toggleStatus'])->name('courses.toggle-status');
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    
    // Course Management
    Route::resource('courses', TeacherCourseController::class);
    Route::get('/courses/{course}/students', [TeacherCourseController::class, 'students'])->name('courses.students');
    
    // Content Management
    Route::get('/courses/{course}/contents', [TeacherContentController::class, 'index'])->name('contents.index');
    Route::get('/courses/{course}/contents/create', [TeacherContentController::class, 'create'])->name('contents.create');
    Route::post('/courses/{course}/contents', [TeacherContentController::class, 'store'])->name('contents.store');
    Route::get('/courses/{course}/contents/{content}/edit', [TeacherContentController::class, 'edit'])->name('contents.edit');
    Route::put('/courses/{course}/contents/{content}', [TeacherContentController::class, 'update'])->name('contents.update');
    Route::delete('/courses/{course}/contents/{content}', [TeacherContentController::class, 'destroy'])->name('contents.destroy');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-courses', [StudentController::class, 'myCourses'])->name('my-courses');
    
    Route::get('/courses/{courseId}/lesson/{contentId}', [LessonController::class, 'show'])->name('lesson.show');
    Route::post('/courses/{courseId}/lesson/{contentId}/complete', [LessonController::class, 'markAsCompleted'])->name('lesson.complete');
});