<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::app.dashboard')->name('dashboard');
    Route::livewire('docs', 'pages::app.docs')->name('docs');

    Route::prefix('content-management')->name('content-management.')->group(function () {
        Route::livewire('blogs', 'pages::app.content-management.blogs')->name('blogs');
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::livewire('settings', 'pages::app.admin.settings')->name('settings');
        Route::livewire('users', 'pages::app.admin.users')->name('users');
        Route::livewire('activity', 'pages::app.admin.activity')->name('activity');
    });

    Route::redirect('settings', 'settings/profile');
    Route::livewire('settings/profile', 'pages::app.settings.profile')->name('profile.edit');
    Route::livewire('settings/security', 'pages::app.settings.security')
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit');
});
