<?php

use App\Filament\Admin\Pages\Interactive;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;

it('can render interactive page', function () {
    Role::create(['name' => 'admin']);

    actingAs(User::factory()->as('admin')->create())
        ->get(Interactive::getUrl())
        ->assertSuccessful();
});
