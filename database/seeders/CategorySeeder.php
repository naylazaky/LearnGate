<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Grammar',
            'description' => 'Master English grammar rules and sentence structures',
        ]);

        Category::create([
            'name' => 'Speaking & Conversation',
            'description' => 'Improve your English speaking and conversation skills',
        ]);

        Category::create([
            'name' => 'Vocabulary & Idioms',
            'description' => 'Expand your English vocabulary and learn common idioms',
        ]);

        Category::create([
            'name' => 'Writing',
            'description' => 'Learn to write effectively in English for various purposes',
        ]);

        Category::create([
            'name' => 'Listening & Pronunciation',
            'description' => 'Enhance your listening comprehension and pronunciation skills',
        ]);

        Category::create([
            'name' => 'Business English',
            'description' => 'Professional English for workplace communication and career advancement',
        ]);
    }
}