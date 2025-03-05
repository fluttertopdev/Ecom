<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;


/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider and all of them will

| be assigned to the "api" middleware group. Make something great!

|

*/

// This is for User API Controller
Route::post('login', 'App\Http\Controllers\API\UserAPIController@doLogin');

Route::post('signup', 'App\Http\Controllers\API\UserAPIController@doSignup');

Route::post('forget-password', 'App\Http\Controllers\API\UserAPIController@doForgetPassword');

Route::post('do-verify-otp', 'App\Http\Controllers\API\UserAPIController@doVerifyOtp');

Route::post('reset-password', 'App\Http\Controllers\API\UserAPIController@doResetPassword');

Route::post('resent-otp', 'App\Http\Controllers\API\UserAPIController@resentOtp');


// This is for Home API COntroller
Route::match(['get', 'head'], 'get-item-list', 'App\Http\Controllers\API\HomeAPIController@getItemList');

Route::match(['get', 'head'], 'get-category-list', 'App\Http\Controllers\API\HomeAPIController@getCategoryList');

Route::match(['get', 'head'], 'get-restaurant-list', 'App\Http\Controllers\API\HomeAPIController@getRestaurantList');


// This is for auth protection
Route::middleware('apiauth:api')->group(function () {

    Route::match(['get', 'head'],'get-profile', 'App\Http\Controllers\API\UserAPIController@getProfile');
    Route::post('update-profile','App\Http\Controllers\API\UserAPIController@doUpdateProfile');

});
// End auth protection












