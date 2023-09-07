<?php

use App\Enums\ReservationStatus;
use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Pages\CreateReservation;
use App\Filament\Admin\Resources\ReservationResource\Pages\EditReservation;
use App\Filament\Admin\Resources\ReservationResource\Pages\ListReservations;
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

it('edits record with form on edit page', function () {
    Role::create(['name' => 'admin']);

    $user = User::factory()->create();
    $reservation = Reservation::factory()->create(['created_at' => '2021-01-01 00:00']);
    $tables = Table::factory(3)->create();

    livewire(EditReservation::class, ['record' => $reservation->id])
        ->assertFormFieldExists('tables')
        ->assertFormSet([
            'user_id' => $reservation->user->id,
            'guest_count' => $reservation->guest_count,
            'note' => $reservation->note,
            'status' => $reservation->status->value,
            'tables' => [],
            'created_at' => $reservation->created_at,
            'start_at' => $reservation->start_at?->format('Y-m-d H:i'),
            'end_at' => $reservation->end_at?->format('Y-m-d H:i'),
            'remind_at' => $reservation->remind_at?->format('Y-m-d H:i'),
            'arrived_at' => $reservation->arrived_at?->format('Y-m-d H:i'),
            'canceled_at' => $reservation->canceled_at?->format('Y-m-d H:i'),
        ])
        ->fillForm([
            'user_id' => $user->id,
            'guest_count' => 5,
            'note' => 'Test note',
            'status' => ReservationStatus::FULFILLED,
            'tables' => $tables->pluck('id')->toArray(),
            'created_at' => '2021-01-01 05:00',
            'start_at' => '2021-01-01 12:00',
            'end_at' => '2021-01-01 13:00',
            'remind_at' => '2021-01-01 11:00',
            'arrived_at' => '2021-01-01 12:00',
            'canceled_at' => '2021-01-01 20:00',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($reservation->fresh())
        ->user_id->toBe($user->id)
        ->guest_count->toBe(5)
        ->note->toBe('Test note')
        ->status->toBe(ReservationStatus::FULFILLED)
        ->created_at->format('Y-m-d H:i')->toBe('2021-01-01 00:00') // disabled
        ->start_at->format('Y-m-d H:i')->toBe('2021-01-01 12:00')
        ->end_at->format('Y-m-d H:i')->toBe('2021-01-01 13:00')
        ->remind_at->format('Y-m-d H:i')->toBe('2021-01-01 11:00')
        ->arrived_at->format('Y-m-d H:i')->toBe('2021-01-01 12:00')
        ->canceled_at->format('Y-m-d H:i')->toBe('2021-01-01 20:00')
        ->tables->toHaveCount(3);
});

it('sees create form in create page', function () {
    Role::create(['name' => 'admin']);

    livewire(CreateReservation::class)
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
