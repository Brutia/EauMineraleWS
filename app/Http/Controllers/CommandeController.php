<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\json_encode;
use App\FilRouge;
use App\ApiToken;

class CommandeController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$status = $request->session ()->get ( 'success', '' );
		$commandes = Commande::where ( 'traitee', '=', false )->orderBy ( 'date', 'desc' )->get ();
		return view ( 'commande.index', [ 
				'commandeEnCours' => true,
				'commandes' => $commandes,
				'status' => $status 
		] );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$commande = new Commande ();
		if ($request->input ( "token" ) != "") {
			if ($user = JWTAuth::parseToken ()->toUser ()) {
				$commande->name = $user->name;
			}
		} else {
			$commande->name = $request->input ( "name" );
		}
		
		$commande->lieu = $request->input ( "lieu" );
		$heure = preg_split("#:#", $request->input("heure"));
		$jourMois = preg_split("#\/#", $request->input("jour"));
		$commande->date = date ( "Y-m-d H:i:s", mktime($heure[0], $heure[1],null, $jourMois[0], $jourMois[1]));
		$commande->number = $request->input ( "nombre" );
		
		$filRouge = FilRouge::where("number", "=", $request->input("nr_fil_rouge"))->first();
		$push_token = ApiToken::where("api_token","=", $request->input("push_token"))->first();
		$push_token->commande()->save($commande);
		
		if ($filRouge->commande()->save($commande)) {
			return response ()->json (["status"=>"ok"]);
		} else {
			return response ()->json ( ["status"=>"error"], 500 );
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$admins = DB::table ( 'users' )->join ( 'role_user', 'users.id', '=', 'role_user.user_id' )->join ( 'roles', 'role_user.role_id', '=', 'roles.id' )->where ( 'roles.name', '=', 'admin' )->pluck ( 'users.name', 'users.id' );
		
		$commande = Commande::find ( $id );
		return view ( 'commande.edit', [ 
				'admins' => $admins,
				'commande' => $commande 
		] );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$commande = Commande::find ( $id );
		$user = User::find ( $request->input ( 'user_id' ) );
		$commande->user ()->associate ( $user )->save ();
		return redirect ()->route ( 'commandes.index' );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id) {
		$commande = Commande::find ( $id );
		$commande->delete ();
		$request->session ()->flash ( 'success', 'Commande supprim�e!' );
		return redirect ()->route ( 'commandes.index' );
	}
	public function takeCommande(Request $request) {
		$commande = Commande::find ( $request->input ( 'id' ) );
		$user = Auth::user ();
		
		$commande->user ()->associate ( $user )->save ();
		return response ()->json ( "ok" );
	}
	public function getCommandes() {
		$commandes = Commande::select('commandes.id', 'commandes.name as cname','lieu','number','date','users.name as uname','number')->leftJoin('users','users.id', '=', 'commandes.user_id') ->orderBy ( 'date', 'desc' )->get ();
	
		return response ()->json ( ["data"=>$commandes ]
				
		 );
	}
}
