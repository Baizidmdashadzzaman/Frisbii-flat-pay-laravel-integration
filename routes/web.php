<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function() {
    return view('payment');
});

Route::get('/pay', [PaymentController::class, 'pay'])->name('pay');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/frisbii/webhook', [PaymentController::class, 'webhook']);