<?php

use App\Filament\Admin\Resources\TableResource;
use App\Filament\Admin\Resources\TableResource\Pages\EditTable;
use App\Filament\Admin\Resources\TableResource\Pages\ListTables;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\Admin\Resources\UserResource\Pages\CreateUser;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Models\Table;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can render resource index page', function () {
    Role::create(['name' => 'admin']);

    actingAs(User::factory()->as('admin')->create())
        ->get(UserResource::getUrl('index'))
        ->assertSuccessful();
});

it('can render resource edit page', function () {
    Role::create(['name' => 'admin']);

    $user = User::factory()->create();

    actingAs(User::factory()->as('admin')->create())
        ->get(UserResource::getUrl('edit', ['record' => $user]))
        ->assertSuccessful();
});

it('can render resource create page', function () {
    Role::create(['name' => 'admin']);

    actingAs(User::factory()->as('admin')->create())
        ->get(UserResource::getUrl('create'))
        ->assertSuccessful();
});

it('sees records in index page', function () {
    Role::create(['name' => 'admin']);

    $users = User::factory(10)->create();

    livewire(ListUsers::class)
        ->assertCanSeeTableRecords($users);
});

it('sees edit form in edit page', function () {
    Role::create(['name' => 'admin']);

    $user = User::factory()->create();

    livewire(EditUser::class, ['record' => $user->id ])
        ->assertFormFieldExists('avatar')
        ->assertFormSet([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'email_verified_at' => $user->email_verified_at,
            'roles' => $user->roles->pluck('name')->toArray(),
        ]);
});

it('sees create form in create page', function () {
    Role::create(['name' => 'admin']);

    livewire(CreateUser::class)
        ->assertFormFieldExists('avatar')
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('email')
        ->assertFormFieldExists('password')
        ->assertFormFieldExists('phone')
        ->assertFormFieldExists('email_verified_at')
        ->assertFormFieldExists('roles');
});
