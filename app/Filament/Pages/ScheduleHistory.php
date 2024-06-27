<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\ScheduleHistory as History;

class ScheduleHistory extends Page
{
    public $scheduleHistories;

    public function __construct()
    {
        $this->scheduleHistories = History::orderBy('created_at', 'desc')->take(20)->get()->toArray();
    }

    protected static ?string $navigationIcon = 'fas-timeline';

    protected static string $view = 'filament.pages.schedule-history';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?string $navigationParentItem = 'Schedule';
}
