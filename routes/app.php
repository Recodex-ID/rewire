<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::app.dashboard')->name('dashboard');

    Route::prefix('other')->name('other.')->group(function () {
        Route::livewire('docs', 'pages::app.other.docs')->name('docs');
    });

    Route::prefix('content-management')->name('content-management.')->group(function () {
        Route::livewire('blogs', 'pages::app.content-management.blogs')->name('blogs');
    });

    Route::middleware(['role:super-admin|admin'])->prefix('system')->name('system.')->group(function () {
        Route::livewire('settings', 'pages::app.system.settings')->name('settings');
        Route::livewire('users', 'pages::app.system.users')->name('users');
        Route::livewire('sitemap', 'pages::app.system.sitemap')->name('sitemap');
    });

    Route::redirect('settings', 'settings/profile');
    Route::livewire('settings/profile', 'pages::app.settings.profile')->name('profile.edit');
    Route::livewire('settings/security', 'pages::app.settings.security')
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit');
});
