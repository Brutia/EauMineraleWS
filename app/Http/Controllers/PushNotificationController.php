<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PushNotification;
use App\User;
use App\Notifications\Info;
use Illuminate\Support\Facades\Notification;
use App\ApiToken;

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
    	$push_notifications = PushNotification::all()->where('sended','=','1');
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
        //
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
        //
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
    	$pushNotification = new PushNotification();
    	$pushNotification->title = $request->input('titre');
    	$pushNotification->message = $request->input('message');
    	$pushNotification->sended = true;
    	$pushNotification->save();
    	$tokens = ApiToken::all();
    	Notification::send($tokens, new Info($pushNotification->title, $pushNotification->message));
    	return response()->json("ok");
    }
    
    
}
