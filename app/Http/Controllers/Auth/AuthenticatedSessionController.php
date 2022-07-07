<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\members;
use App\Models\muso;
use App\Models\settings;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        if (Auth::user()->utype == "admin") {
            $info_muso = muso::where('users_id', Auth::user()->id)->first();
            $settings = settings::where('musos_id', $info_muso->id)->first();

            if (!empty($settings)) {
                $langue = $settings->language;
            } else {
                $langue = "fr";
            }

        } else {

            $info_muso = members::select('musos.id as id_muso')
                ->join('musos', 'musos.id', '=', 'members.musos_id')
                ->where('members.users_id', Auth::user()->id)->first();

            $settings = settings::where('musos_id', $info_muso->id_muso)->first();
            if (!empty($settings)) {
                $langue = $settings->language;
            } else {
                $langue = "fr";
            }

        }

        App::setLocale($langue);
        session()->put("lang_code", $langue);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}