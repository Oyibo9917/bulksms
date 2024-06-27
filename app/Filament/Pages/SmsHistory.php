<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\SmsHistory as History;
use App\Models\Groups;

class SmsHistory extends Page
{
    public $histories;

    public function __construct()
    {
        $this->histories = History::orderBy('created_at', 'desc')
            ->take(100)
            ->get()
            ->toArray();
    }

    public function getGroup($id) : string 
    {
        return Groups::findOrFail($id)->name;
    }

    protected static ?string $navigationIcon = 'fas-timeline';

    protected static string $view = 'filament.pages.sms-history';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?string $navigationParentItem = 'Contacts';

    protected static ?int $navigationSort = 3;
}
