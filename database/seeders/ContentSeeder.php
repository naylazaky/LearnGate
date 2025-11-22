<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Setiap course punya 5-8 materi
            $contentCount = rand(5, 8);

            for ($i = 1; $i <= $contentCount; $i++) {
                Content::create([
                    'course_id' => $course->id,
                    'title' => "Lesson {$i}: " . $this->generateContentTitle($course->title, $i),
                    'body' => $this->generateContentBody($course->title, $i),
                    'order' => $i,
                ]);
            }
        }
    }

    /**
     * Generate content title based on course
     */
    private function generateContentTitle($courseTitle, $lessonNumber)
    {
        $titles = [
            1 => 'Introduction and Setup',
            2 => 'Basic Concepts',
            3 => 'Core Features',
            4 => 'Advanced Techniques',
            5 => 'Best Practices',
            6 => 'Real-World Projects',
            7 => 'Optimization and Performance',
            8 => 'Final Project and Review',
        ];

        return $titles[$lessonNumber] ?? 'Advanced Topics';
    }

    /**
     * Generate content body
     */
    private function generateContentBody($courseTitle, $lessonNumber)
    {
        return "Welcome to Lesson {$lessonNumber} of {$courseTitle}.\n\n" .
               "In this lesson, you will learn:\n" .
               "- Key concepts and fundamentals\n" .
               "- Practical examples and demonstrations\n" .
               "- Hands-on exercises to reinforce learning\n" .
               "- Best practices and common pitfalls to avoid\n\n" .
               "Make sure to complete all exercises before moving to the next lesson. " .
               "If you have any questions, feel free to reach out to your instructor.\n\n" .
               "Let's get started!";
    }
}