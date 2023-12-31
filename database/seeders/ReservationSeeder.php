<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::factory()
            ->count(40)
            ->recycle(User::all())
            ->create()
            ->each(function (Reservation $reservation) {
                // Each reservation has 1-5 tables
                $tables = Table::inRandomOrder()->limit(fake()->numberBetween(1, 5))->get();
                $reservation->tables()->attach($tables);
            });
    }
}
