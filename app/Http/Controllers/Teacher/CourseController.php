<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->coursesAsTeacher();

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query
            ->with(['category'])
            ->withCount(['students', 'contents'])
            ->latest()
            ->paginate(12);

        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        
        return view('teacher.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $course = Course::create([
            'category_id' => $request->category_id,
            'teacher_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
        ]);

        return redirect()->route('teacher.courses.show', $course)
            ->with('success', 'Course berhasil dibuat!');
    }

    public function show(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $course->load(['category', 'contents' => function($query) {
            $query->orderBy('order');
        }]);

        $enrollments = $course->enrollments()
            ->with('student')
            ->latest('enrolled_at')
            ->take(10)
            ->get();

        return view('teacher.courses.show', compact('course', 'enrollments'));
    }

    public function edit(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        
        return view('teacher.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $course->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('teacher.courses.show', $course)
            ->with('success', 'Course berhasil diupdate!');
    }

    public function destroy(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $course->delete();

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course berhasil dihapus!');
    }

    public function students(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $enrollments = $course->enrollments()
            ->with(['student', 'progresses'])
            ->latest('enrolled_at')
            ->paginate(20);
        $studentsData = $enrollments->map(function ($enrollment) {
            return [
                'enrollment' => $enrollment,
                'student' => $enrollment->student,
                'progress' => $enrollment->calculateProgress(),
                'isCompleted' => $enrollment->isCompleted(),
                'enrolledAt' => $enrollment->enrolled_at,
            ];
        });

        return view('teacher.courses.students', compact('course', 'studentsData', 'enrollments'));
    }
}