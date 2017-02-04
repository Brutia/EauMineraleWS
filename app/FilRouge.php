<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilRouge extends Model
{
	public function commande(){
		return $this->hasMany('App\Commande');
	}
}
