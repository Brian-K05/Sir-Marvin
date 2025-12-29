<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Generate a strong password: 16 characters with mixed case, numbers, and symbols
        $strongPassword = 'Admin@2024!Secure#';
        
        Admin::updateOrCreate(
            ['email' => 'marvnbuena@gmail.com'],
            [
                'name' => 'Marvin Dominic B. Buena',
                'password' => Hash::make($strongPassword),
                'email_verified_at' => now(),
            ]
        );
    }
}
