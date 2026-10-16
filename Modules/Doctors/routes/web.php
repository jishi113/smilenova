<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctors\Http\Controllers\DoctorsController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [DoctorsController::class, 'index'])->name('index');
        Route::get('/create', [DoctorsController::class, 'create'])->name('create');
        Route::post('/', [DoctorsController::class, 'store'])->name('store');
        Route::get('/{doctor}', [DoctorsController::class, 'show'])->name('show');
        Route::get('/{doctor}/edit', [DoctorsController::class, 'edit'])->name('edit');
        Route::put('/{doctor}', [DoctorsController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [DoctorsController::class, 'destroy'])->name('destroy');
    });
});