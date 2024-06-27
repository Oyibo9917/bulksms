<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TodaySchedules extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.today-schedules';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?string $navigationParentItem = 'Schedulers';
}
