<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll($courseId)
    {
        if (auth()->user()->role !== 'student') {
            return back()->with('error', 'Hanya siswa yang dapat mendaftar course.');
        }

        $course = Course::findOrFail($courseId);

        if (!$course->is_active) {
            return back()->with('error', 'Course ini sedang tidak aktif.');
        }

        $existingEnrollment = auth()->user()->enrollments()
            ->where('course_id', $courseId)
            ->first();

        if ($existingEnrollment) {
            return back()->with('error', 'Anda sudah terdaftar di course ini.');
        }

        $enrollment = Enrollment::create([
            'student_id' => auth()->id(),
            'course_id' => $courseId,
            'enrolled_at' => now(),
        ]);

        $contents = $course->contents()->orderBy('order')->get();
        
        if ($contents->count() > 0) {
            $progressData = $contents->map(fn($content) => [
                'enrollment_id' => $enrollment->id,
                'content_id' => $content->id,
                'is_completed' => false,
                'completed_at' => null,
            ])->toArray();

            Progress::insert($progressData);
        }

        return redirect()->route('courses.show', $courseId)
            ->with('success', 'Berhasil mendaftar di course ini!');
    }

    public function unenroll($courseId)
    {
        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $courseId)
            ->firstOrFail();

        if ($enrollment->calculateProgress() == 100) {
            return back()->with('error', 'Anda tidak dapat keluar dari course yang sudah selesai.');
        }

        $enrollment->delete();

        return redirect()->route('courses.show', $courseId)
            ->with('success', 'Berhasil keluar dari course ini.');
    }
}