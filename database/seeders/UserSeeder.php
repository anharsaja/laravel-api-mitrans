<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'), // Password: password
            'role' => 'admin', // Role admin
        ]);

        // Regular User
        User::create([
            'name' => 'Reguler User',
            'email' => 'user@user.com',
            'password' => Hash::make('user'), // Password: password
            'role' => 'user', // Default role user
        ]);
    }
}
