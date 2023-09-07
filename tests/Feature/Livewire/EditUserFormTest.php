<?php

use App\Livewire\EditUserForm;
use App\Models\User;

use function Pest\Livewire\livewire;

it('edits user with given details', function () {
    $user = User::factory()->create();

    livewire(EditUserForm::class, ['user' => $user])
        ->assertFormSet([
            'name' => $user->name,
            'phone' => $user->phone,
        ])
        ->fillForm([
            'email' => 'disabled@email.test',
            'name' => 'Test Name',
            'phone' => '+420777555666'
        ])
        ->call('submit')
        ->assertHasNoFormErrors();

    expect($user->fresh())
        ->email->not->toBe('disabled@email.test') // email is disabled
        ->name->toBe('Test Name')
        ->phone->toBe('+420777555666');
});

it('cancels before saving edit', function () {
    $user = User::factory()->create();

    livewire(EditUserForm::class, ['user' => $user])
        ->assertFormSet([
            'name' => $user->name,
            'phone' => $user->phone,
        ])
        ->fillForm([
            'email' => 'disabled@email.test',
            'name' => 'Test Name',
            'phone' => '+420777555666'
        ])
        ->call('cancel')
        ->assertFormSet([
            'email' => $user->email,
            'name' => $user->name,
            'phone' => $user->phone,
        ])
        ->assertHasNoFormErrors();
});
