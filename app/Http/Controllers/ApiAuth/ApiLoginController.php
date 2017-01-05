<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use User;


use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\ApiToken;
use Illuminate\Support\Facades\DB;

class ApiLoginController extends Controller
{
	public function login(Request $request){
		// grab credentials from the request$
		$credentials = $request->only('email', 'password');
		try {
			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['error' => 'could_not_create_token'], 500);
		}
		
		
		return response()->json(compact('token'));
	}
	
	
	
	public function getAuthenticatedUser()
	{
		$user = JWTAuth::parseToken()->toUser();
		
		return response()->json(compact('user'));
	}
	
	public function postPushToken(Request $request){
		$pushToken = $request->input("push_token");
		if($request->input('token','') != ''){ // dans le cas où l'utilisateur est authentifié
			$user = JWTAuth::parseToken()->toUser();
			
			if($user->apiToken == null){
				
				if(($apiToken = ApiToken::where('api_token','=',$pushToken)->first()) != null){
				
					$user->apiToken()->associate($apiToken);
					$user->save();
				}else{
					$apiToken = new ApiToken();
					$apiToken->api_token = $pushToken;
					$user->apiToken()->save($apiToken);
				}
				
			}
			
		}else{ //dans le cas où l'user est anonyme
			if($apiToken = DB::table('api_tokens')->where('api_token','=',$pushToken)->first() == null){
				$apiToken = new ApiToken();
				$apiToken->api_token = $pushToken;
				$apiToken->save();
			}
		}
		
		
		return response()->json("ok");
	}
	
}
