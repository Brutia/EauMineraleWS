<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/home', function(){
	return view('home');
});
Auth::routes();
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	
	Route::resource('commandes', 'CommandeController');
	Route::resource('user', 'UserController');
	Route::resource('push', 'PushNotificationController');
	Route::post('takeCommande', 'CommandeController@takeCommande');
	Route::post('sendnotif', 'PushNotificationController@sendnotif');
	
});

Route::get('/test', 'PushController@testpush');