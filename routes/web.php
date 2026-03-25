<?php

use App\Http\Controllers\AdminCoontroller;
use App\Http\Controllers\BookingControllter;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/query', function () {
    $pickup_available_message = '';
    $dropup_available_message = '';
    $pickup_available_status = 0;
    $dropup_available_status = 0;
    return view('query',compact('pickup_available_message','dropup_available_message','pickup_available_status','dropup_available_status'));
    });
    
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
    Route::get('get-passenger-addresses/{user_id}/{address}', [PassengerController::class, 'passengerAddress'])->name('passenger.address');

    Route::get('/rider-add', [RiderController::class, 'riderAdd'])->name('rider-add');
    Route::post('/rider-store', [RiderController::class, 'store'])->name('rider.store');
    Route::get('/rider-list', [RiderController::class, 'index'])->name('rider-list');
    Route::get('/rider-inactivelist', [RiderController::class, 'inactiveList'])->name('rider.inactivelist');
    Route::get('/rider-pendinglist', [RiderController::class, 'pendingList'])->name('rider.pendinglist');
    Route::get('/rider-exportlist', [RiderController::class, 'exportList'])->name('rider.exportlist');
    Route::delete('/rider-delete', [RiderController::class, 'destroy'])->name('rider.delete');
    Route::get('/rider-edit', [RiderController::class, 'edit'])->name('rider.edit');
    Route::post('/rider-update', [RiderController::class, 'update'])->name('rider.update');
    Route::get('/rider-view', [RiderController::class, 'show'])->name('rider.show');
    Route::post('/rider-view', [RiderController::class, 'updateRiderView'])->name('rider.updateView');
    Route::get('/rider-exportlistcsv', [RiderController::class, 'exportListCSV'])->name('rider.exportlistcsv');
    Route::post('/rider-bulkActivate', [RiderController::class, 'bulkActivate'])->name('rider.bulkActivate');
    Route::get('/get-address-details/{tb}/{addressId}', [RiderController::class, 'getAddressDetails'])->name('rider.getAddressDetails');

 

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

    Route::get('/carousel', [AdminCoontroller::class, 'carouselList'])->name('carousel.list');
    Route::get('/carousel-edit', [AdminCoontroller::class, 'editCarousel'])->name('carousel.edit');
    Route::post('/carousel-edit', [AdminCoontroller::class, 'postEditCarousel'])->name('carousel.update');
    Route::get('/carousel-delete/{id}', [AdminCoontroller::class, 'deleteCarousel'])->name('carousel.delete');
    Route::post('/carousel-add', [AdminCoontroller::class, 'postCarousel'])->name('carousel.add');
    Route::get('/carousel-add', [AdminCoontroller::class, 'carouselAdd'])->name('carousel.add');


    Route::get('/booking-list', [BookingControllter::class, 'bookingList'])->name('booking.list');
    Route::get('/passenger-booking', [BookingControllter::class, 'booking'])->name('passenger.booking');
    Route::post('/booking-store', [BookingControllter::class, 'bookingPost'])->name('booking.store');

    Route::get('/booking.edit', [BookingControllter::class, 'bookingEdit'])->name('booking.edit');
    Route::post('/booking.edit', [BookingControllter::class, 'bookingUpdate'])->name('booking.edit');
    

    Route::post('/booking-single-store', [BookingControllter::class, 'singleStore'])->name('booking.singlestore');
    Route::get('/shift-time', [BookingControllter::class, 'shiftTime'])->name('shift.time');
    Route::get('/booking-export', [BookingControllter::class, 'bookingExport'])->name('booking.export');
    Route::get('/booking-exportlistcsv', [BookingControllter::class, 'exportListCSV'])->name('booking.exportlistcsv');
    Route::post('/bulkActivate', [PassengerController::class, 'bulkActivate'])->name('passenger.bulkActivate');
    Route::get('/booking-delete', [BookingControllter::class, 'bookingDelete'])->name('booking.delete');
    Route::POST('/time-cut', [BookingControllter::class, 'bookingTimecut'])->name('booking.timecut');
    Route::get('/shifttimeall/{shift}', [BookingControllter::class, 'shiftTimeAll'])->name('shift.timeall');
    
    
    
    
});

require __DIR__.'/auth.php';
