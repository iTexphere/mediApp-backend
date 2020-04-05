<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
* Login Registration Route -
*/
Route::group(['as'=>'v1.', 'prefix'=>'v1', 'namespace'=>'Api'], function(){
	Route::post('signup', 'UserController@signup')->name('signup');
	Route::post('signin', 'UserController@signin')->name('signin');
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
