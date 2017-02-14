<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FilRouge;

class HomeController extends Controller
{
    public function home(){
    	$fil_rouges = FilRouge::select("id", "nom")->get();
//     	dd($fil_rouges);
    	return view("home", ["fil_rouges"=>$fil_rouges]);
	}
}
