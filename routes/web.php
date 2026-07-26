<?php

use App\Models\LandingPageSection;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        'sections' => LandingPageSection::query()->get()->keyBy('key'),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/admin.php';
