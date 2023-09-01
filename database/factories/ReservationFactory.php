<?php

namespace Database\Factories;

use App\Models\Restaurant;
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
        $startAt = $this->faker->dateTimeBetween('-1 day', '+1 day');

        return [
            'start_at' => $startAt,
            'end_at' => Carbon::instance($startAt)->addSeconds($this->faker->numberBetween(1800, 10800)),
            'remind_at' => Carbon::instance($startAt)->subSeconds($this->faker->numberBetween(900, 7200)),
            'guest_count' => $this->faker->numberBetween(1, 10),
            'note' => $this->faker->sentence(),
            'user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
        ];
    }

    public function canceled(): self
    {
        return $this->state([
            'canceled_at' => $this->faker->dateTimeBetween('-1 day', '+1 day'),
        ]);
    }

    public function arrived(): self
    {
        return $this->state([
            'arrived_at' => $this->faker->dateTimeBetween('-1 day', '+1 day'),
        ]);
    }

    public function fulfilled(): self
    {
        return $this->state([
            'fulfilled' => true,
        ]);
    }

    public function unfulfilled(): self
    {
        return $this->state([
            'fulfilled' => false,
        ]);
    }

    public function withoutReminder(): self
    {
        return $this->state([
            'remind_at' => null,
        ]);
    }
}
