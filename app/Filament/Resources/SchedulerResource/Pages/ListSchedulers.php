<?php

namespace App\Filament\Resources\SchedulerResource\Pages;

use App\Filament\Resources\SchedulerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchedulers extends ListRecords
{
    protected static string $resource = SchedulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New schedule'),
        ];
    }
}
