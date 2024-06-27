<?php

namespace App\Filament\Resources\ContactsResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Contacts;
use App\Models\Groups;

class ContactResourceOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = [
        'md' => 4,
        'xl' => 5,
    ];


    protected function getStats(): array
    {
        $allGroups = Groups::all();
        $stats = [];

        foreach ($allGroups as $group) {
            $stats[] = Stat::make($group->name, Contacts::where('contact_group_id', $group->id)->count());
        }

        return $stats;
    }
   
}
