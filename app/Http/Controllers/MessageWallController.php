<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MessageWall;

class MessageWallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = MessageWall::all();
        return view("message_wall.index", ["messages"=> $messages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("message_wall.add");
    }
    
    public function display(){
    	return view("message_wall.display");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new MessageWall();
        if(htmlspecialchars($request->input("name")) == ""){
        	$message->name="Anonyme";
        }else{
        	$message->name = htmlspecialchars($request->input("name"));
        }
        
        $message->message = htmlspecialchars($request->input("message"));
        if($message->save()){
        	return response()->json(["status"=>"ok"]);
        	
        }
        return response()->json(["status"=>"error"],500);
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
        $message = MessageWall::find($id);
        $message->delete();
        return redirect()->route("wall_message.index");
    }
    
    public function getMessages(Request $request){
    	return response()->json(MessageWall::where("id", ">", $request->input("id"))->get());
    	
    }
}
