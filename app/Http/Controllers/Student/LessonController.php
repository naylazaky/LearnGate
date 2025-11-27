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
            ->where('course_id', $courseId)
            ->firstOrFail();

        $content = Content::where('course_id', $courseId)
            ->where('id', $contentId)
            ->firstOrFail();

        $course = $enrollment->course;
        
        $allContents = $course->contents()->orderBy('order')->get();
        
        $progress = $enrollment->progresses()
            ->where('content_id', $contentId)
            ->first();
        
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
            ->firstOrFail();
        
        $content = Content::where('course_id', $courseId)
            ->where('id', $contentId)
            ->firstOrFail();
        
        try {
            DB::beginTransaction();
            
            // Get or create progress
            $progress = $enrollment->progresses()
                ->where('content_id', $contentId)
                ->first();
            
            if (!$progress) {
                // Create new progress if not exists
                $progress = Progress::create([
                    'enrollment_id' => $enrollment->id,
                    'content_id' => $contentId,
                    'is_completed' => true,
                    'completed_at' => now(),
                ]);
            } else {
                // Update existing progress
                $progress->update([
                    'is_completed' => true,
                    'completed_at' => now(),
                ]);
            }
            
            DB::commit();
            
            // Get next content
            $nextContent = $content->nextContent();
            
            // Redirect to next content if exists, otherwise back to course
            if ($nextContent) {
                return redirect()->route('student.lesson.show', [
                    'courseId' => $courseId, 
                    'contentId' => $nextContent->id
                ])->with('success', 'Materi berhasil diselesaikan! Lanjut ke materi berikutnya.');
            } else {
                return redirect()->route('courses.show', $courseId)
                    ->with('success', 'Selamat! Anda telah menyelesaikan semua materi kursus ini!');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}