<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'phone' => '0666000000',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_approved' => true,
            'is_banned' => false,
        ]);
    }
}
