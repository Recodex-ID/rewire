<?php

use Illuminate\Support\Carbon;

test('Carbon locale is synced with the configured app locale at boot', function () {
    expect(Carbon::getLocale())->toBe(config('app.locale'));
});

test('translatedFormat renders dates in the requested locale', function () {
    $originalLocale = Carbon::getLocale();

    Carbon::setLocale('id');

    $date = Carbon::create(2026, 7, 26);

    expect($date->translatedFormat('l, j F Y'))->toBe('Minggu, 26 Juli 2026');

    Carbon::setLocale($originalLocale);
});
