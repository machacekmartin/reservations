<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->as('admin')
            ->create();

        User::factory()
            ->as('user')
            ->count(10)
            ->create();
    }
}
