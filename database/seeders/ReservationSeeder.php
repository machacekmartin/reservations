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
        $reservations = Reservation::factory()
            ->count(40)
            ->recycle(User::all())
            ->create();

        // Fills table_reservation junction table. Doesnt account for overlaping reservations
        $reservations->each(function (Reservation $reservation) {
            $reservation->tables()->attach(Table::inRandomOrder()->limit(5)->get());
        });
    }
}
