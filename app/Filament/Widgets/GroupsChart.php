<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Groups;
use App\Models\Contacts;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class GroupsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $startDate = now()->subYears(5)->startOfYear();
        $endDate = now();

        $results = Contacts::join('groups', 'contacts.contact_group_id', '=', 'groups.id')
            ->selectRaw('groups.name as group_name, COUNT(contacts.id) as count')
            ->groupBy('groups.name')
            ->whereBetween('contacts.created_at', [$startDate,$endDate])
            ->get();
            
        $groupNames = [];
        $countValues = [];
        
        foreach ($results as $result) {
            $groupNames[] = str_replace('_', ' ', $result->group_name);
            $countValues[] = $result->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Groups',
                    'data' => $countValues,
                    'borderColor' => '#00FF00',
                ],
            ],
            'labels' => $groupNames,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
