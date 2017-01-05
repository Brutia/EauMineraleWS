<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

// 	public function __construct(){
// 		$this->middleware('auth');
// 	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user = User::with('roles')->find($id);
        $user_roles = [];
        foreach ($user->roles as $role){
        	$user_roles[] = $role->name;
        }
        $roles = DB::table('roles')->select('id','name')->get();
        return view('users.edit',['user'=>$user, 'roles'=>$roles,'user_roles'=>$user_roles, 'user_name'=>$user->name]);
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
    	$user = User::with('roles')->find($id);

    	$roles = DB::table('role_user')->where('user_id','=',$id)->pluck('role_id');
    	foreach($roles as $role){
    		$temp = Role::find($role);
    		$user->detachRole($temp);
    	}
    	if($request->input('role') != ''){
    		foreach($request->input('role') as $role){
    			$temp = Role::find($role);
    			$user->attachRole($temp);
    		}
    	}
    	

    	$user->name = $request->input("name");

    	$user->save();

    	return redirect()->action('UserController@index');
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
}
