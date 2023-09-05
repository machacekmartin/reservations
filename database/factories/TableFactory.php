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
            'label' => $this->faker->word(),
            'available' => $this->faker->boolean(80),
            'capacity' => $this->faker->numberBetween(1, 10),
            'location' => [],
            'size' => [],
        ];
    }
}
