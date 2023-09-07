<?php

use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Pages\CreateReservation;
use App\Filament\Admin\Resources\ReservationResource\Pages\EditReservation;
use App\Filament\Admin\Resources\ReservationResource\Pages\ListReservations;
use App\Filament\Admin\Resources\TableResource;
use App\Filament\Admin\Resources\TableResource\Pages\EditTable;
use App\Filament\Admin\Resources\TableResource\Pages\ListTables;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can render resource index page', function () {
    Role::create(['name' => 'admin']);

    actingAs(User::factory()->as('admin')->create())
        ->get(ReservationResource::getUrl('index'))
        ->assertSuccessful();
});

it('can render resource edit page', function () {
    Role::create(['name' => 'admin']);

    $reservation = Reservation::factory()->create();

    actingAs(User::factory()->as('admin')->create())
        ->get(ReservationResource::getUrl('edit', ['record' => $reservation]))
        ->assertSuccessful();
});

it('can render resource create page', function () {
    Role::create(['name' => 'admin']);

    actingAs(User::factory()->as('admin')->create())
        ->get(ReservationResource::getUrl('create'))
        ->assertSuccessful();
});

it('sees records in index page', function () {
    Role::create(['name' => 'admin']);

    $reservations = Reservation::factory(10)->create();

    livewire(ListReservations::class)
        ->assertCanSeeTableRecords($reservations);
});

it('sees edit form in edit page', function () {
    Role::create(['name' => 'admin']);

    $reservation = Reservation::factory()->create();

    livewire(EditReservation::class, ['record' => $reservation->id ])
        ->assertFormFieldExists('tables')
        ->assertFormSet([
            'user_id' => $reservation->user->id,
            'guest_count' => $reservation->guest_count,
            'note' => $reservation->note,
            'status' => $reservation->status->value,
            'created_at' => $reservation->created_at,
            'start_at' => $reservation->start_at?->format('Y-m-d H:i'),
            'end_at' => $reservation->end_at?->format('Y-m-d H:i'),
            'remind_at' => $reservation->remind_at?->format('Y-m-d H:i'),
            'arrived_at' => $reservation->arrived_at?->format('Y-m-d H:i'),
            'canceled_at' => $reservation->canceled_at?->format('Y-m-d H:i'),
        ]);
});

it('sees create form in create page', function () {
    Role::create(['name' => 'admin']);

    livewire(CreateReservation::class,)
        ->assertFormFieldExists('user_id')
        ->assertFormFieldExists('guest_count')
        ->assertFormFieldExists('note')
        ->assertFormFieldExists('status')
        ->assertFormFieldExists('created_at')
        ->assertFormFieldExists('start_at')
        ->assertFormFieldExists('end_at')
        ->assertFormFieldExists('remind_at')
        ->assertFormFieldExists('arrived_at')
        ->assertFormFieldExists('canceled_at');
});
