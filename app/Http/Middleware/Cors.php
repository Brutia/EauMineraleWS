<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*');
//             ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//             ->header('Access-Control-Allow-Headers', )
//     		->header('Access-Control-Allow-Headers', 'X-XSRF-Token, Origin, X-Requested-With, Content-Type, Accept');
//     		->header('Access-Control-Allow-Headers',"x-access_token, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	}
}
