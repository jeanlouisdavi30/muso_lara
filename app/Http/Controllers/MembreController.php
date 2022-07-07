<?php

namespace App\Http\Controllers;

use App\Models\cotisationCaisse;
use App\Models\members;
use App\Models\muso;
use App\Models\pret;
use App\Models\settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MembreController extends Controller
{
    public function ajouter()
    {
        return view('membre.ajouter');
    }

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

    public function lister()
    {
        $membre = members::where('musos_id', $this->id_muso())->get();
        return view('membre.lister', compact('membre'));
    }

    public function transaction($id)
    {
        $settings = settings::where('musos_id', $this->id_muso())->first();
        $membre = members::where('id', $id)->first();

        $cv = cotisationCaisse::join('meettings', 'meettings.id', '=', 'cotisation_caisses.meettings_id')
            ->join('members', 'members.id', '=', 'cotisation_caisses.members_id')
            ->where('cotisation_caisses.members_id', $id)
            ->where('cotisation_caisses.type_caisse', 'caisse-vert')
            ->where('cotisation_caisses.pay', 'true')->get();

        $pret = pret::where('members_id', $id)
            ->where('statut', 'En cours')
            ->where('musos_id', $this->id_muso())->get();

        $cr = cotisationCaisse::join('meettings', 'meettings.id', '=', 'cotisation_caisses.meettings_id')
            ->join('members', 'members.id', '=', 'cotisation_caisses.members_id')
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->where('cotisation_caisses.members_id', $id)
            ->where('cotisation_caisses.pay', 'true')->get();

        $somme_pret = pret::where('members_id', $id)
            ->where('statut', 'En cours')
            ->where('musos_id', $this->id_muso())->sum('montant');

        $somme_cv = cotisationCaisse::where('members_id', $id)
            ->where('pay', 'true')
            ->where('type_caisse', 'caisse-vert')
            ->where('musos_id', $this->id_muso())->sum('montant');

        $somme_cr = cotisationCaisse::where('members_id', $id)
            ->where('pay', 'true')
            ->where('type_caisse', 'caisse-rouge')
            ->where('musos_id', $this->id_muso())->sum('montant');

        return view('membre.transaction', compact('somme_pret', 'somme_cr', 'somme_cv', 'membre', 'cv', 'pret', 'cr', 'settings'));
    }

    public function store(Request $request)
    {

        $info_user = muso::where('users_id', Auth::user()->id)->get();
        foreach ($info_user as $k) {
            $id_muso = $k->id;
        }
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'sexe' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:255'],
            'type_of_id' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'function' => ['required', 'string', 'max:55'],
            'adresse' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->nom . " " . $request->prenom,
            'email' => $request->email,
            'utype' => $request->function,
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => Hash::make($request->password),
        ]);

        members::create([

            'last_name' => $request->nom,
            'first_name' => $request->prenom,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'musos_id' => $id_muso,

            'date_birth' => $request->date_naissance,
            'type_of_id' => $request->type_of_id,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'function' => $request->function,
            'matrimonial_state' => $request->matrimonial_state,

            'picture' => 'picture.png',
            'users_id' => $user->id,
        ]);

        return redirect()->back()->with("success", __("messages.sauvegarde"));

    }

    public function md_pass_membre(Request $request)
    {

        $request->validate([
            'password' => ['required'],
        ]);

        $members = members::where('id', $request->id)->first();
        User::where('id', $members->users_id)->update([
            'password' => Hash::make($request->password),
            'changePW' => 'true',
        ]);
        return redirect()->back()->with("success_password", __("messages.sauvegarde"));

    }

    public function update(Request $request)
    {

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_birth' => ['required', 'string', 'max:255'],
            'sexe' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'type_of_id' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'matrimonial_state' => ['required', 'string', 'max:255'],
            'function' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        members::where('id', $request->id)->update([
            'last_name' => $request->nom,
            'first_name' => $request->prenom,
            'date_birth' => $request->date_birth,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'phone' => $request->phone,
            'type_of_id' => $request->type_of_id,
            'id_number' => $request->id_number,
            'matrimonial_state' => $request->matrimonial_state,
            'function' => $request->function,
        ]);
        return redirect()->back()->with("success", __("messages.sauvegarde"));

    }

    public function update_member($id)
    {
        $membre = members::where('id', $id)->first();
        return view('membre.update-member', compact('membre'));
    }

    public function member_info($id)
    {
        $membre = members::where('id', $id)->first();
        return view('membre.member-info', compact('membre'));
    }

    public function mdp($id)
    {
        $membre = members::where('id', $id)->first();
        return view('membre.mdp', compact('membre'));
    }

    public function delete_member($id)
    {

        members::where('id', $id)->delete();
        $info_user = muso::where('users_id', Auth::user()->id)->get();
        foreach ($info_user as $k) {
            $id_muso = $k->id;
        }
        $membre = members::where('musos_id', $id_muso)->get();
        return view('membre.lister', compact('membre'));
    }

    public function upload_photo_m(Request $request)
    {

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);

        if ($request->hasFile('file')) {

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('all-images', 'public');

        }

        members::where('id', $request->id)->update([
            'picture' => $request->file->hashName(),
        ]);
        return redirect()->back()->with("success", __("messages.sauvegarde"));
    }
}