<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'apiLoginuser']);
Route::post('/registration', [ApiController::class, 'apiRegistrationuser']);


Route::post('/logout', [ApiController::class, 'apiLogoutuser']);

Route::middleware('auth:api')->group(function () {
    
    Route::get('/profile', [ApiController::class, 'apiUserProfile']);
    Route::post('/update-profile', [ApiController::class, 'apiUpdateProfile']);
    Route::post('/change-password', [ApiController::class, 'apiChangePassword']);
    Route::post('/update-fcm-token', [ApiController::class, 'apiUpdateFCMToken']);
    Route::get('/carousel', [ApiController::class, 'apiCarousel']);
});