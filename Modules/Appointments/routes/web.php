<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\AppointmentsController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AppointmentsController::class, 'index'])->name('index');
        Route::get('/create', [AppointmentsController::class, 'create'])->name('create');
        Route::post('/', [AppointmentsController::class, 'store'])->name('store');
        Route::get('/calendar', [AppointmentsController::class, 'calendar'])->name('calendar');
        Route::get('/{appointment}', [AppointmentsController::class, 'show'])->name('show');
        Route::get('/{appointment}/edit', [AppointmentsController::class, 'edit'])->name('edit');
        Route::put('/{appointment}', [AppointmentsController::class, 'update'])->name('update');
        Route::delete('/{appointment}', [AppointmentsController::class, 'destroy'])->name('destroy');
    });
});