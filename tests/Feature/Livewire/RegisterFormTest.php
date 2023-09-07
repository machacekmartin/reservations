<?php

use App\Livewire\RegisterForm;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Livewire\livewire;

it('registers user with given credentials and role and logs him in', function () {
    Role::create(['name' => 'user']);
    $data = [
        'email' => fake()->email(),
        'name' => fake()->name(),
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    livewire(RegisterForm::class)
        ->fillForm($data)
        ->call('register')
        ->assertHasNoFormErrors()
        ->assertRedirect('/');

    $user = User::query()->first();

    expect($user)
        ->email->toBe($data['email'])
        ->name->toBe($data['name'])
        ->password->not->toBeNull()
        ->phone->toBeNull()
        ->avatar->toBeNull()
        ->hasRole('user')->toBeTrue();

    assertAuthenticatedAs($user);
});

it('does not register because of missing required fields', function () {
    Role::create(['name' => 'user']);

    livewire(RegisterForm::class)
        ->fillForm([])
        ->call('register')
        ->assertHasFormErrors([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

    expect(User::count())->toBe(0);
});

it('does not register because email is already taken', function () {
    Role::create(['name' => 'user']);

    $user = User::factory()->create();

    livewire(RegisterForm::class)
        ->fillForm([
            'email' => $user->email,
            'name' => fake()->name(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->call('register')
        ->assertHasFormErrors([
            'email' => 'unique',
        ]);

    expect(User::count())->toBe(1);
});

it('does not register because password is not matching', function () {
    Role::create(['name' => 'user']);

    livewire(RegisterForm::class)
        ->fillForm([
            'email' => fake()->email(),
            'name' => fake()->name(),
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ])
        ->call('register')
        ->assertHasFormErrors([
            'password' => 'confirmed',
        ]);

    expect(User::count())->toBe(0);
});
