<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Enforces the audit-log retention promised in the privacy policy (config/activitylog.php: clean_after_days).
Schedule::command('activitylog:clean')->daily();
