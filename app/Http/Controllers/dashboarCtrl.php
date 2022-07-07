<?php

namespace App\Http\Controllers;

use App;
use App\Models\members;
use App\Models\muso;
use Illuminate\Support\Facades\Auth;

class dashboarCtrl extends Controller
{

    public function changeLang($langcode)
    {
        App::setLocale($langcode);
        session()->put("lang_code", $langcode);
        return redirect()->back();
    }

    public function index()
    {

        if (Auth::user()->utype == "admin") {
            $info_muso = muso::where('users_id', Auth::user()->id)->first();
            return view('muso.dash', compact('info_muso'));
        } else {

            $info_muso = members::select('members.last_name', 'members.first_name', 'musos.name_muso',
                'musos.representing', 'musos.phone', 'musos.registered_date', 'musos.contry', 'musos.id as id_muso', 'members.musos_id')
                ->join('musos', 'musos.id', '=', 'members.musos_id')
                ->where('members.users_id', Auth::user()->id)->first();
            $info_muso = muso::where('id', $info_muso->id_muso)->first();
            return view('muso.dash', compact('info_muso'));
        }

    }
}