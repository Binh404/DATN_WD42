<?php

use Illuminate\Console\Scheduling\Schedule as SchedulingSchedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

return function (SchedulingSchedule $schedule) {
    $schedule->command('capnhat:sodunghiphep')->everyMinute(); // ← đổi sang yearlyOn(1,1) khi deploy
};
