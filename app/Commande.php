<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public function user(){
    	return $this->belongsTo('App\User');
	}
	
	public function apiToken(){
		return $this->belongsTo("App\ApiToken");
	}
	
	
}
