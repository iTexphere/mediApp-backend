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
*  Medical Center Without Authenticated Route -
*/
Route::group(['as'=>'v1.medical','prefix'=>'v1/medical', 'namespace'=>'Api\Medical'], function(){
	Route::post('signup', 'UserController@signup')->name('.signup');
	Route::post('signin', 'UserController@signin')->name('.signin');
});

/**
*  Medical Center Authenticated Route -
*/
Route::group(['as' => 'v1.medical', 'prefix' => 'v1/medical', 'namespace' => 'Api\Medical', 'middleware'=> ['auth:api', 'scope:medical-center']], function(){

	Route::get('/booking/patient', 'BookingController@booking')->name('.booking.patient');
	Route::post('/our-bookings', 'BookingController@ourbooking')->name('.ourbooking');

});




/**
*  Patient Without Authenticated Route -
*/
Route::group(['as'=>'v1.patient', 'prefix'=>'v1/patient', 'namespace'=>'Api\Patient'], function(){
	Route::post('signup', 'UserController@signup')->name('.signup');
	Route::post('signin', 'UserController@signin')->name('.signin');
});

/**
*  Patient Authenticated Route -
*/
Route::group(['as' => 'v1.patient', 'prefix' => 'v1/patient', 'namespace' => 'Api\Patient', 'middleware'=> ['auth:api', 'scope:patient']], function(){

	Route::get('/booking/{medicalid}/', 'BookingController@booking')->name('.booking.medical');
	Route::post('/src', 'MedicalController@medicalSearch')->name('.search.medical');
	Route::get('/my-booking', 'BookingController@mybooking')->name('.mybooking');
	

});

