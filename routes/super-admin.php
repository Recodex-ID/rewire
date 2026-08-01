<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::livewire('access-control', 'pages::super-admin.access-control')->name('access-control');
    Route::livewire('activity', 'pages::super-admin.activity')->name('activity');
});
