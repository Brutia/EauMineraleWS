<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','chambre',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public function commandes(){
    	return $this->hasMany('App\Commande', 'user_id');
    }
    
    public function routeNotificationForIonicPush()
    {
    	return $this->apiToken->api_token;
    }
    
    public function apiToken(){
    	
    	return $this->hasOne('App\ApiToken', 'user_id');
    }
}
