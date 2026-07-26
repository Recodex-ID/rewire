<?php

use Illuminate\Support\Carbon;

test('dates translate according to the configured app locale', function () {
    expect(config('app.locale'))->toBe('id');

    $date = Carbon::create(2026, 7, 26);

    expect($date->translatedFormat('l, j F Y'))->toBe('Minggu, 26 Juli 2026');
});
