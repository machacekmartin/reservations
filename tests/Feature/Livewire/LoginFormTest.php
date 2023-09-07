<?php

use App\Livewire\LoginForm;
use App\Models\User;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['password' => 'test-password']);
});

it('logs user in', function () {
    livewire(LoginForm::class)
        ->fillForm([
            'email' => $this->user->email,
            'password' => 'test-password',
            'remember' => true,
        ])
        ->call('login')
        ->assertHasNoFormErrors()
        ->assertRedirect('/');

    assertAuthenticatedAs($this->user);
});

it('does not log user in because of missing required fields', function () {
    livewire(LoginForm::class)
        ->call('login')
        ->assertHasFormErrors([
            'email' => 'required',
            'password' => 'required',
        ]);

    assertGuest();
});

it('does not log user in because email input is not valid email', function () {
    livewire(LoginForm::class)
        ->fillForm([
            'email' => 'invalid-email',
            'password' => 'test-password',
        ])
        ->call('login')
        ->assertHasFormErrors([
            'email' => 'email',
        ]);

    assertGuest();
});

it('does not log user in because the combination does not exist', function () {
    livewire(LoginForm::class)
        ->fillForm([
            'email' => 'non-existent-email@email.test',
            'password' => 'test-password',
        ])
        ->call('login')
        ->assertHasFormErrors([
            'email',
        ]);

    assertGuest();
});
