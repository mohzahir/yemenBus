<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
        public function handle($request, Closure $next, $guard = null)
        {
            if ($guard == "admin" && Auth::guard($guard)->check()) {
                
                return redirect('/dashboard/admin');
            }
            if ($guard == "marketer" && Auth::guard($guard)->check()) {
                
                return redirect('/marketers/archive');
            } 
            
            if ($guard == "provider" && Auth::guard($guard)->check()) {
                return redirect('/provider/dashboard');
            }
            if ($guard == "lab" && Auth::guard($guard)->check()) {
               
                return redirect('dashboard/lab/index');
            }
         
            /*if (Auth::guard($guard)->check()) {
                return redirect('/login');
            }*/

            return $next($request);
        }
}
