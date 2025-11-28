<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Content;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function index(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $contents = $course->contents()->orderBy('order')->get();

        return view('teacher.contents.index', compact('course', 'contents'));
    }

    public function create(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $lastOrder = $course->contents()->max('order') ?? 0;

        return view('teacher.contents.create', compact('course', 'lastOrder'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'order' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Check if order already exists
            $existingContent = $course->contents()->where('order', $request->order)->first();
            
            if ($existingContent) {
                // Shift all contents with order >= new order
                $course->contents()
                    ->where('order', '>=', $request->order)
                    ->increment('order');
            }

            $content = Content::create([
                'course_id' => $course->id,
                'title' => $request->title,
                'content' => $request->content,
                'order' => $request->order,
            ]);

            // Create progress records for all enrolled students
            $enrollments = $course->enrollments()->get();
            
            foreach ($enrollments as $enrollment) {
                Progress::create([
                    'enrollment_id' => $enrollment->id,
                    'content_id' => $content->id,
                    'is_completed' => false,
                    'completed_at' => null,
                ]);
            }

            DB::commit();

            return redirect()->route('teacher.contents.index', $course)
                ->with('success', 'Content berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Course $course, Content $content)
    {
        if ($course->teacher_id !== auth()->id() || $content->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('teacher.contents.edit', compact('course', 'content'));
    }

    public function update(Request $request, Course $course, Content $content)
    {
        if ($course->teacher_id !== auth()->id() || $content->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'order' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $oldOrder = $content->order;
            $newOrder = $request->order;

            if ($oldOrder !== $newOrder) {
                if ($newOrder > $oldOrder) {
                    // Moving down: shift contents between old and new position up
                    $course->contents()
                        ->where('order', '>', $oldOrder)
                        ->where('order', '<=', $newOrder)
                        ->decrement('order');
                } else {
                    // Moving up: shift contents between new and old position down
                    $course->contents()
                        ->where('order', '>=', $newOrder)
                        ->where('order', '<', $oldOrder)
                        ->increment('order');
                }
            }

            $content->update([
                'title' => $request->title,
                'content' => $request->content,
                'order' => $newOrder,
            ]);

            DB::commit();

            return redirect()->route('teacher.contents.index', $course)
                ->with('success', 'Content berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Course $course, Content $content)
    {
        if ($course->teacher_id !== auth()->id() || $content->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $deletedOrder = $content->order;

            // Delete the content (will cascade delete progress records)
            $content->delete();

            // Shift remaining contents down
            $course->contents()
                ->where('order', '>', $deletedOrder)
                ->decrement('order');

            DB::commit();

            return redirect()->route('teacher.contents.index', $course)
                ->with('success', 'Content berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}