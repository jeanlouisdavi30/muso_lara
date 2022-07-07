<?php

namespace App\Http\Controllers;

use App\Models\address_musos;
use App\Models\caisse;
use App\Models\members;
use App\Models\muso;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MusoController extends Controller
{

    public function index()
    {
        return view('muso.add_muso');
    }

    public function dash()
    {
        $muso = muso::where('users_id', Auth::user()->id)->first();
        $membre = members::where('musos_id', $muso->id)->get();
        $info_muso = muso::where('id', $muso->id)->first();
        return view('muso.dash', compact('membre', 'info_muso'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'nom_muso' => ['required', 'string', 'min:5', 'max:255'],
            'contry' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->nom_muso,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $muso = muso::create([
            'name_muso' => $request->nom_muso,
            'representing' => 'Null',
            'registered_date' => strftime("%Y/%m/%d"),
            'phone' => $request->phone,
            'network' => 'Null',
            'contry' => $request->contry,
            'users_id' => $user->id,
        ]);

        address_musos::create([
            'address' => 'Null',
            'city' => 'Null',
            'musos_id' => $muso->id,
            'departement' => 'Null',
            'arondisment' => 'Null',
            'pays' => $request->contry,
        ]);

        caisse::create([
            'musos_id' => $muso->id,
            'caisseBleue' => 0,
            'caisseVert' => 0,
            'caisseRouge' => 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

}