<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('step1');
});

Route::prefix('users')->group(function () {
   Route::get('show/{email}', [App\Http\Controllers\UserController::class, 'show']); 
});

Route::prefix('orders')->group(function () {
    Route::post('store', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('show/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show'); 
    Route::get('payment-response/{reference}', [App\Http\Controllers\OrderController::class, 'payment_response'])->name('orders.payment-response'); 
 });

