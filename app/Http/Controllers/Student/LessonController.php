<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function show($courseId, $contentId)
    {
        $enrollment = auth()->user()->enrollments()
            ->with(['course.contents' => function($query) {
                $query->orderBy('order');
            }, 'progresses'])
            ->where('course_id', $courseId)
            ->whereHas('course')
            ->firstOrFail();

        if (!$enrollment->course) {
            abort(404, 'Course tidak ditemukan.');
        }

        $content = Content::where('course_id', $courseId)
            ->where('id', $contentId)
            ->firstOrFail();

        $course = $enrollment->course;
        $allContents = $course->contents;
        
        $progress = $enrollment->progresses->firstWhere('content_id', $contentId);
        $isCompleted = $progress ? $progress->is_completed : false;
        
        $nextContent = $content->nextContent();
        $previousContent = $content->previousContent();
        
        $overallProgress = $enrollment->calculateProgress();
        
        return view('student.lesson', compact(
            'course',
            'content',
            'enrollment',
            'allContents',
            'isCompleted',
            'nextContent',
            'previousContent',
            'overallProgress'
        ));
    }
    
    public function markAsCompleted($courseId, $contentId)
    {
        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $courseId)
            ->whereHas('course') 
            ->firstOrFail();

        if (!$enrollment->course) {
            return back()->with('error', 'Course tidak ditemukan.');
        }
        
        $content = Content::where('course_id', $courseId)
            ->where('id', $contentId)
            ->firstOrFail();

        $previousContent = $content->previousContent();
        if ($previousContent) {
            $previousProgress = $enrollment->progresses()
                ->where('content_id', $previousContent->id)
                ->first();
            
            if (!$previousProgress || !$previousProgress->is_completed) {
                return back()->with('error', 'Anda harus menyelesaikan materi sebelumnya terlebih dahulu.');
            }
        }

        Progress::updateOrCreate(
            [
                'enrollment_id' => $enrollment->id,
                'content_id' => $contentId,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );
        
        $nextContent = $content->nextContent();
        
        if ($nextContent) {
            return redirect()->route('student.lesson.show', [
                'courseId' => $courseId, 
                'contentId' => $nextContent->id
            ])->with('success', 'Materi berhasil diselesaikan! Lanjut ke materi berikutnya.');
        }
        
        return redirect()->route('courses.show', $courseId)
            ->with('success', 'Selamat! Anda telah menyelesaikan semua materi kursus ini!');
    }
}