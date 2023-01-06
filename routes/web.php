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


// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['hasAccessToken'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/translations', [App\Http\Controllers\TranslationController::class, 'index'])->name('translations');
    Route::get('/translations/edit/{editionId}/{lang}', [App\Http\Controllers\TranslationController::class, 'edit'])->name('translations.edit');
    Route::post('/translations/edit/{editionId}/{lang}', [App\Http\Controllers\TranslationController::class, 'store'])->name('translations.save');

    // Only Accessible to Admin Users
    Route::middleware(['admin'])->group(function () {
        Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
        Route::get('/users/edit/{userId}', [App\Http\Controllers\UsersController::class, 'edit'])->name('users.edit');

        Route::get('/participants', [App\Http\Controllers\DashboardController::class, 'index'])->name('participants');
    });
});

Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
Route::post('/', [App\Http\Controllers\Auth\AuthController::class, 'doLogin'])->name('dologin');