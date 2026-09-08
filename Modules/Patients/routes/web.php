<?php

use Illuminate\Support\Facades\Route;
use Modules\Patients\Http\Controllers\PatientController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('permission:patients.view')->get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::middleware('permission:patients.create')->get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::middleware('permission:patients.create')->post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::middleware('permission:patients.view')->get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::middleware('permission:patients.edit')->get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::middleware('permission:patients.edit')->put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::middleware('permission:patients.delete')->delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
});