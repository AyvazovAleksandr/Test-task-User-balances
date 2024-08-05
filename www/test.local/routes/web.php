<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider. All of them will be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/operations', [App\Http\Controllers\HomeController::class, 'getOperations'])->name('home');
Route::get('/transactions', [App\Http\Controllers\HomeController::class, 'getTransactions'])->name('home');
Route::get('/balance', [App\Http\Controllers\HomeController::class, 'getBalance'])->name('home');
Auth::routes(['register' => false]);
