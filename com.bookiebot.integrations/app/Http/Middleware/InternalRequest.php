<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InternalRequest
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


        $token = $request->bearerToken();


        if(!$token) {
//            die("Internal Requests must have bearer TOKEN");
        }

        return $next($request);
    }
}
