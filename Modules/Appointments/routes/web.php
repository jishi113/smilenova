<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\AppointmentsController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AppointmentsController::class, 'index'])
            ->middleware('permission:appointments.view')
            ->name('index');

        Route::get('/create', [AppointmentsController::class, 'create'])
            ->middleware('permission:appointments.create')
            ->name('create');

        Route::post('/', [AppointmentsController::class, 'store'])
            ->middleware('permission:appointments.create')
            ->name('store');

        Route::get('/calendar', [AppointmentsController::class, 'calendar'])
            ->middleware('permission:appointments.view')
            ->name('calendar');

        Route::get('/{appointment}', [AppointmentsController::class, 'show'])
            ->middleware('permission:appointments.view')
            ->name('show');

        Route::get('/{appointment}/edit', [AppointmentsController::class, 'edit'])
            ->middleware('permission:appointments.edit')
            ->name('edit');

        Route::put('/{appointment}', [AppointmentsController::class, 'update'])
            ->middleware('permission:appointments.edit')
            ->name('update');

        Route::delete('/{appointment}', [AppointmentsController::class, 'destroy'])
            ->middleware('permission:appointments.delete')
            ->name('destroy');

        Route::post('/{appointment}/status', [AppointmentsController::class, 'updateStatus'])
            ->middleware('permission:appointments.edit')
            ->name('status');
    });
});