<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillingController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/', [BillingController::class, 'index'])->name('index');
        Route::get('/invoices', [BillingController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/create', [BillingController::class, 'create'])->name('invoices.create');
        Route::post('/invoices', [BillingController::class, 'store'])->name('invoices.store');
        Route::get('/invoices/{invoice}', [BillingController::class, 'show'])->name('invoices.show');
        Route::get('/services', [BillingController::class, 'services'])->name('services.index');
        Route::get('/payments', [BillingController::class, 'payments'])->name('payments.index');
        Route::get('/reports/revenue', [BillingController::class, 'revenueReport'])->name('reports.revenue');
    });
});