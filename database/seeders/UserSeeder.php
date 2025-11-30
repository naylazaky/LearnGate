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
            'approval_status' => 'approved',
        ]);

        User::create([
            'username' => 'Sasha Kalila',
            'email' => 'teacher1@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        User::create([
            'username' => 'Elia',
            'email' => 'teacher2@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);
        
        User::create([
            'username' => 'Naailah',
            'email' => 'student1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);
        
        User::create([
            'username' => 'Eryn',
            'email' => 'student2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        User::create([
            'username' => 'teacherpending',
            'email' => 'pending@learngate.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'is_active' => false,
            'approval_status' => 'pending',
        ]);
    }
}
