<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => [
                'ar' => $this->faker->sentence(3),
                'en' => $this->faker->sentence(3),
            ],
            'content' => [
                'ar' => $this->faker->paragraph(3),
                'en' => $this->faker->paragraph(3),
            ],
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
