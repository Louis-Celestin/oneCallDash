<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkCaissiere
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->usertype == 'caissiere') {
            # code...
            return $next($request);
        }
        abort(401,  "Vous n'avez pas le droit d'accès ici.");   
    }
}
