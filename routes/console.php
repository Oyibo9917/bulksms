<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('app:scheduler-messages-command')
    ->everyThirtySeconds()
    ->everyTenSeconds()
    ->withoutOverlapping()
    ->onSuccess(function () {
        // Optional success callback
    })
    ->onFailure(function () {
        // Optional failure callback
    });


Schedule::command('app:birthday-messages-command')
    ->dailyAt('19:56')  // Runs at 9:00 AM every day
    ->withoutOverlapping()
    ->onSuccess(function () {
        // Optional success callback
    })
    ->onFailure(function () {
        // Optional failure callback
    });

Schedule::command('queue:work')
    ->dailyAt('17:00')
    ->withoutOverlapping()
    ->onSuccess(function () {
        // Optional success callback
    })
    ->onFailure(function () {
        // Optional failure callback
    });
