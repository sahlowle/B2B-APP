<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if(Auth::check()){
            $user = Auth::user();

            if($user->isAdmin()){
                return redirect()->intended(route('dashboard'));
            }elseif($user->isVendor()){
                return redirect()->intended(route('vendor-dashboard'));
            }
            elseif($user->isCustomer()){
                 return redirect()->intended(route('site.dashboard'));
            }
        }

        return $next($request);
    }
}
