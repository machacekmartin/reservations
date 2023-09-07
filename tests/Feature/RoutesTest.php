<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('visits login page', function () {
    get(route('login'))
        ->assertOk();
});

it('redirects from login page because user is logged in', function () {
    actingAs(User::factory()->create())
        ->get(route('login'))
        ->assertRedirectToRoute('reservations');
});

it('visits register page', function () {
    get(route('register'))
        ->assertOk();
});

it('redirects from register page because user is logged in', function () {
    actingAs(User::factory()->create())
        ->get(route('register'))
        ->assertRedirectToRoute('reservations');
});

it('visits reservations page', function () {
    actingAs(User::factory()->create())
        ->get(route('reservations'))
        ->assertOk();
});

it('redirects from reservations page because user is not logged in', function () {
    get(route('reservations'))
        ->assertRedirectToRoute('login');
});

it('visits account edit page', function () {
    actingAs(User::factory()->create())
        ->get(route('edit-account'))
        ->assertOk();
});

it('redirects from account edit page because user is not logged in', function () {
    get(route('edit-account'))
        ->assertRedirectToRoute('login');
});
