<?php

use Illuminate\Support\Facades\Route;
use Modules\Patients\Http\Controllers\PatientsController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [PatientsController::class, 'index'])
            ->middleware('permission:patients.view')
            ->name('index');

        Route::get('/create', [PatientsController::class, 'create'])
            ->middleware('permission:patients.create')
            ->name('create');

        Route::post('/', [PatientsController::class, 'store'])
            ->middleware('permission:patients.create')
            ->name('store');

        Route::get('/{patient}', [PatientsController::class, 'show'])
            ->middleware('permission:patients.view')
            ->name('show');

        Route::get('/{patient}/edit', [PatientsController::class, 'edit'])
            ->middleware('permission:patients.edit')
            ->name('edit');

        Route::put('/{patient}', [PatientsController::class, 'update'])
            ->middleware('permission:patients.edit')
            ->name('update');

        Route::delete('/{patient}', [PatientsController::class, 'destroy'])
            ->middleware('permission:patients.delete')
            ->name('destroy');
    });
});