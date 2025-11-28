<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        
        $courses = $teacher->coursesAsTeacher()->withCount(['students', 'contents'])->get();
        
        $stats = [
            'totalCourses' => $courses->count(),
            'activeCourses' => $courses->where('is_active', true)->count(),
            'totalStudents' => $courses->sum('student_count'),
            'totalContents' => $courses->sum('contents_count'),
        ];
        
        $recentCourses = $teacher->coursesAsTeacher()
            ->with(['category'])
            ->withCount(['students', 'contents'])
            ->latest()
            ->take(5)
            ->get();
        
        $popularCourses = $teacher->coursesAsTeacher()
            ->with(['category'])
            ->where('is_active', true)
            ->orderBy('student_count', 'desc')
            ->take(5)
            ->get();
        
        return view('teacher.dashboard', compact('stats', 'recentCourses', 'popularCourses'));
    }
}