<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){

           

            if( !auth()->user()->getRoleNames()->contains('Seller') && !auth()->user()->getRoleNames()->contains('Customer') && !auth()->user()->getRoleNames()->contains('Blocked') ){

                
                return $next($request);

            }else{

               

                notify()->error('Access denied !');

                return redirect(route('login'));

            }

        }else{
            return redirect(route('login'));
        }
    }
}
