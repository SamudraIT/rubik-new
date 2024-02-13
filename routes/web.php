<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/reset-password', [AuthController::class, 'renderReset']);
Route::get('/admin/change-password', [AuthController::class, 'renderChange'])->name('change-password');
Route::post('change-password', [AuthController::class, 'handleChange']);
Route::post('reset-password', [AuthController::class, 'handleReset']);