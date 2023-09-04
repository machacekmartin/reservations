<?php

use App\Http\Controllers\LogoutUserController;
use App\View\Components\Pages\EditUserPage;
use App\View\Components\Pages\LoginPage;
use App\View\Components\Pages\RegisterPage;
use App\View\Components\Pages\ReservationsPage;
use Illuminate\Support\Facades\Blade;
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
    Route::get('/', fn () => Blade::renderComponent(new ReservationsPage))->name('reservations');
    Route::get('account', fn () => Blade::renderComponent(new EditUserPage))->name('edit-account');
    Route::post('logout', LogoutUserController::class)->name('logout');
});

// Routes that require user to NOT be logged in
Route::get('login', fn () => Blade::renderComponent(new LoginPage))->name('login')->middleware('guest');
Route::get('register', fn () => Blade::renderComponent(new RegisterPage))->name('register')->middleware('guest');
