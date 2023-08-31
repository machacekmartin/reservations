<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'label' => $this->faker->word(),
            'address' => $this->faker->address(),
            'website' => $this->faker->url(),
        ];
    }
}
