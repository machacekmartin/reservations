<?php

namespace Database\Factories;

use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('-1 month', '+1 month');

        return [
            'start_at' => $startAt,
            'end_at' => Carbon::instance($startAt)->addSeconds($this->faker->numberBetween(1800, 10800)),
            'remind_at' => Carbon::instance($startAt)->subSeconds($this->faker->numberBetween(900, 7200)),
            'canceled_at' => Carbon::instance($startAt)->subSeconds($this->faker->numberBetween(600, 10800)),
            'guest_count' => $this->faker->numberBetween(1, 10),
            'fulfilled' => $this->faker->boolean(30),
            'note' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
