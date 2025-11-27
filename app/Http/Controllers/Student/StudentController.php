<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();
        
        $enrolledCourses = $student->enrollments()
            ->with(['course.teacher', 'course.category', 'course.contents'])
            ->latest('enrolled_at')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'enrollment' => $enrollment,
                    'course' => $enrollment->course,
                    'progress' => $enrollment->calculateProgress(),
                    'isCompleted' => $enrollment->isCompleted(),
                    'totalContents' => $enrollment->course->contents->count(),
                    'completedContents' => $enrollment->progresses()->where('is_completed', true)->count(),
                ];
            });
        
        $inProgressCourses = $enrolledCourses->where('isCompleted', false);
        $completedCourses = $enrolledCourses->where('isCompleted', true);
        
        $stats = [
            'totalEnrolled' => $enrolledCourses->count(),
            'inProgress' => $inProgressCourses->count(),
            'completed' => $completedCourses->count(),
            'averageProgress' => $enrolledCourses->isEmpty() ? 0 : round($enrolledCourses->avg('progress'), 2),
        ];
        
        return view('student.dashboard', compact('inProgressCourses', 'completedCourses', 'stats'));
    }
    
    public function myCourses()
    {
        $student = auth()->user();
        
        $enrolledCourses = $student->enrollments()
            ->with(['course.teacher', 'course.category', 'course.contents'])
            ->latest('enrolled_at')
            ->paginate(12)
            ->through(function ($enrollment) {
                return [
                    'enrollment' => $enrollment,
                    'course' => $enrollment->course,
                    'progress' => $enrollment->calculateProgress(),
                    'isCompleted' => $enrollment->isCompleted(),
                    'totalContents' => $enrollment->course->contents->count(),
                    'completedContents' => $enrollment->progresses()->where('is_completed', true)->count(),
                ];
            });
        
        return view('student.my-courses', compact('enrolledCourses'));
    }
}