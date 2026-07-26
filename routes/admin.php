<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::livewire('admin/landing-page', 'pages::admin.landing-page')->name('admin.landing-page.edit');
    Route::livewire('admin/settings', 'pages::admin.settings')->name('admin.settings.edit');
});
