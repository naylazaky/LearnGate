<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function myCourses()
    {
        $student = auth()->user();
        $enrolledCourses = $student->enrollments()
            ->with(['course.teacher', 'course.category', 'course.contents', 'progresses'])
            ->latest('enrolled_at')
            ->paginate(12)
            ->through(function ($enrollment) {
                $totalContents = $enrollment->course?->contents->count() ?? 0;
                $completedContents = $enrollment->progresses->where('is_completed', true)->count();
                
                return [
                    'enrollment' => $enrollment,
                    'course' => $enrollment->course,
                    'progress' => $enrollment->calculateProgress(),
                    'isCompleted' => $enrollment->isCompleted(),
                    'totalContents' => $totalContents,
                    'completedContents' => $completedContents,
                ];
            });
        
        return view('student.my-courses', compact('enrolledCourses'));
    }
}