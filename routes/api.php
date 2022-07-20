<?php

use App\Http\Controllers\admin\AdminTripController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get('/getServiceProviders', 'admin\AdminTripController@getServiceProviders')->name('getServiceProviders');
Route::get('/getServiceSubServices', 'admin\AdminTripController@getServiceSubServices')->name('getServiceSubServices');
Route::get('/getTripData', 'GlobalSharedController@getTripData')->name('getTripData');
