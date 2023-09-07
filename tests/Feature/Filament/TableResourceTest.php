<?php

use App\Filament\Admin\Resources\TableResource;
use App\Filament\Admin\Resources\TableResource\Pages\EditTable;
use App\Filament\Admin\Resources\TableResource\Pages\ListTables;
use App\Models\Table;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can render resource index page', function () {
    Role::create(['name' => 'admin']);

    actingAs(User::factory()->as('admin')->create())
        ->get(TableResource::getUrl('index'))
        ->assertSuccessful();
});

it('can render resource edit page', function () {
    Role::create(['name' => 'admin']);

    $table = Table::factory()->create();

    actingAs(User::factory()->as('admin')->create())
        ->get(TableResource::getUrl('edit', ['record' => $table]))
        ->assertSuccessful();
});

it('sees records in index page', function () {
    Role::create(['name' => 'admin']);

    $tables = Table::factory(10)->create();

    livewire(ListTables::class)
        ->assertCanSeeTableRecords($tables);
});

it('sees edit form in edit page', function () {
    Role::create(['name' => 'admin']);

    $table = Table::factory()->create();

    livewire(EditTable::class, ['record' => $table->id ])
        ->assertFormSet([
            'label' => $table->label,
            'capacity' => $table->capacity,
            'available' => $table->available,
            'dimensions.width' => $table->dimensions->width,
            'dimensions.height' => $table->dimensions->height,
            'dimensions.x' => $table->dimensions->x,
            'dimensions.y' => $table->dimensions->y,
        ]);
});
