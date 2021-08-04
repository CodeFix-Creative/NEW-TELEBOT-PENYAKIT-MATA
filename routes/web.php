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
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/webhook', [App\Http\Controllers\TelegramController::class, 'webhook']);

Route::get('/dev/part', [App\Http\Controllers\DevController::class, 'part']);
Route::get('/test-bot', [App\Http\Controllers\BotController::class, 'index'])->name('bot');

Route::prefix('admin')->middleware('auth')->group(function(){

   // admin
   Route::resource('user', App\Http\Controllers\UserController::class);

   // Customer Service
   Route::resource('customerservice', App\Http\Controllers\CustomerServiceController::class);

   // Booking Time
   Route::resource('bookingtime', App\Http\Controllers\BookingTimeController::class);

   // Spare Part
   Route::resource('sparepart', App\Http\Controllers\PartController::class);
   Route::get('download-sparepart', [App\Http\Controllers\PartController::class, 'exportExcel'])->name('sparepartExcel');

   // Service
   Route::resource('service', App\Http\Controllers\ServiceController::class);
   Route::get('download-service', [App\Http\Controllers\ServiceController::class, 'exportExcel'])->name('serviceExcel');

   // Booking List
   Route::resource('bookingList', App\Http\Controllers\BookingController::class);

   Route::get('change-password' ,  [App\Http\Controllers\UserController::class, 'index'])->name('change_password.index');
   Route::post('change-password' ,  [App\Http\Controllers\UserController::class, 'update'])->name('change_password.update');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
