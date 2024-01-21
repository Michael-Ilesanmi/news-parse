<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsController;
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

Route::get('/login', [LoginController::class, 'show']);
Route::post('/login', [LoginController::class, 'store'])->name("login");
Route::get('/logout', [LoginController::class, 'logout'])->name("logout");

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => '/'], function () {
        Route::get('', [NewsController::class, 'index'])->name('home');
        Route::get('parse', [NewsController::class, 'fetchNews'])->name('parse-news');

    });
});
