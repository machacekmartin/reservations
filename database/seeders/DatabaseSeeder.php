<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            TableSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
