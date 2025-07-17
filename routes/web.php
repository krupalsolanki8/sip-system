<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicePaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SipController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('sips')->name('sips.')->group(function () {
        Route::resource('/', SipController::class);
        Route::patch('{sip}/cancel', [SipController::class, 'cancel'])->name('cancel');
        Route::get('datatable', [SipController::class, 'datatable'])->name('datatable');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('datatable', [InvoiceController::class, 'datatable'])->name('datatable');
        Route::get('{invoice}/download', [InvoiceController::class, 'download'])->name('download');
        Route::post('process-payment', [InvoicePaymentController::class, 'process'])->name('process-payment');
    });
});

require __DIR__ . '/auth.php';
