<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'apiLoginuser']);
Route::post('/registration', [ApiController::class, 'apiRegistrationuser']);
Route::get('/test', function() {
    return response()->json(['status' => 'ok']);
});