<?php

namespace App\Traits;

use Filament\Notifications\Notification;

trait NotificationHelper
{
    public function success($message)
    {
        Notification::make()
            ->title($message)
            ->success()
            ->send();
    }

    public function failure($message)
    {
        Notification::make()
            ->title($message)
            ->danger()
            ->send();
    }

    public function warning($message)
    {
        Notification::make()
            ->title($message)
            ->warning()
            ->send();
    }

    public function information($message)
    {
        Notification::make()
            ->title($message)
            ->icon('fas-circle-info')
            ->iconColor('success')
            ->send();
    }
}
