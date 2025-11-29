<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'password' => Hash::make('admin@admin.com')

            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'role' => 'user',
                'password' => Hash::make('user@user.com')
            ]
        ]);
    }
}
