<?php

namespace App\Http\Controllers;

use App\Models\caisse;
use App\Models\depenseCV;
use App\Models\fichierDepenseCV;
use App\Models\muso;
use App\Models\members;
use DateTime;
use App\Models\autorisation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class depensecvCtrl extends Controller
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

        return view('caisseVert.retrait');

    }

    public function voir_depense($id)
    {

        $depenses = depenseCV::where('id', $id)->first();
        $fichier = fichierDepenseCV::where('depensecv_id', $id)->get();
		$autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
		->where('autorisations.musos_id', $this->id_muso())->first();
        return view('caisseVert.retrait', compact('depenses', 'fichier','autorisation'));

    }

    public function save_depense(Request $request)
    {
        $muso = muso::where('users_id', Auth::user()->id)->first();

        $validation = Validator::make($request->all(), [
            'file.*' => 'mimes:png,jpg,jpeg,pdf|max:10248',
            'description' => ['required', 'string', 'min:10', 'max:255'],
            'date' => ['required', 'date'],
            'montant' => ['required', 'string'],
            'type' => ['required', 'string'],
            'beneficiare' => ['required', 'string'],
            'autre_detail' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {

            $somme_caisse = caisse::where('musos_id', $muso->id)->first();

            if ($somme_caisse->caisseVert > $request->montant) {

                $id_depense = depenseCV::create([
                    'musos_id' => $muso->id,
                    'description' => $request->description,
                    'date' => $request->date,
                    'montant' => $request->montant,
                    'type' => $request->type,
                    'beneficiare' => $request->beneficiare,
                    'autre_detail' => $request->autre_detail,
                ])->id;

                if ($request->hasFile('file')) {

                    foreach ($request->file('file') as $key => $file) {
                        $file->store('all-images', 'public');
                        $fichier = $file->hashName();
                        $extension = $file->extension();

                        $insert[$key]['fichier'] = $fichier;
                        $insert[$key]['type'] = $extension;
                        $insert[$key]['depensecv_id'] = $id_depense;

                    }

                    fichierDepenseCV::insert($insert);

                }

                caisse::where('musos_id', $muso->id)->update([
                    'caisseVert' => $somme_caisse->caisseVert - $request->montant,
                ]);

                return response()->json(['status' => 1, 'msg' => 'Depense Ajouter']);

            } else {
                return response()->json(['status' => 1, 'msg' => 'Error vous navez pas assez dargent dans la caisse rouge']);

            }

        }

    }

    public function eddit_depense(Request $request)
    {
        $muso = muso::where('users_id', Auth::user()->id)->first();

        $validation = Validator::make($request->all(), [
            'description' => ['required', 'string', 'min:10', 'max:255'],
            'date' => ['required', 'date'],
            'montant' => ['required', 'string'],
            'type' => ['required', 'string'],
            'beneficiare' => ['required', 'string'],
            'autre_detail' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            depenseCV::where('id', $request->id)->update([
                'musos_id' => $muso->id,
                'description' => $request->description,
                'date' => $request->date,
                'montant' => $request->montant,
                'type' => $request->type,
                'beneficiare' => $request->beneficiare,
                'autre_detail' => $request->autre_detail,
            ]);
            return response()->json(['status' => 1, 'msg' => 'Depense modifier avec succès']);
        }

    }

    public function rapport_depense(Request $request)
    {
        $muso = muso::where('users_id', Auth::user()->id)->first();
        $request->validate([
            'd1' => ['required', 'date'],
            'd2' => ['required', 'date'],
        ]);

        $d1 = new DateTime($request->d1);
        $d2 = new DateTime($request->d2);

        $rapport = depenseCV::join('settings', 'settings.musos_id', '=', 'depensecv.musos_id')
            ->where('depensecv.musos_id', $muso->id)
            ->where('depensecv.date', '>=', $d1->format('Y-m-d'))
            ->where('depensecv.date', '<=', $d2->format('Y-m-d'))->get();

        $somme = depenseCV::where('depensecv.musos_id', $muso->id)
            ->where('depensecv.date', '>=', $d1->format('Y-m-d'))
            ->where('depensecv.musos_id', $muso->id)
            ->where('depensecv.date', '<=', $d2->format('Y-m-d'))->sum('montant');
        return view('caisseVert.retrait', compact('rapport', 'somme'));

    }
}