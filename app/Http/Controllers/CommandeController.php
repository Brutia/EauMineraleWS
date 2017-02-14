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
		
		$commande->lieu = htmlspecialchars($request->input ( "lieu" ));
		$heure = preg_split("#:#", $request->input("heure"));
		$jourMois = preg_split("#\/#", $request->input("jour"));
		$commande->date = date ( "Y-m-d H:i:s", mktime($heure[0], $heure[1],null, $jourMois[0], $jourMois[1],2017));
		$commande->number = htmlspecialchars($request->input ( "nombre" ));
		$commande->commentaire = htmlspecialchars($request->input("commentaire"));
		
		$filRouge = FilRouge::where("numero", "=", $request->input("nr_fil_rouge"))->first();
		
		if($filRouge == null){
			return response()->json(["status"=>"error"],440);
		}
		
		$push_token = ApiToken::where("api_token","=", $request->input("push_token"))->first();
		if($push_token->commande()->save($commande)){
			if ($filRouge->commande()->save($commande)) {
				return response ()->json (["status"=>"ok"]);
			} else {
				return response ()->json ( ["status"=>"error"], 500 );
			}
		}else{
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
		$request->session ()->flash ( 'success', 'Commande supprimï¿½e!' );
		return redirect ()->route ( 'commandes.index' );
	}
	public function takeCommande(Request $request) {
		$commande = Commande::find ( $request->input ( 'id' ) );
		$user = Auth::user ();
		
		$commande->user ()->associate ( $user )->save ();
		return response ()->json ( "ok" );
	}
	public function getCommandes(Request $request) {
		if($request->input("a_traiter") ==  "oui"){
			$commandes = Commande::select('commandes.id', 'commandes.name as cname',"fil_rouges.nom",'lieu','number','date','users.name as uname','number', 'commentaire')->where("user_id","=", null)->leftJoin('users','users.id', '=', 'commandes.user_id')->leftJoin("fil_rouges", "commandes.fil_rouge_id", "=", "fil_rouges.id") ->orderBy ( 'date', 'desc' )->get ();
		}else{
			$commandes = Commande::select('commandes.id', 'commandes.name as cname',"fil_rouges.nom",'lieu','number','date','users.name as uname','number', 'commentaire')->where("user_id","<>", null)->leftJoin('users','users.id', '=', 'commandes.user_id')->leftJoin("fil_rouges", "commandes.fil_rouge_id", "=", "fil_rouges.id") ->orderBy ( 'date', 'desc' )->get ();
			
		}
		
		return response ()->json ( ["data"=>$commandes ]);
	}
	
	public function getCommandesAppli(Request $request){
		$pushToken = $request->input("push_token");
		$apiToken = ApiToken::with("user")->where("api_token","=", $pushToken)->first();
		if(isset($apiToken->user) && $apiToken->user->hasRole("admin")){ // admin, on renvoie les commandes qu'il doit traiter

			$commandes = Commande::select("commandes.id as id", "nom", "number", "lieu", "name", "commentaire")->where("user_id","=",null)->join("fil_rouges" ,"fil_rouges.id","=","commandes.fil_rouge_id")->orderBy("commandes.date","desc")->get();
		
		}else{ //simple utilisateur on renvoie que les commandes le concernant
			$commandes = Commande::join("api_tokens","commandes.api_token_id","=","api_tokens.id")->join("fil_rouges" ,"fil_rouges.id","=","commandes.fil_rouge_id")->where("api_tokens.api_token","=",$pushToken)->orderBy("commandes.date","asc")->get();
			
		}
		return response()->json($commandes);
	}
	
	public function takeCommandeAppli(Request $request){
		if($request->input('token','') != ''){ // dans le cas où l'utilisateur est authentifié
			$user = JWTAuth::parseToken()->toUser();
			if($user->hasRole("admin")){
				$commande = Commande::find($request->input("commande_id"));
				if($commande != null && $commande->user ()->associate ( $user )->save ()){

					return response ()->json ( "ok" );
				}
			}
		}
			
		return response()->json(["status"=>"error"],500);
	}
	
	public function sendCommande(Request $request){
		
		$commande = new Commande();
		$fil_rouge = FilRouge::find($request->input("fil_rouge"));
		if($fil_rouge == null){
			return response()->json(["status"=>"error"],500);
		}
		$commande->name = htmlspecialchars($request->input("name"));
		$commande->lieu = htmlspecialchars($request->input("lieu"));
		$commande->commentaire = htmlspecialchars($request->input("commentaire"));
		$commande->number = htmlspecialchars($request->input("number"));
		$commande->date = date("Y-m-d H:i:s");
		
		if($fil_rouge->commande()->save($commande)){
			return response()->json(["status"=>"ok"]);
		}else{
			return response()->json(["status"=>"error"],500);
		}
		
		
	}
}
