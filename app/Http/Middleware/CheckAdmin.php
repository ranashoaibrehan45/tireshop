<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class CheckAdmin
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

        Log::info("CheckAdmin");
        Log::info(print_r($user, true));

        if(!$user || ($user && $user->role !== 'admin'))
        {
            return redirect('/#/login');
        }
        return $next($request);
    }
}
