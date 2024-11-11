<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('verify-token')->get('/comms', function () {
    return true;
});

Route::post('/travel/{user_id}/store', [\App\Http\Controllers\api\PackageController::class, 'store']);
Route::get('/travel/{user_id}/unsend', [\App\Http\Controllers\api\PackageController::class, 'unsendPack']);
Route::get('/travel/{user_id}/send', [\App\Http\Controllers\api\PackageController::class, 'sendPack']);
Route::delete('/travel/{travel_id}', [\App\Http\Controllers\api\PackageController::class, 'deleteTravel']);
