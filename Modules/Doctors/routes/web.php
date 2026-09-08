<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctors\Http\Controllers\DoctorController;
use Modules\Doctors\Http\Controllers\ScheduleController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('permission:doctors.view')->get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::middleware('permission:doctors.create')->get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::middleware('permission:doctors.create')->post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::middleware('permission:doctors.view')->get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    Route::middleware('permission:doctors.edit')->get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::middleware('permission:doctors.edit')->put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');

    Route::middleware('permission:doctors.edit')->get('/doctors/{doctor}/schedules', [ScheduleController::class, 'index'])->name('doctors.schedules.index');
    Route::middleware('permission:doctors.edit')->post('/doctors/{doctor}/schedules', [ScheduleController::class, 'bulkSave'])->name('doctors.schedules.save');
});