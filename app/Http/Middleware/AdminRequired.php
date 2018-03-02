<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminRequired
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

        if ($user->role != "admin") {
            return redirect('/');
        }

        return $next($request);
    }
}
