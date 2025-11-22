<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = User::where('role', 'teacher')->get();
        
        $courses = [
            [
                'category_name' => 'Web Development',
                'title' => 'Laravel Fundamentals',
                'description' => 'Master the basics of Laravel framework and build modern web applications.',
                'duration_days' => 60,
            ],
            [
                'category_name' => 'Web Development',
                'title' => 'React.js Complete Guide',
                'description' => 'Learn React from scratch and build interactive user interfaces.',
                'duration_days' => 45,
            ],
            [
                'category_name' => 'Web Development',
                'title' => 'Full Stack Development with MERN',
                'description' => 'Build complete web applications using MongoDB, Express, React, and Node.js.',
                'duration_days' => 90,
            ],
            [
                'category_name' => 'Mobile Development',
                'title' => 'Flutter for Beginners',
                'description' => 'Create beautiful cross-platform mobile apps with Flutter and Dart.',
                'duration_days' => 50,
            ],
            [
                'category_name' => 'Mobile Development',
                'title' => 'Android Development with Kotlin',
                'description' => 'Build native Android applications using Kotlin programming language.',
                'duration_days' => 55,
            ],
            [
                'category_name' => 'Data Science',
                'title' => 'Python for Data Science',
                'description' => 'Learn Python programming and essential data science libraries.',
                'duration_days' => 70,
            ],
            [
                'category_name' => 'Data Science',
                'title' => 'Machine Learning A-Z',
                'description' => 'Master machine learning algorithms and build predictive models.',
                'duration_days' => 80,
            ],
            [
                'category_name' => 'Database Management',
                'title' => 'SQL Masterclass',
                'description' => 'Master SQL queries, database design, and optimization techniques.',
                'duration_days' => 40,
            ],
            [
                'category_name' => 'Database Management',
                'title' => 'MongoDB Complete Guide',
                'description' => 'Learn NoSQL database management with MongoDB.',
                'duration_days' => 35,
            ],
            [
                'category_name' => 'DevOps',
                'title' => 'Docker & Kubernetes',
                'description' => 'Master containerization and orchestration for modern applications.',
                'duration_days' => 45,
            ],
            [
                'category_name' => 'DevOps',
                'title' => 'CI/CD with Jenkins',
                'description' => 'Implement continuous integration and deployment pipelines.',
                'duration_days' => 30,
            ],
            [
                'category_name' => 'UI/UX Design',
                'title' => 'Figma for UI Design',
                'description' => 'Create stunning user interfaces using Figma design tool.',
                'duration_days' => 25,
            ],
            [
                'category_name' => 'UI/UX Design',
                'title' => 'User Experience Design Principles',
                'description' => 'Learn UX research, wireframing, and prototyping techniques.',
                'duration_days' => 40,
            ],
            [
                'category_name' => 'Cybersecurity',
                'title' => 'Ethical Hacking Basics',
                'description' => 'Learn penetration testing and security assessment techniques.',
                'duration_days' => 60,
            ],
            [
                'category_name' => 'Cybersecurity',
                'title' => 'Network Security Fundamentals',
                'description' => 'Master network security concepts and best practices.',
                'duration_days' => 50,
            ],
            [
                'category_name' => 'Game Development',
                'title' => 'Unity Game Development',
                'description' => 'Create 2D and 3D games using Unity game engine.',
                'duration_days' => 75,
            ],
            [
                'category_name' => 'Programming Fundamentals',
                'title' => 'JavaScript from Zero to Hero',
                'description' => 'Master JavaScript programming from basics to advanced concepts.',
                'duration_days' => 50,
            ],
            [
                'category_name' => 'Programming Fundamentals',
                'title' => 'Python Programming Bootcamp',
                'description' => 'Learn Python programming from scratch with hands-on projects.',
                'duration_days' => 45,
            ],
            [
                'category_name' => 'Cloud Computing',
                'title' => 'AWS Certified Solutions Architect',
                'description' => 'Prepare for AWS certification and master cloud architecture.',
                'duration_days' => 65,
            ],
            [
                'category_name' => 'Cloud Computing',
                'title' => 'Google Cloud Platform Essentials',
                'description' => 'Learn to deploy and manage applications on Google Cloud.',
                'duration_days' => 55,
            ],
        ];

        foreach ($courses as $index => $courseData) {
            $category = Category::where('name', $courseData['category_name'])->first();
            $teacher = $teachers[$index % $teachers->count()];
            
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = $startDate->copy()->addDays($courseData['duration_days']);

            Course::create([
                'category_id' => $category->id,
                'teacher_id' => $teacher->id,
                'title' => $courseData['title'],
                'description' => $courseData['description'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_active' => true,
            ]);
        }
    }
}