<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'apiLoginuser']);
Route::post('/registration', [ApiController::class, 'apiRegistrationuser']);
Route::get('forgetpassword/{user_role}/{user_email}', [ApiDataController::class,'forgetPassword']);
Route::get('/policies', [ApiController::class,'apiPolicy']);
Route::post('/logout', [ApiController::class, 'apiLogoutuser']);

Route::middleware('bearer.auth')->group(function () {

    Route::get('/profile/{role}/{id}', [ApiController::class, 'apiUserProfile']);
    Route::post('/update-profile', [ApiController::class, 'apiUpdateProfile']);
    Route::post('/change-password', [ApiController::class, 'apiChangePassword']);
    Route::post('/update-fcm-token', [ApiController::class, 'apiUpdateFCMToken']);
   Route::get('/slider', [ApiController::class, 'apiSlider']);
   
    Route::get('passengerinactive/{user_id}', [ApiController::class,'apiPassengerInactive']);
    Route::get('driverinactive/{user_id}', [ApiController::class,'apiDriverInactive']); 
    
    Route::post('passengersbooking', [ApiController::class,'apiBookingStore']);
    
    Route::post('changepassword', [ApiController::class,'changePassword']);
    Route::post('verifypassenger', [ApiController::class,'apiVerifypassenger']);
    Route::get('rangedatefilter/{user_id}/{startDate}/{endDate}', [ApiController::class,'apiRangedateFilter']);
    
    Route::post('bookingupdate', [ApiController::class,'apiBookingUpdate']);
    Route::get('bookingassignlist/{mobile_number}', [ApiController::class,'apiBookingAssign']);
    Route::get('bookingassignsingle/{booking_id}', [ApiController::class,'apiBookingAssignSingle']);
    Route::post('bookingcancel/{booking_id}', [ApiController::class,'apiBookingCancel']);
    Route::get('shifting', [ApiController::class,'apiShiftingData']);
    Route::get('shifttime/{shift_name}', [ApiController::class,'apiShifttimeData']);
    Route::get('support', [ApiController::class,'apiSupport']);
    Route::get('getnotification/{email}', [ApiController::class,'getNotification']);
    Route::get('changenotification/{email}', [ApiController::class,'changeNotification']);
    
    Route::get('userdetail/{id}', [ApiController::class,'apiUserdetail']);
    
});