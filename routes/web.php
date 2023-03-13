<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Middleware\AuthenticateSanctum;

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

Route::get('/', [ViewController::class, 'login'])->name('login-page'); // rota de login
Route::get('/register', [ViewController::class, 'register'])->name(
    // rota de registro
    'register-page'
);

Route::group(['middleware' => [AuthenticateSanctum::class]], function () {
    Route::get('/home', [ViewController::class, 'home'])->name('home-page');
});
