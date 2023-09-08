<?php

use App\Livewire\CreateReservation;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('creates new reservation', function () {
    $tables = Table::factory(3)->create();
    actingAs(User::factory()->create());

    $data = [
        'date' => now()->toDateString(),
        'start_at' => now()->addHours(1)->floorSecond(),
        'end_at' => now()->addHours(2)->floorSecond(),
        'remind_at' => 30,
        'guest_count' => 2,
        'note' => 'test-note',
    ];

    livewire(CreateReservation::class)
        ->fill(['selectedTables' => $tables->pluck('id')->toArray()])
        ->fillForm($data)
        ->call('submit')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    expect(Reservation::count())->toBe(1);

    expect(Reservation::first())
        ->start_at->toDateTimeString()->toBe($data['start_at']->toDateTimeString())
        ->end_at->toDateTimeString()->toBe($data['end_at']->toDateTimeString())
        ->remind_at->toDateTimeString()->toBe($data['start_at']->addMinutes($data['remind_at'])->toDateTimeString())
        ->guest_count->toBe($data['guest_count'])
        ->note->toBe($data['note'])
        ->user_id->toBe(auth()->user()->id)
        ->tables->toHaveCount(3)
        ->tables->pluck('id')->toArray()->toBe($tables->pluck('id')->toArray());
});

it('has by default disabled time fields', function () {
    actingAs(User::factory()->create());

    livewire(CreateReservation::class)
        ->assertFormFieldIsDisabled('start_at')
        ->assertFormFieldIsDisabled('end_at');
});

it('has by default enabled some fields', function () {
    actingAs(User::factory()->create());

    livewire(CreateReservation::class)
        ->assertFormFieldIsEnabled('date')
        ->assertFormFieldIsEnabled('remind_at')
        ->assertFormFieldIsEnabled('guest_count')
        ->assertFormFieldIsEnabled('note');
});

it('enables start_at input when date and table is selected', function () {
    actingAs(User::factory()->create());

    livewire(CreateReservation::class)
        ->fill(['selectedTables' => [Table::factory()->create()->id]])
        ->assertFormFieldIsDisabled('start_at')
        ->assertFormFieldIsDisabled('end_at')
        ->fillForm(['date' => now()->toDateString()])
        ->assertFormFieldIsEnabled('start_at')
        ->assertFormFieldIsDisabled('end_at');
});

it('enables end_at input when date and table and start_at is selected', function () {
    actingAs(User::factory()->create());

    livewire(CreateReservation::class)
        ->fill(['selectedTables' => [Table::factory()->create()->id]])
        ->fillForm(['date' => now()->toDateString()])
        ->assertFormFieldIsDisabled('end_at')
        ->fillForm(['start_at' => now()->addHours(1)->floorSecond()])
        ->assertFormFieldIsEnabled('end_at');
});
