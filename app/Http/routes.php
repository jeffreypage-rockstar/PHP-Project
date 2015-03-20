<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix'=> 'v1'], function(){

	// Obtain Oauth Token
	Route::post('oauth/token', 'Api\v1\AuthController@getToken');

	// SignUp
	Route::post('auth/signup', 'Api\v1\AuthController@signUp');

	// SignIn
	Route::post('auth/signin', 'Api\v1\AuthController@signIn');

	// Listing Resource
	Route::resource('listing', 'Api\v1\ListingController', ['except'=> 'create']);
});


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);