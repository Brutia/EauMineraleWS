<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function getPost(){
    	$fb = new \Facebook\Facebook ( [
    			'app_id' => env ( 'FACEBOOK_APP_ID' ),
    			'app_secret' => env ( 'FACEBOOK_APP_SECRET' ),
    			'default_graph_version' => 'v2.8',
    			// 				'default_access_token' => env ( 'FACEBOOK_APP_TOKEN' ) ,
    	// 				'appsecret_proof' => $appsecret_proof,
    	] // optional
    			);
    	
    	
    	$config = array(
    			'appId' => env ( 'FACEBOOK_APP_ID' ),
    			'secret' => env ( 'FACEBOOK_APP_SECRET' ),
    			'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
    	);
    	
    	$facebook = new \Facebook\Facebook($config);
    	// 		$user_id = $facebook->getUser();
    	$AppToken = $facebook;
    	
    	// 		$appsecret_proof= hash_hmac('sha256', env ( 'FACEBOOK_APP_TOKEN' ),env ( 'FACEBOOK_APP_SECRET' ) );
    	try {
    		// 			Get the \Facebook\GraphNodes\GraphUser object for the current user.
    		// 			If you provided a 'default_access_token', the '{access-token}' is optional.
    		$fbResponse = $fb->get ( '/358496450338/posts' , $AppToken );
    	} catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
    		// When Graph returns an error
    		echo 'Graph returned an error: ' . $e->getMessage ();
    		exit ();
    	} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
    		// When validation fails or other local issues
    		echo 'Facebook SDK returned an error: ' . $e->getMessage ();
    		exit ();
    	}
    	
    	$data = $fbResponse->getGraphEdge();
    	// 		$me = json_decode($me);
    	// 		$me = $me[0];
    	return response($data);
    }
    
}
