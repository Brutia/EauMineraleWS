<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PushNotification;
use App\User;
use App\Notifications\Info;
use Illuminate\Support\Facades\Notification;
use App\ApiToken;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $push_notifications = PushNotification::all();
       return view('push_notification.index', ['pushs'=> $push_notifications]);
    }
    
    public function apiIndex(){
    	$push_notifications = PushNotification::orderBy('created_at', 'desc')->where('sended','=','1')->get();
    	return response()->json($push_notifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('push_notification.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$pushNotification = new PushNotification();
    	$pushNotification->title = $request->input('title');
    	$pushNotification->message = $request->input('message');
    	$pushNotification->sended = false;
    	$pushNotification->save();
    	return redirect()->route('push.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pushNotification = PushNotification::find($id);
        
        return view('push_notification.edit', ['push'=>$pushNotification]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function sendNotif( Request $request){
//     	$pushNotification = new PushNotification();
//     	$pushNotification->title = $request->input('titre');
//     	$pushNotification->message = $request->input('message');
//     	$pushNotification->sended = true;
//     	$pushNotification->save();
//     	$tokens = ApiToken::all();
//     	Notification::send($tokens, new Info($pushNotification->title, $pushNotification->message));
//     	return response()->json("ok");

    	$optionBuiler = new OptionsBuilder();
    	$optionBuiler->setTimeToLive(60*20);
    	
    	$notificationBuilder = new PayloadNotificationBuilder($request->input('titre'));
    	$notificationBuilder->setBody($request->input('message'))
    	->setSound('default');
    	
    	$dataBuilder = new PayloadDataBuilder();
    	$dataBuilder->addData(['title' => $request->input('titre'), 'message'=>$request->input('message')]);
    	
    	
    	$option = $optionBuiler->build();
    	$notification = $notificationBuilder->build();
    	$data = $dataBuilder->build();
    	
    	
    	$tokens = ApiToken::pluck('api_token')->toArray();
    	
//     	$token = "";
    	
    	$downstreamResponse = FCM::sendTo($tokens, $option, $notification,$data);
    	
    	$downstreamResponse->numberSuccess();
    	$downstreamResponse->numberFailure();
    	$downstreamResponse->numberModification();
    	
    	//return Array - you must remove all this tokens in your database
    	$downstreamResponse->tokensToDelete();
    	
    	//return Array (key : oldToken, value : new token - you must change the token in your database )
    	$downstreamResponse->tokensToModify();
    	
    	//return Array - you should try to resend the message to the tokens in the array
    	$downstreamResponse->tokensToRetry();
    	
    	$pushNotification = new PushNotification();
    	$pushNotification->title = $request->input('titre');
    	$pushNotification->message = $request->input('message');
    	$pushNotification->sended = true;
    	$pushNotification->save();
    	
    	// return Array (key:token, value:errror) - in production you should remove from your database the tokens
    	return response()->json(["status"=>"ok"]);
    }
    
    
}
