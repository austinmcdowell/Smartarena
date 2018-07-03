<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Subscribed
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
        $user = Auth::user();

        if ($user->role != "admin" && !$user->subscribed()) {
            return redirect('/choose-plan');
        }

        return $next($request);
    }
}