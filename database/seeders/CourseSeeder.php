<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teacher1 = User::where('role', 'teacher')->where('email', 'teacher1@learngate.com')->first();
        $teacher2 = User::where('role', 'teacher')->where('email', 'teacher2@learngate.com')->first();

        Course::create([
            'category_id' => 1,
            'teacher_id' => $teacher1?->id, 
            'title' => 'English Grammar for Beginners',
            'description' => 'Learn the fundamentals of English grammar including tenses, sentence structure, and parts of speech for everyday communication',
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(50),
            'is_active' => true,
            'student_count' => 2,
        ]);
        
        Course::create([
            'category_id' => 2,
            'teacher_id' => $teacher1?->id,
            'title' => 'English Conversation Practice',
            'description' => 'Build confidence in speaking English through daily conversations, dialogues, and practical real-life scenarios',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(55),
            'is_active' => true,
            'student_count' => 1,
        ]);

        Course::create([
            'category_id' => 3,
            'teacher_id' => $teacher2?->id,
            'title' => 'Essential English Vocabulary',
            'description' => 'Expand your vocabulary with the most common English words, phrases, and idioms used in everyday life and conversations',
            'start_date' => now()->subDays(15),
            'end_date' => now()->addDays(45),
            'is_active' => true,
            'student_count' => 1,
        ]);

        Course::create([
            'category_id' => 6,
            'teacher_id' => $teacher2?->id,
            'title' => 'Business English Communication',
            'description' => 'Master professional English for emails, presentations, meetings, and workplace conversations to advance your career',
            'start_date' => now()->subDays(7),
            'end_date' => now()->addDays(53),
            'is_active' => true,
            'student_count' => 0,
        ]);

        Course::create([
            'category_id' => 4,
            'teacher_id' => $teacher1?->id,
            'title' => 'Academic Writing Skills',
            'description' => 'Learn to write essays, reports, and academic papers with proper structure, style, and academic conventions',
            'start_date' => now()->subDays(3),
            'end_date' => now()->addDays(57),
            'is_active' => true,
            'student_count' => 0,
        ]);

        Course::create([
            'category_id' => 5,
            'teacher_id' => $teacher2?->id,
            'title' => 'English Pronunciation Mastery',
            'description' => 'Perfect your English pronunciation, improve accent clarity, and understand native speakers better through systematic practice',
            'start_date' => now()->subDays(12),
            'end_date' => now()->addDays(48),
            'is_active' => true,
            'student_count' => 0,
        ]);

        Course::create([
            'category_id' => 1,
            'teacher_id' => $teacher1?->id,
            'title' => 'Advanced English Grammar',
            'description' => 'Master complex grammar structures including conditionals, passive voice, reported speech, and advanced tenses',
            'start_date' => now()->subDays(8),
            'end_date' => now()->addDays(52),
            'is_active' => true,
            'student_count' => 0,
        ]);

        Course::create([
            'category_id' => 2, 
            'teacher_id' => $teacher2?->id,
            'title' => 'IELTS Speaking Preparation',
            'description' => 'Prepare for IELTS speaking test with strategies, practice questions, and feedback to achieve your target band score',
            'start_date' => now()->subDays(6),
            'end_date' => now()->addDays(54),
            'is_active' => true,
            'student_count' => 0,
        ]);
    }
}