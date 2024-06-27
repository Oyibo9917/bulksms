<?php

namespace App\Filament\Resources\SchedulerResource\Pages;

use App\Filament\Resources\SchedulerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateScheduler extends CreateRecord
{
    protected static string $resource = SchedulerResource::class;

    protected ?string $heading = 'Create Schedule';

}
