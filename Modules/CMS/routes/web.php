<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\PageController;
use Modules\CMS\Http\Controllers\PostController;
use Modules\CMS\Http\Controllers\TestimonialController;
use Modules\CMS\Http\Controllers\GalleryController;

Route::middleware(['auth', 'verified', 'permission:cms.pages'])->group(function () {
    Route::get('/cms/pages', [PageController::class, 'index'])->name('cms.pages.index');
    Route::get('/cms/pages/create', [PageController::class, 'create'])->name('cms.pages.create');
    Route::post('/cms/pages', [PageController::class, 'store'])->name('cms.pages.store');
    Route::get('/cms/pages/{page}/edit', [PageController::class, 'edit'])->name('cms.pages.edit');
    Route::put('/cms/pages/{page}', [PageController::class, 'update'])->name('cms.pages.update');
    Route::delete('/cms/pages/{page}', [PageController::class, 'destroy'])->name('cms.pages.destroy');
});

Route::middleware(['auth', 'verified', 'permission:cms.posts'])->group(function () {
    Route::get('/cms/posts', [PostController::class, 'index'])->name('cms.posts.index');
    Route::get('/cms/posts/create', [PostController::class, 'create'])->name('cms.posts.create');
    Route::post('/cms/posts', [PostController::class, 'store'])->name('cms.posts.store');
    Route::patch('/cms/posts/{post}/toggle', [PostController::class, 'togglePublish'])->name('cms.posts.toggle');
});

Route::middleware(['auth', 'verified', 'permission:cms.testimonials'])->group(function () {
    Route::get('/cms/testimonials', [TestimonialController::class, 'index'])->name('cms.testimonials.index');
    Route::post('/cms/testimonials', [TestimonialController::class, 'store'])->name('cms.testimonials.store');
    Route::delete('/cms/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('cms.testimonials.destroy');
});

Route::middleware(['auth', 'verified', 'permission:cms.gallery'])->group(function () {
    Route::get('/cms/gallery', [GalleryController::class, 'index'])->name('cms.gallery.index');
    Route::post('/cms/gallery', [GalleryController::class, 'store'])->name('cms.gallery.store');
    Route::delete('/cms/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('cms.gallery.destroy');
});