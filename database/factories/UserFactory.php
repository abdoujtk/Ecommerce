<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->unique()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'seller',
            'is_approved' => true,
            'is_banned' => false,
            'remember_token' => Str::random(10),
        ];
    }
}