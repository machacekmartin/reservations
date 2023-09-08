<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BasePage;
use Illuminate\Contracts\Support\Htmlable;

class Interactive extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $view = 'filament.admin.pages.interactive';

    public static function getNavigationLabel(): string
    {
        return 'Current table reservations';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Interactive';
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }
}
