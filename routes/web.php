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

Route::get('install', [App\Http\Controllers\SettingController::class, 'install']);

Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');

Route::prefix('users')->group(function () {
   Route::get('show/{email}', [App\Http\Controllers\UserController::class, 'show']); 
   Route::put('update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
});

Route::prefix('orders')->group(function () {
   Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
   Route::get('create/{id}', [App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
   Route::post('store', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
   Route::get('show/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show'); 
   Route::get('payment-response/{reference}', [App\Http\Controllers\OrderController::class, 'payment_response'])->name('orders.payment-response'); 
 });

