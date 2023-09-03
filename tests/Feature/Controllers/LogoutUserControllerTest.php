<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\post;

it('logs out current user and invalidates session and generates new session token and redirects to login page', function () {
    actingAs(User::factory()->create())
        ->session([
            '_token' => 'test-token',
            'test-key' => 'test-value',
        ]);

    post(route('logout'))
        ->assertRedirect(route('login'));

    expect(session()->token())
        ->not->toBeNull()
        ->not->toBe('test-token');

    expect(session()->get('test-key'))->toBeNull();

    assertGuest();
});
