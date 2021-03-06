<?php

namespace SocialNetwork\Http\Middleware;

use Closure;
use Auth;
class Admin
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
        //check user if login and this user is Admin or not
        if(Auth::check() && Auth::user()->isRole()=="Admin") {
            //if this user really Admin then redirect to their home
            return $next($request);
        }
        //if this is not Admin the redirect to login
        return redirect('login');
    }
}
