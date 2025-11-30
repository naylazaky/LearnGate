<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['teacher', 'category'])
            ->whereHas('teacher')  
            ->whereHas('category'); 

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->latest()->paginate(12);
        
        $categories = Category::all();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        
        $teachers = User::where('role', 'teacher')
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->orderBy('username')
            ->get();

        return view('admin.courses.create', compact('categories', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:users,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $teacher = User::findOrFail($request->teacher_id);
        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'User yang dipilih bukan tentor.');
        }

        Course::create([
            'category_id' => $request->category_id,
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dibuat!');
    }

    public function edit(Course $course)
    {
        if (!$course->teacher) {
            return redirect()->route('admin.courses.index')
                ->with('error', 'Course ini tidak memiliki tentor.');
        }

        if (!$course->category) {
            return redirect()->route('admin.courses.index')
                ->with('error', 'Course ini tidak memiliki category.');
        }

        $categories = Category::all();
        
        $teachers = User::where('role', 'teacher')
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->orderBy('username')
            ->get();

        return view('admin.courses.edit', compact('course', 'categories', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:users,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $teacher = User::findOrFail($request->teacher_id);
        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'User yang dipilih bukan tentor.');
        }

        $course->update([
            'category_id' => $request->category_id,
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil diupdate!');
    }

    public function destroy(Course $course)
    {
        $enrollmentCount = $course->enrollments()->count();
        
        if ($enrollmentCount > 0) {
            return back()->with('error', 
                "Course tidak bisa dihapus karena ada {$enrollmentCount} student enrolled.");
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dihapus!');
    }

    public function toggleStatus(Course $course)
    {
        $course->update([
            'is_active' => !$course->is_active,
        ]);

        $status = $course->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Course berhasil {$status}!");
    }
}