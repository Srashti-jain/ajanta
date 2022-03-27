<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Nwidart\Modules\Facades\Module;

class IsVendor
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

        if (Auth::check()) {

            $auth = Auth::user();

            if (auth()->user()->getRoleNames() && auth()->user()->getRoleNames()->contains('Seller')) {

                if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled()){
                    
                    if (getPlanStatus() == 1) {
                       
                         return $next($request);
    
                    } else {
                        notify()->error('Please subscribe a plan to continue !');
                        return redirect(route('front.seller.plans'));
                        
                    }

                }else{
                    return $next($request);
                }

            } else {

                return abort(401, 'Access denied');

            }

        } else {

            return abort(401, 'Access denied');

        }

    }
}
