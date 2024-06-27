<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\UploadStatus;

class FileUploadStatus extends Page
{
    public $statuses;

    public function __construct()
    {
        $this->statuses = UploadStatus::all()->toArray();
    }

    protected static ?string $navigationIcon = 'fas-upload';

    protected static string $view = 'filament.pages.file-upload-status';

    protected static ?string $navigationGroup = 'MENU ITEMS';

    protected static ?string $navigationParentItem = 'Contacts';

    protected static ?int $navigationSort = 2;
}
