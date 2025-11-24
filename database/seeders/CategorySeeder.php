<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Web Development',
            'description' => 'Learn to build modern web applications',
        ]);

        Category::create([
            'name' => 'Data Science',
            'description' => 'Master data analysis and machine learning',
        ]);

        Category::create([
            'name' => 'UI/UX Design',
            'description' => 'Create beautiful and user-friendly interfaces',
        ]);
    }
}
