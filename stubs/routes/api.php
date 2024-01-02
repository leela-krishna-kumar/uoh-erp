<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [AuthController::class,'login']);


//APIs with authentication
Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::get('/profile', 'AuthController@profile');
	Route::get('logout', 'AuthController@logout');
    Route::resource('fleets', 'FleetsController');
    Route::post('update-fleets-status/{id}', 'FleetsController@updateFleetsStatus')->name('update-fleets-status');
    Route::get('device-log/{fleet_id}', 'DeviceLogController@index')->name('device-log');
    Route::post('add-device-log/{fleet_id}', 'DeviceLogController@store')->name('add-device-log');
});

