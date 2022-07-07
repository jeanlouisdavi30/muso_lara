<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePWM
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
        $user_info = user::where('id', Auth::user()->id)
            ->where('changePW', 'true')->get();

        if (Auth::user()->utype == "admin") {
            return $next($request);
        } else {

            if (!$user_info->isEmpty()) {
                return $next($request);
            } else {
                abort(401);
            }

        }

    }
}