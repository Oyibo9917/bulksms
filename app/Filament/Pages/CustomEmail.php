<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CustomEmail extends Page
{
    protected static ?string $navigationIcon = 'fas-envelope-open-text';

    protected static string $view = 'filament.pages.custom-email';

    protected static ?string $navigationGroup = 'Email';

    protected ?string $heading = '';

}
