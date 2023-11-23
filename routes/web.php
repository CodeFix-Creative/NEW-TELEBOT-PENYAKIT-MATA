<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\PenyakitGejalaController;
use App\Http\Controllers\TelegramController;

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

Route::get('/webhook', [App\Http\Controllers\TelegramController::class, 'webhook']);

Route::get('/dev/part', [App\Http\Controllers\DevController::class, 'part']);
Route::get('/test-bot', [App\Http\Controllers\BotController::class, 'index'])->name('bot');

Route::get('/', function () {
 return redirect()->route('dashboard.index');
});

// Route::get('test-bot', [TelegramController::class, 'testBot'])->name('test.bot');

// DASHBOARD
Route::resource('dashboard', DashboardController::class);

// USER
Route::resource('user', UserController::class);

// Gejala
Route::resource('gejala', GejalaController::class);

// Penyakit
Route::resource('penyakit', PenyakitController::class);

// Penyakit Gejala
Route::resource('penyakit-gejala', PenyakitGejalaController::class);

// Manual Diagnosa
Route::resource('diagnosa', DiagnosaController::class);

// record Diagnosa
Route::get('record-diagnosa', [DiagnosaController::class, 'recordDiagnosa'])->name('record.index');


Route::prefix('admin')->middleware('auth')->group(function(){

   // admin
   Route::resource('admin', App\Http\Controllers\AdminController::class);

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
   Route::post('bookingList-tanggal' , [App\Http\Controllers\BookingController::class , 'bookingListTanggal'])->name('bookingList.tanggal');
   Route::get('bookingList-tanggal/{currentDate}' , [App\Http\Controllers\BookingController::class , 'downloadExcel'])->name('bookingList.excel');
   Route::get('bookingList-cancel/{bookingid}/{currentDate}' , [App\Http\Controllers\BookingController::class , 'cancelBooking'])->name('bookingList.cancel');
   Route::get('bookingList-done/{bookingid}/{currentDate}' , [App\Http\Controllers\BookingController::class , 'doneBooking'])->name('bookingList.done');

   Route::get('change-password' ,  [App\Http\Controllers\UserController::class, 'index'])->name('change_password.index');
   Route::post('change-password' ,  [App\Http\Controllers\UserController::class, 'update'])->name('change_password.update');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
