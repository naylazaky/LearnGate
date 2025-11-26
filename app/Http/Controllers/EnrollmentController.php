<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        try {
            DB::beginTransaction();

            $enrollment = Enrollment::create([
                'student_id' => auth()->id(),
                'course_id' => $courseId,
                'enrolled_at' => now(),
            ]);

            $contents = $course->contents;
            
            if ($contents->count() > 0) {
                $progressData = $contents->map(function ($content) use ($enrollment) {
                    return [
                        'enrollment_id' => $enrollment->id,
                        'content_id' => $content->id,
                        'is_completed' => false,
                        'completed_at' => null,
                    ];
                })->toArray();

                Progress::insert($progressData);
            }

            $course->increment('student_count');

            DB::commit();

            return redirect()->route('courses.show', $courseId)
                ->with('success', 'Berhasil mendaftar di course ini! Mulai belajar sekarang.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function unenroll($courseId)
    {
        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Anda tidak terdaftar di course ini.');
        }

        if ($enrollment->calculateProgress() > 0) {
            return back()->with('error', 'Anda tidak dapat keluar dari course yang sudah dimulai. Progress Anda: ' . $enrollment->calculateProgress() . '%');
        }

        try {
            DB::beginTransaction();

            $course = Course::findOrFail($courseId);

            $enrollment->delete();

            $course->decrement('student_count');

            DB::commit();

            return redirect()->route('courses.show', $courseId)
                ->with('success', 'Berhasil keluar dari course ini.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}