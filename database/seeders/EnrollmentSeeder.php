<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::all();

        // Setiap student mendaftar ke 2-5 courses secara random
        foreach ($students as $student) {
            $enrollmentCount = rand(2, 5);
            $randomCourses = $courses->random($enrollmentCount);

            foreach ($randomCourses as $course) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'enrolled_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}