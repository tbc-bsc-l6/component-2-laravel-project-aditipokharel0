<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'teacher1@example.com'],
            ['name' => 'Teacher One', 'password' => Hash::make('password'), 'role' => 'teacher']
        );

        User::updateOrCreate(
            ['email' => 'teacher2@example.com'],
            ['name' => 'Teacher Two', 'password' => Hash::make('password'), 'role' => 'teacher']
        );

        User::updateOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Student User', 'password' => Hash::make('password'), 'role' => 'student']
        );
    }
}

