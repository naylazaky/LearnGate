<?php

namespace Database\Seeders;

use App\Models\Progress;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = Enrollment::with('course.contents')->get();

        foreach ($enrollments as $enrollment) {
            $contents = $enrollment->course->contents;
            
            // Random progress: student menyelesaikan 30%-80% dari materi
            $completionRate = rand(30, 80) / 100;
            $completedCount = (int) ($contents->count() * $completionRate);

            foreach ($contents as $index => $content) {
                $isCompleted = $index < $completedCount;

                Progress::create([
                    'enrollment_id' => $enrollment->id,
                    'content_id' => $content->id,
                    'is_completed' => $isCompleted,
                    'completed_at' => $isCompleted 
                        ? Carbon::now()->subDays(rand(1, 20)) 
                        : null,
                ]);
            }
        }
    }
}