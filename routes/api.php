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
        
    
    });
});