<?php

use Illuminate\Database\Eloquent\Factories\Factory;

class GiftFactory extends Factory
{
    protected $model = \App\Models\Gift::class;

    public function definition()
    {
        return [
            'creator_id' => \App\Models\User::factory(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'suggested_price' => $this->faker->randomFloat(2,5,150),
            'image_path' => null,
        ];
    }
}
