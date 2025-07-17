<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SipController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\InvoicePaymentController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('invoices/process-payment', [InvoicePaymentController::class, 'process'])->name('invoices.process-payment');

Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::apiResource('sips', SipController::class)->only('index', 'show', 'store');
    Route::patch('sips/{sip}/cancel', [SipController::class, 'cancel']);
    Route::apiResource('invoices', InvoiceController::class)->only(['index', 'show']);
});
 