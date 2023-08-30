<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

it('allows access to filament admin panel to user with admin role', function () {
    Role::create(['name' => 'admin']);
    $user = User::factory()->as('admin')->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();
});

it('does not allow access to filament admin panel to user with role other than admin', function (string $role) {
    Role::create(['name' => $role]);
    $user = User::factory()->as($role)->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
})->with([
    ['role' => 'manager'],
    ['role' => 'user'],
    ['role' => 'customer'],
    ['role' => 'some-other-role'],
]);

it('does not allow access to filament admin panel to user with no role', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});
