<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularCourses = Course::with(['teacher', 'category'])
            ->withCount('contents')
            ->where('is_active', true)
            ->whereHas('teacher') 
            ->whereHas('category')
            ->orderBy('student_count', 'desc')
            ->take(5)
            ->get();

        $categories = Category::withCount(['courses' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('courses_count', 'desc')
            ->take(3)
            ->get();

        return view('home', compact('popularCourses', 'categories'));
    }

    public function catalog(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|integer|exists:categories,id',
        ]);

        $query = Course::with(['teacher', 'category'])
            ->withCount('contents')
            ->where('is_active', true)
            ->whereHas('teacher') 
            ->whereHas('category'); 

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $courses = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('courses.catalog', compact('courses', 'categories'));
    }

    public function show($id)
    {
        $course = Course::with([
                'teacher', 
                'category', 
                'contents' => function($query) {
                    $query->orderBy('order');
                }
            ])
            ->whereHas('teacher') 
            ->whereHas('category') 
            ->findOrFail($id);

        $isEnrolled = false;
        $progress = 0;

        if (auth()->check() && auth()->user()->role === 'student') {
            $enrollment = auth()->user()->enrollments()
                ->with('progresses')
                ->where('course_id', $id)
                ->first();

            if ($enrollment) {
                $isEnrolled = true;
                $progress = $enrollment->calculateProgress();
            }
        }

        return view('courses.show', compact('course', 'isEnrolled', 'progress'));
    }
}