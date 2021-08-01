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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::resource('user', App\Http\Controllers\UserController::class);
Route::resource('customerservice', App\Http\Controllers\CustomerServiceController::class);
Route::resource('bookingtime', App\Http\Controllers\BookingTimeController::class);
Route::resource('sparepart', App\Http\Controllers\PartController::class);
Route::get('download-sparepart', [App\Http\Controllers\PartController::class, 'exportExcel'])->name('sparepartExcel');
Route::resource('service', App\Http\Controllers\ServiceController::class);
Route::get('download-service', [App\Http\Controllers\ServiceController::class, 'exportExcel'])->name('serviceExcel');
Route::get('test-bot', [App\Http\Controllers\BotController::class, 'index'])->name('bot');