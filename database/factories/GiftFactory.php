<?php

namespace Database\Factories;

use App\Models\Gift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GiftFactory extends Factory
{
    protected $model = Gift::class;

    public function definition(): array
    {
        return [
            'creator_id' => User::factory(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'suggested_price' => $this->faker->randomFloat(2, 5, 150),
            'image_path' => null,
        ];
    }
}
