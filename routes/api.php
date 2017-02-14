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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api')

Route::post('/login', 'ApiAuth\ApiLoginController@login')->middleware('cors');
Route::post('/register', 'ApiAuth\ApiRegisterController@register')->middleware('cors');
Route::post('/postPushToken','ApiAuth\ApiLoginController@postPushToken')->middleware('cors');
Route::get('/getUserInfo', 'ApiAuth\ApiLoginController@getAuthenticatedUser')->middleware('cors','jwt.auth');
Route::get('/getInfo', 'PushNotificationController@apiIndex')->middleware('cors');
Route::post('/postCommande', 'CommandeController@store')->middleware('cors');
Route::get('/getFilRouges', 'FilRougeController@getFilRouge')->middleware('cors');
Route::get("/getCommandesAppli", 'CommandeController@getCommandesAppli')->middleware("cors");
Route::post("/takeCommande", "CommandeController@takeCommandeAppli")->middleware("cors","jwt.auth");
Route::get("/disconnect", "ApiAuth\ApiLoginController@disconnect")->middleware("cors");
