<?php

use App\Http\Controllers\AdminCoontroller;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/query', [AdminCoontroller::class, 'query'])->name('query');
    Route::post('/query', [AdminCoontroller::class, 'checkQuery'])->name('query.check');

    Route::get('/passenger-add', [PassengerController::class, 'passengerAdd'])->name('passenger-add');
    Route::post('/passenger-store', [PassengerController::class, 'store'])->name('passenger.store');
    Route::get('/passenger-list', [PassengerController::class, 'index'])->name('passenger-list');
    Route::get('/passenger-inactivelist', [PassengerController::class, 'inactiveList'])->name('passenger.inactivelist');
    Route::get('/passenger-pendinglist', [PassengerController::class, 'pendingList'])->name('passenger.pendinglist');
    Route::get('/passenger-exportlist', [PassengerController::class, 'exportList'])->name('passenger.exportlist');
    Route::get('/get-subpoints/{cityId}', [PassengerController::class, 'getSubpoints'])->name('get.subpoints');
   
  
    Route::delete('/passenger-delete', [PassengerController::class, 'destroy'])->name('passenger.delete');
    Route::get('/passenger-edit', [PassengerController::class, 'edit'])->name('passenger.edit');
    Route::post('/passenger-update', [PassengerController::class, 'update'])->name('passenger.update');
    Route::get('/passenger-view', [PassengerController::class, 'show'])->name('passenger.show');
    Route::get('/passenger-exportlistcsv', [PassengerController::class, 'exportListCSV'])->name('passenger.exportlistcsv');
    Route::post('/bulkActivate', [PassengerController::class, 'bulkActivate'])->name('passenger.bulkActivate');
    Route::get('/passenger-bookings', [PassengerController::class, 'bookings'])->name('passenger.bookings');

    Route::get('/privacy-policy', [AdminCoontroller::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/booking-policy', [AdminCoontroller::class, 'bookingPolicy'])->name('booking-policy');
    Route::get('/term-services', [AdminCoontroller::class, 'termServices'])->name('term-services');
    Route::get('/home-alerts', [AdminCoontroller::class, 'homeAlerts'])->name('home-alerts');
    Route::post('/privacy-policy', [AdminCoontroller::class, 'postPrivacyPolicy'])->name('privacy-policy.update');
    Route::post('/booking-policy', [AdminCoontroller::class, 'postBookingPolicy'])->name('booking-policy.update');
    Route::post('/term-services', [AdminCoontroller::class, 'postTermServices'])->name('term-services.update');
    Route::post('/home-alerts', [AdminCoontroller::class, 'postHomeAlerts'])->name('home-alerts.update');
    Route::get('/holiday-add', [AdminCoontroller::class, 'holiday'])->name('holiday');
    Route::post('/holiday-add', [AdminCoontroller::class, 'postHoliday'])->name('holiday.update');
    Route::get('/holiday-list', [AdminCoontroller::class, 'holidayList'])->name('holiday.list');
    Route::delete('/holiday-delete/{id}', [AdminCoontroller::class, 'deleteHoliday'])->name('holiday.delete');

    Route::get('/cities', [AdminCoontroller::class, 'cities'])->name('cities');
    Route::get('/add-city', [AdminCoontroller::class, 'addCity'])->name('add.city');
    Route::post('/add-city', [AdminCoontroller::class, 'postCity'])->name('post.city');
    Route::get('/edit-city', [AdminCoontroller::class, 'editCity'])->name('city.edit');
    Route::post('/edit-city', [AdminCoontroller::class, 'postEditCity'])->name('city.update');
    Route::delete('/delete-city/{id}', [AdminCoontroller::class, 'deleteCity'])->name('city.delete');

    Route::get('/subpoints', [AdminCoontroller::class, 'subpoints'])->name('subpoints');
    Route::get('/add-subpoint', [AdminCoontroller::class, 'addSubpoint'])->name('add.subpoint');
    Route::post('/add-subpoint', [AdminCoontroller::class, 'postSubpoints'])->name('subpoints.post');
    Route::get('/edit-subpoint', [AdminCoontroller::class, 'editSubpoint'])->name('subpoint.edit');
    Route::post('/edit-subpoint', [AdminCoontroller::class, 'postEditSubpoint'])->name('subpoint.update');
    Route::delete('/delete-subpoint/{id}', [AdminCoontroller::class, 'deleteSubpoint'])->name('subpoint.delete');

    Route::get('/postalcodes', [AdminCoontroller::class, 'postalCodes'])->name('postalcodes');
    Route::get('/add-postalcode', [AdminCoontroller::class, 'addPostalCode'])->name('add.postalcode');
    Route::get('/get-subpoints/{cityId}', [AdminCoontroller::class, 'getSubpoints'])->name('get.subpoints');
    Route::post('/add-postalcode', [AdminCoontroller::class, 'postPostalCode'])->name('postalcode.post');
    Route::get('/edit-postalcode', [AdminCoontroller::class, 'editPostalCode'])->name('postalcode.edit');
    Route::post('/edit-postalcode', [AdminCoontroller::class, 'postEditPostalCode'])->name('postalcode.update');
    Route::delete('/delete-postalcode/{id}', [AdminCoontroller::class, 'deletePostalCode'])->name('postalcode.delete'); 

    Route::get('/shift-add', [AdminCoontroller::class, 'addShift'])->name('shift.add');
    Route::post('/shift-add', [AdminCoontroller::class, 'postShift'])->name('shift.post');
    Route::get('/shifts', [AdminCoontroller::class, 'shiftList'])->name('shift.list');
    Route::delete('/shift-delete/{id}', [AdminCoontroller::class, 'deleteShift'])->name('shift.delete');
    Route::get('/shift-edit', [AdminCoontroller::class, 'editShift'])->name('shift.edit');
    Route::post('/shift-edit', [AdminCoontroller::class, 'postEditShift'])->name('shift.update');


    
    
});

require __DIR__.'/auth.php';
