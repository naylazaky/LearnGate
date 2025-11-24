<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'category_id' => 1,
            'teacher_id' => 2,
            'title' => 'Laravel Fundamnetals',
            'description' => 'Learn the basics of Laravel framework',
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(50),
            'is_active' => true,
            'student_count' => 2,
        ]);
        
        Course::create([
            'category_id' => 1,
            'teacher_id' => 2,
            'title' => 'React for Beginners',
            'description' => 'Build interactive UIs with React',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(55),
            'is_active' => true,
            'student_count' => 1,
        ]);

        Course::create([
            'category_id' => 2,
            'teacher_id' => 3,
            'title' => 'Python Data Analysis',
            'description' => 'Analyze data using Python and Pandas',
            'start_date' => now()->subDays(15),
            'end_date' => now()->addDays(45),
            'is_active' => true,
            'student_count' => 1,
        ]);

    }
}
