<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Matematika',
                'IPA',
                'IPS',
                'Bahasa Indonesia',
                'Bahasa Inggris'
            ]),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
