<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Helper;

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
        if (Helper::isAdmin()) {
            return $next($request);
        }

        return redirect(route('home'))->with('error','You do not have admin access.');
    }
}
