<?php

namespace App\Filament\Resources\SchedulerResource\Pages;

use App\Filament\Resources\SchedulerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScheduler extends EditRecord
{
    protected static string $resource = SchedulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['scheduled_contact'] = json_decode($data['scheduled_contact']);
    
        return $data;
    }
}
