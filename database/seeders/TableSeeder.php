<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        Table::factory()
            ->count(20)
            ->recycle(Restaurant::all())
            ->create();
    }
}
