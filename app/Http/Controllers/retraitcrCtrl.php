<?php

namespace App\Http\Controllers;

use App\Models\caisse;
use App\Models\depenseCR;
use App\Models\fichierDepense;
use App\Models\members;
use App\Models\muso;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class retraitcrCtrl extends Controller
{
    public function index()
    {

        return view('caisseRouge.retrait');

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

    public function voir_depense($id)
    {

        $depenses = depenseCR::where('id', $id)->first();
        $fichier = fichierDepense::where('depensecr_id', $id)->get();
        return view('caisseRouge.retrait', compact('depenses', 'fichier'));

    }

    public function save_retrait(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'file.*' => 'mimes:png,jpg,jpeg,pdf|max:2048',
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

            $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

            if ($caisse_info->caisseRouge > $request->montant) {

                $id_depense = depenseCR::create([
                    'musos_id' => $this->id_muso(),
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
                        $insert[$key]['depensecr_id'] = $id_depense;

                    }

                    fichierDepense::insert($insert);

                }
                caisse::where('musos_id', $this->id_muso())->update([
                    'caisseRouge' => $caisse_info->caisseRouge - $request->montant,
                ]);
                return response()->json(['status' => 1, 'msg' => 'Depense Ajouter']);

            } else {
                return response()->json(['status' => 1, 'msg' => 'Erreur vous navez pas assez dargent dans la caisse rouge']);

            }

        }

    }

    public function eddit_depense(Request $request)
    {

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
            depenseCR::where('id', $request->id)->update([
                'musos_id' => $this->id_muso(),
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
        $request->validate([
            'd1' => ['required', 'date'],
            'd2' => ['required', 'date'],
        ]);

        $d1 = new DateTime($request->d1);
        $d2 = new DateTime($request->d2);

        $rapport = depenseCR::join('settings', 'settings.musos_id', '=', 'depensecr.musos_id')
            ->where('depensecr.musos_id', $this->id_muso())
            ->where('depensecr.date', '>=', $d1->format('Y-m-d'))
            ->where('depensecr.date', '<=', $d2->format('Y-m-d'))->get();

        $somme = depenseCR::where('depensecr.musos_id', $this->id_muso())
            ->where('depensecr.date', '>=', $d1->format('Y-m-d'))
            ->where('depensecr.musos_id', $this->id_muso())
            ->where('depensecr.date', '<=', $d2->format('Y-m-d'))->sum('montant');
        return view('caisseRouge.retrait', compact('rapport', 'somme'));

    }

}