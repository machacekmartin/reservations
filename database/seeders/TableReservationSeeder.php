<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Database\Seeder;

class TableReservationSeeder extends Seeder
{
    public function run(): void
    {
        $tables = Table::factory()->count(10)->create();

        $reservations = Reservation::factory()->count(50)->create();

        // doesnt account for overlaping reservations
        $reservations->each(function (Reservation $reservation) use ($tables) {
            $reservation->tables()->attach($tables->random(5));
        });
    }
}
