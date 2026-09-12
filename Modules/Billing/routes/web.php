<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\InvoiceController;
use Modules\Billing\Http\Controllers\ReportController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('permission:billing.view')->get('/billing/invoices', [InvoiceController::class, 'index'])->name('billing.invoices.index');
    Route::middleware('permission:billing.view')->get('/billing/invoices/{invoice}', [InvoiceController::class, 'show'])->name('billing.invoices.show');
    Route::middleware('permission:billing.create')->post('/billing/appointments/{appointment}/generate-invoice', [InvoiceController::class, 'generateFromAppointment'])->name('billing.generate');
    Route::middleware('permission:billing.payments')->post('/billing/invoices/{invoice}/payments', [InvoiceController::class, 'recordPayment'])->name('billing.payments.store');
    Route::middleware('permission:billing.reports')->get('/billing/reports/revenue', [ReportController::class, 'revenue'])->name('billing.reports.revenue');
});