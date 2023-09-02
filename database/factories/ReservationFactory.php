<?php

namespace Database\Factories;

use App\Enums\ReservationStatus;
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
        $startAt = $this->faker->dateTimeBetween('+1 hour', '+2 hours');

        return [
            'start_at' => $startAt,
            'end_at' => Carbon::instance($startAt)->addSeconds($this->faker->numberBetween(1800, 10800)),
            'remind_at' => Carbon::instance($startAt)->subSeconds($this->faker->numberBetween(900, 7200)),
            'arrived_at' => null,
            'canceled_at' => null,
            'guest_count' => $this->faker->numberBetween(1, 10),
            'note' => $this->faker->sentence(),
            'reminded' => false,
            'status' => ReservationStatus::PENDING,
            'user_id' => User::factory(),
        ];
    }

    public function late(): self
    {
        return $this->state([
            'status' => ReservationStatus::LATE,
            'start_at' => now()->subMinutes(10),
        ]);
    }

    public function canceled(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReservationStatus::CANCELED,
            'canceled_at' => Carbon::instance($attributes['start_at'])->subMinutes(10), /** @phpstan-ignore-line */
        ]);
    }

    public function fulfilled(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReservationStatus::FULFILLED,
            'arrived_at' => Carbon::instance($attributes['start_at'])->subMinutes(10), /** @phpstan-ignore-line */
        ]);
    }

    public function missed(): self
    {
        return $this->state([
            'status' => ReservationStatus::MISSED,
        ]);
    }

    public function withoutReminder(): self
    {
        return $this->state([
            'remind_at' => null,
        ]);
    }
}
