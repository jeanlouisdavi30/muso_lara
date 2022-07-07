<?php

namespace App\Http\Controllers;

use App\Models\autorisation;
use App\Models\members;
use App\Models\muso;
use App\Models\partenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class partenaires extends Controller
{

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

    public function index()
    {
        $all_partenaires = partenaire::where('musos_id', $this->id_muso())->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('partenaires.index', compact('all_partenaires', 'autorisation'));
    }

    public function voir_partenaire($id)
    {
        $data_partenaire = partenaire::where('id', $id)->first();
        $all_partenaires = partenaire::where('musos_id', $this->id_muso())->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();

        return view('partenaires.index', compact('data_partenaire', 'all_partenaires', 'autorisation'));
    }

    public function save_partenaire(Request $request)
    {

        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'telf' => ['required', 'string'],
            'representant' => ['required', 'string'],
            'email' => ['string'],
            'site_web' => ['string'],
            'text_representant' => ['string'],
        ]);

        if ($request->hasFile('file')) {

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('all-images', 'public');
            $file = $request->file->hashName();

        } else {

            $file = "mologo.png";
        }

        partenaire::create([
            'name' => $request->name,
            'musos_id' => $this->id_muso(),
            'adresse' => $request->adresse,
            'telf' => $request->telf,
            'type' => $request->type,
            'logo' => $file,
            'representant' => $request->representant,
            'email' => $request->email,
            'site_web' => $request->site_web,
            'text_representant' => $request->text_representant,
        ]);

        return redirect()->back()->with("success", " Partenaire ajouter");

    }

    public function eddit_logo(Request $request)
    {

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('file')) {

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('all-images', 'public');
            $file = $request->file->hashName();

        }

        partenaire::where('id', $request->id)->update([

            'logo' => $file,
        ]);

        return redirect()->back()->with("success", " Partenaire ajouter");

    }

    public function eddit_partenaire(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'telf' => ['required', 'string'],
            'representant' => ['required', 'string'],
            'email' => ['string'],
            'site_web' => ['string'],
            'text_representant' => ['string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            partenaire::where('id', $request->id)->update([
                'name' => $request->name,
                'adresse' => $request->adresse,
                'telf' => $request->telf,
                'representant' => $request->representant,
                'email' => $request->email,
                'site_web' => $request->site_web,
                'text_representant' => $request->text_representant,
            ]);
            return response()->json(['status' => 1, 'msg' => 'Partenaire modifier avec succès']);
        }

    }
}