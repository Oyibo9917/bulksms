<?php

namespace App\Filament\Pages;
use App\Models\Contacts;
use App\Models\Groups;

use Filament\Pages\Page;

class TodayBirthday extends Page
{
    public $todayBirthdays;

    public function __construct()
    {
        $this->todayBirthdays = Contacts::whereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", [now()->format('m-d')])->get()->toArray();;
    }

    public function getGroup($id) : string 
    {
        return Groups::findOrFail($id)->name;
    }

    protected static ?string $navigationIcon = 'fas-cake-candles';

    protected static string $view = 'filament.pages.today-birthday';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?string $navigationParentItem = 'Contacts';

    protected static ?int $navigationSort = 1;


}
