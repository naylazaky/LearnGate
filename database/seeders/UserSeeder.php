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

        User::create([
            'username' => 'teacher1',
            'email' => 'teacher1@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'teacher2',
            'email' => 'teacher2@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'is_active' => true,
        ]);
        
        User::create([
            'username' => 'student1',
            'email' => 'student1@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);
        
        User::create([
            'username' => 'student2',
            'email' => 'student@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);
    }
}
