<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\CMSController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('cms')->name('cms.')->group(function () {
        Route::get('/', [CMSController::class, 'index'])->name('index');
        Route::get('/pages', [CMSController::class, 'pages'])->name('pages.index');
        Route::get('/posts', [CMSController::class, 'posts'])->name('posts.index');
        Route::get('/testimonials', [CMSController::class, 'testimonials'])->name('testimonials.index');
        Route::get('/gallery', [CMSController::class, 'gallery'])->name('gallery.index');
    });
});