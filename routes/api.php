<?php

use App\Http\Controllers\PassengerController;
use Illuminate\Support\Facades\Route;

Route::prefix('passengers')->group(function () {
    Route::get('/', [PassengerController::class, 'index']);
    Route::post('/', [PassengerController::class, 'store']);
    Route::get('/{id}', [PassengerController::class, 'show']);
    Route::put('/{id}', [PassengerController::class, 'update']);
    Route::patch('/{id}', [PassengerController::class, 'update']);
    Route::delete('/{id}', [PassengerController::class, 'destroy']);
});
