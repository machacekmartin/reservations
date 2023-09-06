<?php

namespace App\Filament\Admin\Resources\TableResource\Pages;

use App\Filament\Admin\Resources\TableResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTables extends ListRecords
{
    protected static string $resource = TableResource::class;

    protected static string $view = 'filament.admin.resources.table-resource.pages.list-tables';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
