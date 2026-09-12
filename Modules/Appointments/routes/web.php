<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\AppointmentController;
use Modules\Appointments\Http\Controllers\CalendarController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('permission:appointments.view')->get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::middleware('permission:appointments.view')->get('/appointments/calendar', [CalendarController::class, 'index'])->name('appointments.calendar');
    Route::middleware('permission:appointments.create')->get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::middleware('permission:appointments.create')->get('/appointments/slots', [AppointmentController::class, 'getSlots'])->name('appointments.slots');
    Route::middleware('permission:appointments.create')->post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::middleware('permission:appointments.view')->get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::middleware('permission:appointments.edit')->patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::middleware('permission:patients.edit_medical_records')->post('/appointments/{appointment}/treatment', [AppointmentController::class, 'recordTreatment'])->name('appointments.treatment');
});