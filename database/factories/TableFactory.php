<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label' => $this->faker->randomLetter() . $this->faker->randomLetter(),
            'available' => $this->faker->boolean(80),
            'capacity' => $this->faker->numberBetween(1, 10),
            'dimensions' => [
                'width' => $this->faker->numberBetween(150, 250),
                'height' => $this->faker->numberBetween(150, 250),
                'x' => $this->faker->numberBetween(1, 600),
                'y' => $this->faker->numberBetween(1, 300),
            ],
        ];
    }
}
