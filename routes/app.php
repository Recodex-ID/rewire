<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::livewire('dashboard', 'pages::app.dashboard')->name('dashboard');
    Route::livewire('docs', 'pages::app.docs')->name('docs');

    Route::redirect('settings', 'settings/profile');

    Route::livewire('settings/profile', 'pages::app.settings.profile')->name('profile.edit');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('settings/security', 'pages::app.settings.security')
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::livewire('app/landing-page', 'pages::app.landing-page')->name('app.landing-page.edit');
    Route::livewire('app/settings', 'pages::app.settings')->name('app.settings.edit');
    Route::livewire('app/users', 'pages::app.users')->name('app.users.index');
    Route::livewire('app/activity', 'pages::app.activity')->name('app.activity.index');
});
