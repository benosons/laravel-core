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

Route::get('/', function () {
    return view('welcome');
});

// Web authentication routes
Route::get('/login', [\App\Http\Controllers\Web\AuthWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Web\AuthWebController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Web\AuthWebController::class, 'logout'])->name('logout');

// Admin routes for user management
Route::middleware(['auth:sanctum'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Web\UserWebController::class);
});

