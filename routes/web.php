<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/blog', 'blogs')->name('blogs');
    Route::get('/blog/{slug}', 'blogDetail')->name('blog.detail');
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap');
});

require __DIR__.'/super-admin.php';
require __DIR__.'/app.php';
