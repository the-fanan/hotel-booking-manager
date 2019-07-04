<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * The following routes are for admins
 */
Route::group(["prefix" => "admin", "namespace" => "API\Admin"], function() {
    Route::group(["prefix" => "auth", "namespace" => "Auth"], function() {
        Route::post("/login", "LoginController@login");
    });

    Route::group(["middleware" => "auth:api-admin"], function() {

        Route::group(["prefix" => "hotel"], function() {
            Route::get("/", "HotelController@getHotel");
            Route::post("/{id}", "HotelController@updateHotel");
        });

        Route::group(["prefix" => "prices"], function() {
            Route::get("/", "PriceListController@prices");
            Route::post("/", "PriceListController@createPrice");
            Route::post("/{id}", "PriceListController@editPrice");
            Route::post("/delete/{id}", "PriceListController@deletePrice");
        });
        
        Route::group(["prefix" => "room-types"], function() {
            Route::get("/", "RoomTypeController@roomTypes");
            Route::post("/", "RoomTypeController@createRoomType");
            Route::post("/{id}", "RoomTypeController@editRoomType");
            Route::post("/delete/{id}", "RoomTypeController@deleteRoomType");
        });

        Route::group(["prefix" => "rooms"], function() {
            Route::get("/", "RoomController@rooms");
            Route::post("/", "RoomController@createRoom");
            Route::post("/{id}", "RoomController@editRoom");
            Route::post("/delete/{id}", "RoomController@deleteRoom");
        });

        Route::group(["prefix" => "bookings"], function() {
            Route::get("/", "BookingController@bookings");
            Route::post("/", "BookingController@createBooking");
            Route::post("/{id}", "BookingController@editBooking");
            Route::post("/delete/{id}", "BookingController@deleteBooking");
        });
    });
});

/**
 * The following routes are for registered users
 */
Route::group(["prefix" => "user"], function() {

});

/**
 * The following routes are for non registered users
 */
Route::group(["namespace" => "API"], function() {
    Route::post('/bookings', "BookingController@createBookingForUnregisteredUser");
});
 