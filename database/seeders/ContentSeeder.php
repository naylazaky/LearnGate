<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Content::create([
            'course_id' => 1,
            'title' => 'Introduction to laravel',
            'content' => 'Laravel is a powerful PHP framework for web development. In this lesson, we will cover the basics.',
            'order' => 1,
        ]);
        
        Content::create([
            'course_id' => 1,
            'title' => 'Routing and Controllers',
            'content' => 'Learn how to define routes and create controllers in Laravel.',
            'order' => 2,
        ]);

        Content::create([
            'course_id' => 1,
            'title' => 'Database and Eloquent ORM',
            'content' => 'Understand how to work with databases using Laravel Eloquent ORM.',
            'order' => 3,
        ]);

        Content::create([
            'course_id' => 2,
            'title' => 'Introduction to React',
            'content' => 'React is a JavaScript Library for building user interfaces.',
            'order' => 1,
        ]);

        Content::create([
            'course_id' => 2,
            'title' => 'Components and Props',
            'content' => 'Learn how to create reuseable components in React.',
            'order' => 2,
        ]);

        Content::create([
            'course_id' => 3,
            'title' => 'Python Basics',
            'content' => 'Getting started with Python programming language.',
            'order' => 1,
        ]);
        Content::create([
            'course_id' => 3,
            'title' => 'Pandas Library',
            'content' => 'Introduction to Pandas for data manipulation.',
            'order' => 2,
        ]);

    }
}
