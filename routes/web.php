<?php

use App\Http\Controllers\LogoutUserController;
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

// Routes that require user to be logged in
Route::middleware('auth')->group(function () {
    Route::view('/', 'components.pages.reservations-page')->name('reservations');
    Route::post('logout', LogoutUserController::class)->name('logout');
});

// Routes that require user to NOT be logged in
Route::view('login', 'components.pages.login-page')->name('login')->middleware('guest');
Route::view('register', 'components.pages.register-page')->name('register')->middleware('guest');
