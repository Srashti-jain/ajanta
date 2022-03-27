<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminSellerMiddlware
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
        if(!auth()->user()->getRoleNames()->contains('Customer') && !auth()->user()->getRoleNames()->contains('Blocked') ){

            return $next($request);

        }else{

            return abort('401','Unauthorized action');

        }
        
    }
}
