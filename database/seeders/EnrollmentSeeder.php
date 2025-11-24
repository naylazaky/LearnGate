<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $enrollment1 = Enrollment::create([
            'student_id' => 4,
            'course_id' => 1,
            'enrolled_at' => now()->subDays(8),
        ]);

        Enrollment::create([
            'student_id' => 5,
            'course_id' => 1,
            'enrolled_at' => now()->subDays(6),
        ]);

        Enrollment::create([
            'student_id' => 4,
            'course_id' => 2,
            'enrolled_at' => now()->subDays(4),
        ]);

        Enrollment::create([
            'student_id' => 5,
            'course_id' => 3,
            'enrolled_at' => now()->subDays(10),
        ]);

        Progress::create([
            'enrollment_id' => $enrollment1->id,
            'content_id' => 1,
            'is_completed' => true,
            'completed_at' => now()->subDays(7),
        ]);
        
        Progress::create([
            'enrollment_id' => $enrollment1->id,
            'content_id' => 2,
            'is_completed' => true,
            'completed_at' => now()->subDays(5),
        ]);

        Progress::create([
            'enrollment_id' => $enrollment1->id,
            'content_id' => 3,
            'is_completed' => false,
            'completed_at' => null,
        ]);
    }
}