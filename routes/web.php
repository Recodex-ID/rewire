<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/blog', 'blogIndex')->name('blog.index');
    Route::get('/blog/{slug}', 'blogShow')->name('blog.show');
});

require __DIR__.'/app.php';
