<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$status = $request->session()->get('success', '');
    	$commandes = Commande::where('traitee','=', false)->get();
        	return view('commande.index',['commandeEnCours'=>true, 'commandes'=>$commandes, 'status'=>$status
        ]);
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
    	$commande = new Commande();
    	if($request->input("token")!=""){
    		if($user = JWTAuth::parseToken()->toUser()){
    			$commande->name = $user->name;
    		}
    	}else{
    		$commande->name = $request->input("name");
    	}
    	
        
        $commande->lieu = $request->input("lieu");
      	$commande->date= date("Y-m-d H:i:s",strtotime($request->input("heure")));
      	$commande->number = $request->input("nombre");
        
        
        if($commande->save()){
        	return response()->json("ok");
        }else{
        	return response()->json("error", 500);
        }
        
        
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
        $admins = DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
        				->join('roles', 'role_user.role_id','=', 'roles.id')
        				->where('roles.name','=','admin')->pluck('users.name', 'users.id');
        
        $commande = Commande::find($id);
        return view('commande.edit', ['admins'=>$admins, 'commande'=>$commande]);
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
    	$commande = Commande::find($id);
    	$user = User::find($request->input('user_id'));
    	$commande->user()->associate($user)->save();
    	return redirect()->route('commandes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $commande = Commande::find( $id);
        $commande->delete();
        $request->session()->flash('success', 'Commande supprimée!');
        return redirect()->route('commandes.index');
    }
    
    
    public function takeCommande(Request $request){
    	
    	$commande = Commande::find($request->input('id'));
    	$user = Auth::user();
    	
    	$commande->user()->associate($user)->save();
    	return response()->json("ok");
    }
}
