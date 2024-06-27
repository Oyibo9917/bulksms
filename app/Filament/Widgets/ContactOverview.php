<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Contacts;
use App\Models\Scheduler;
use DateTime;
use App\Traits\SMSManager;

class ContactOverview extends BaseWidget
{
    use SMSManager;

    protected function getStats(): array
    {
        $message = '';
        $timeRemaining = new DateTime('7:0:00');
        $currentTime = new DateTime();

        if ($currentTime > $timeRemaining) {
            $message = "Messages delivered ";
        } else {
            $isPass = true;
            $timeDiff = $timeRemaining->diff($currentTime);
            $message = 'Notified in ' . $timeDiff->format('%Hhrs-%Imin-%Ssec');
        }

        $bal = $this->checkSMSBalance();
        $bal_mes = $bal <= 100 ? 'Please fund your account' : '';

        return [
            Stat::make('Wallet Balance', '₦' . $bal)
                ->description($bal_mes)
                ->color('danger')
                ->descriptionIcon('fas-triangle-exclamation'),
            Stat::make('All Contacts', Contacts::all()->count()),
            Stat::make('Today Birthday', Contacts::whereMonth('birth_date', now()->month)->whereDay('birth_date', now()->day)->count())
                ->description($message)
                ->descriptionIcon('fas-cake-candles')
                ->color('success'),
            Stat::make('Schedules', Scheduler::whereDate('scheduled_at', now())->count())
                ->description('Today schedules ')
                ->descriptionIcon('fas-calendar-days')
                ->color('success'),
        ];
    }
}
