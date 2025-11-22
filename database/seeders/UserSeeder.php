<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $teachers = [
            ['username' => 'teacher1', 'email' => 'teacher1@learngate.com'],
            ['username' => 'teacher2', 'email' => 'teacher2@learngate.com'],
            ['username' => 'teacher3', 'email' => 'teacher3@learngate.com'],
        ];

        foreach ($teachers as $teacher) {
            User::create([
                'username' => $teacher['username'],
                'email' => $teacher['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'is_active' => true,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            User::create ([
                'username' => 'student' . $i,
                'email' => 'student' . $i . '@learngate.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'is_active' => true,
            ]);
        }
    }
}