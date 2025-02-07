<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'fas-gears';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationGroup = 'CONFIGURATIONS';

}
