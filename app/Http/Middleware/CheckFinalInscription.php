<?php

namespace App\Http\Middleware;

use App\Models\members;
use App\Models\muso;
use App\Models\settings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFinalInscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function id_muso()
    {
        if (Auth::user()->utype == "admin") {
            $info_user = muso::where('users_id', Auth::user()->id)->get();
            foreach ($info_user as $k) {
                return $id_muso = $k->id;
            }
        } else {
            $info_user = members::select('musos.id as id_muso')->join('musos', 'musos.id', '=', 'members.musos_id')
                ->where('members.users_id', Auth::user()->id)->get();
            foreach ($info_user as $k) {
                return $id_muso = $k->id_muso;
            }
        }
    }

    public function handle(Request $request, Closure $next)
    {
        $settings = settings::where('musos_id', $this->id_muso())->get();
        if (!$settings->isEmpty()) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}