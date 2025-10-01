<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SingleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        User::truncate();
        
        // Create single user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => Hash::make('password123'),
        ]);
    }
}
