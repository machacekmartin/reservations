<?php

use App\Livewire\Pages;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', Pages\ReservationsPage::class)->name('reservations');
    Route::get('reservations', Pages\ReservationsPage::class)->name('reservations');
});

Route::get('login', Pages\LoginRegisterPage::class)->name('login')->middleware('guest');
