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
            ->where('is_active', true)
            ->orderBy('student_count', 'desc')
            ->take(5)
            ->get();

        $categories = Category::all();

        return view('home', compact('popularCourses', 'categories'));
    }

    public function catalog(Request $request)
    {
        $query = Course::with(['teacher', 'category'])
            ->where('is_active', true);

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $courses = $query->paginate(12);
        $categories = Category::all();

        return view('courses.catalog', compact('courses', 'categories'));
    }

    public function show($id)
    {
        $course = Course::with(['teacher', 'category', 'contents'])
            ->findOrFail($id);

        $isEnrolled = false;
        $progress = 0;

        if (auth()->check() && auth()->user()->role === 'student') {
            $enrollment = auth()->user()->enrollments()
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