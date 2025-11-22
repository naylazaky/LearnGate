<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Learn to build modern web applications using the latest technologies and frameworks.'
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Master mobile app development for iOS and Android platforms.'
            ],
            [
                'name' => 'Data Science',
                'description' => 'Explore data analysis, machine learning, and artificial intelligence.'
            ],
            [
                'name' => 'Database Management',
                'description' => 'Learn database design, SQL, and database administration.'
            ],
            [
                'name' => 'DevOps',
                'description' => 'Master continuous integration, deployment, and cloud infrastructure.'
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Create beautiful and user-friendly interfaces and experiences.'
            ],
            [
                'name' => 'Cybersecurity',
                'description' => 'Learn to protect systems, networks, and data from cyber threats.'
            ],
            [
                'name' => 'Game Development',
                'description' => 'Create interactive games using popular game engines and frameworks.'
            ],
            [
                'name' => 'Programming Fundamentals',
                'description' => 'Master the basics of programming and computer science concepts.'
            ],
            [
                'name' => 'Cloud Computing',
                'description' => 'Learn cloud platforms like AWS, Azure, and Google Cloud.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}