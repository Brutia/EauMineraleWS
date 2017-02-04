<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
class ApiToken extends Model
{
    use Notifiable;
    
    public function routeNotificationForIonicPush()
    {
    	return $this->api_token;
    }
    public function commande(){
    	return $this->hasMany('App\Commande');
    }
    
}
