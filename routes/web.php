<?php

use App\Http\Controllers\AuthController;
use App\Models\PencatatanJentik;
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

Route::get('/api/timer', function () {
    $user = auth()->user();

    $lastCase = PencatatanJentik::where('user_id', $user->id)
        ->orderBy('reported_date', 'desc')
        ->first();

    return response()->json($lastCase);
});