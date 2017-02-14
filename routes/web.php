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


Route::get('/', "HomeController@home");
Auth::routes();
Route::post("/sendCommande","CommandeController@sendCommande");
Route::get("live_wall", "MessageWallController@create");
Route::post("store_live_wall", "MessageWallController@store");
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	
	Route::resource('commandes', 'CommandeController');
	Route::resource('user', 'UserController');
	Route::resource('push', 'PushNotificationController');
	Route::resource('fil_rouge', 'FilRougeController');
	Route::resource('wall_message','MessageWallController');
	Route::post('takeCommande', 'CommandeController@takeCommande');
	Route::post('sendnotif', 'PushNotificationController@sendnotif');
	Route::get('getCommandes', 'CommandeController@getCommandes');
	Route::get('display_live_wall', 'MessageWallController@display');

	Route::get("live_messages", "MessageWallController@getMessages");
	
});
