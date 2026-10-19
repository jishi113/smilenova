<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillingController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/', [BillingController::class, 'index'])
            ->middleware('permission:billing.view')
            ->name('index');

        Route::get('/invoices', [BillingController::class, 'index'])
            ->middleware('permission:billing.view')
            ->name('invoices.index');

        Route::get('/invoices/create', [BillingController::class, 'create'])
            ->middleware('permission:billing.create')
            ->name('invoices.create');

        Route::post('/invoices', [BillingController::class, 'store'])
            ->middleware('permission:billing.create')
            ->name('invoices.store');

        Route::get('/invoices/{invoice}', [BillingController::class, 'show'])
            ->middleware('permission:billing.view')
            ->name('invoices.show');

        Route::post('/invoices/{invoice}/payment', [BillingController::class, 'recordPayment'])
            ->middleware('permission:billing.payments')
            ->name('invoices.payment');

        Route::get('/services', [BillingController::class, 'services'])
            ->middleware('permission:billing.view')
            ->name('services.index');

        Route::get('/payments', [BillingController::class, 'payments'])
            ->middleware('permission:billing.view')
            ->name('payments.index');

        Route::get('/reports/revenue', [BillingController::class, 'revenueReport'])
            ->middleware('permission:billing.reports')
            ->name('reports.revenue');
    });
});