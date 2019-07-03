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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
    });
});