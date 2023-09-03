<?php

use App\Livewire\Pages\LoginPage;
use App\Livewire\Pages\RegisterPage;
use App\Livewire\Pages\ReservationsPage;
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
    Route::get('/', ReservationsPage::class)->name('reservations');
    Route::post('logout', function () { auth()->logout(); redirect()->to('login'); })->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('login', LoginPage::class)->name('login');
    Route::get('register', RegisterPage::class)->name('register');
});
