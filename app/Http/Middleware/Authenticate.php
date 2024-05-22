<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use URL;
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
            $url = URL::current();
            $arr = explode("/", $url);
            if(in_array('api', $arr)){
                return route('401');
            }
            return route('login');
            // return route('401');
        }
    }
    
    
}
