<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\LessonController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\ContentController as TeacherContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [HomeController::class, 'catalog'])->name('courses.catalog');
Route::get('/courses/{id}', [HomeController::class, 'show'])->name('courses.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5x per minute
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1'); // 3x per minute
    
    Route::get('/register/success', [AuthController::class, 'registerSuccess'])->name('register.success');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    Route::delete('/profile/delete-account', [ProfileController::class, 'deleteAccount'])->name('profile.delete-account');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/courses/{id}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{id}/unenroll', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', AdminUserController::class);
    Route::get('/teachers/pending', [AdminUserController::class, 'pendingTeachers'])->name('teachers.pending');
    Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/courses/{course}/toggle-status', [AdminCourseController::class, 'toggleStatus'])->name('courses.toggle-status');
    
    Route::resource('categories', AdminCategoryController::class);
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::resource('courses', TeacherCourseController::class);
    Route::get('/courses/{course}/students', [TeacherCourseController::class, 'students'])->name('courses.students');
    
    Route::get('/courses/{course}/contents', [TeacherContentController::class, 'index'])->name('contents.index');
    Route::get('/courses/{course}/contents/create', [TeacherContentController::class, 'create'])->name('contents.create');
    Route::post('/courses/{course}/contents', [TeacherContentController::class, 'store'])->name('contents.store');
    Route::get('/courses/{course}/contents/{content}/edit', [TeacherContentController::class, 'edit'])->name('contents.edit');
    Route::put('/courses/{course}/contents/{content}', [TeacherContentController::class, 'update'])->name('contents.update');
    Route::delete('/courses/{course}/contents/{content}', [TeacherContentController::class, 'destroy'])->name('contents.destroy');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/my-courses', [StudentController::class, 'myCourses'])->name('my-courses');
    
    Route::get('/courses/{courseId}/lesson/{contentId}', [LessonController::class, 'show'])->name('lesson.show');
    Route::post('/courses/{courseId}/lesson/{contentId}/complete', [LessonController::class, 'markAsCompleted'])->name('lesson.complete');
});