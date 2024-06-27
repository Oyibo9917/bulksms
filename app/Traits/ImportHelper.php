<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use App\Traits\NotificationHelper;
use App\Models\Groups;
use App\Jobs\ProcessUploadJob;

trait ImportHelper
{
    use NotificationHelper;

    public function randColors($state)
    {
        $groupNames = \App\Models\Groups::all()->pluck('name')->toArray();

        $colors = [
            'primary', 
            'gray', 
            'success', 
            'warning', 
            'info'
        ];

        $groupColors = [];
        foreach ($groupNames as $groupName) {
            $groupColors[$groupName] = Arr::random($colors);
        }

        $colorFunction = function (string $state) use ($groupColors): string {
            return $groupColors[$state] ?? 'info';
        };
        
    }

    public function upload($data)
    {
        ProcessUploadJob::dispatch($data);

        $this->information('Processing!!...');
    }
}
