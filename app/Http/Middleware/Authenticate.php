<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(auth()->user() && auth()->user()->user_type==0){
                return route('user_login');
            }
            else if(auth()->user() && auth()->user()->user_type==1){
                return route('user_login');
            }
            else{
                return route('user_login');
            }
        }
    }
}
