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

Route::get('/', [\App\Http\Controllers\ListingsController::class, 'index']);
Route::get('/listing/create', [\App\Http\Controllers\ListingsController::class, 'create'])->middleware('auth');
Route::post('/listing', [\App\Http\Controllers\ListingsController::class, 'store'])->middleware('auth');
Route::get('/listing/{listing}/edit', [\App\Http\Controllers\ListingsController::class, 'edit'])->middleware('auth');
Route::put('/listing/{listing}', [\App\Http\Controllers\ListingsController::class, 'update'])->middleware('auth');
Route::delete('/listing/{listing}', [\App\Http\Controllers\ListingsController::class, 'destroy'])->middleware('auth');
Route::get('/listing/manager', [\App\Http\Controllers\ListingsController::class, 'manager'])->middleware('auth');
Route::get('/listing/{listing}', [\App\Http\Controllers\ListingsController::class, 'show']);

// User related routes
Route::get('/register', [\App\Http\Controllers\UserController::class, 'create'])->middleware('guest');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->middleware('auth');
Route::get('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/user/login', [\App\Http\Controllers\UserController::class, 'login_account'])->middleware('guest');
