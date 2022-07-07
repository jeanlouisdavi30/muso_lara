<?php

namespace App\Http\Controllers;

use App\Models\autorisation;
use App\Models\caisse;
use App\Models\cotisationCaisse;
use App\Models\depenseCV;
use App\Models\don;
use App\Models\emprunt;
use App\Models\emprunt_apayer;
use App\Models\fichier_don;
use App\Models\fichier_pret;
use App\Models\members;
use App\Models\muso;
use App\Models\partenaire;
use App\Models\pret;
use App\Models\pret_apayer;
use App\Models\transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class autorisationCtrl extends Controller
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

    public function delete(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'password' => ['required'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {

            $membre = autorisation::where('musos_id', $this->id_muso())->first();

            if (Hash::check($request->password, $membre->password)) {
                if ($request->type === 'delete-paiement') {
                    cotisationCaisse::where('id', $request->id)->delete();
                    return response()->json(['status' => 1, 'msg' => 'Paiement supprimer avec succes']);
                } elseif ($request->type === 'delete-depense') {

                    $depenses = depenseCV::where('id', $request->id)->first();
                    $caisse = caisse::where('id', $this->id_muso())->first();
                    caisse::where('musos_id', $this->id_muso())->update([
                        'caisseVert' => $caisse->caisseVert + $depenses->montant,
                    ]);

                    depenseCV::where('id', $request->id)->delete();

                    return response()->json(['status' => 1, 'msg' => 'Depense supprimer avec succes']);
                } elseif ($request->type === 'delete-partenaire') {
                    partenaire::where('id', $request->id)->delete();
                    return response()->json(['status' => 1, 'msg' => 'Partenaire supprimer avec succes']);
                } elseif ($request->type === 'delete-emprunt') {
                    emprunt::where('id', $request->id)->delete();
                    fichier_pret::where('emprunts_id', $request->id)->delete();
                    emprunt_apayer::where('emprunts_id', $request->id)->delete();
                    return response()->json(['status' => 1, 'msg' => 'Emprunt supprimer avec succes']);
                } elseif ($request->type === 'delete-don') {
                    don::where('id', $request->id)->delete();
                    fichier_don::where('don_id', $request->id)->delete();
                    return response()->json(['status' => 1, 'msg' => 'Don supprimer avec succes']);
                } elseif ($request->type === 'delete-pret') {
                    pret::where('id', $request->id)->delete();
                    pret_apayer::where('prets_id', $request->id)->delete();
                    return response()->json(['status' => 1, 'msg' => 'Demande de pret supprimer avec succes']);
                } elseif ($request->type === 'delete-transfert-cr') {

                    $trf = transfer::where('id', $request->id)->first();
                    $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

                    caisse::where('musos_id', $this->id_muso())->update([
                        'caisseRouge' => $caisse_info->caisseRouge + $trf->montant,
                    ]);

                    if ($trf->transfer_caisse == "Caisse-bleue") {
                        caisse::where('musos_id', $this->id_muso())->update([
                            'caisseBleue' => $caisse_info->caisseBleue - $trf->montant,
                        ]);
                    } elseif ($trf->transfer_caisse == "Caisse-vert") {
                        caisse::where('musos_id', $this->id_muso())->update([
                            'caisseVert' => $caisse_info->caisseVert - $trf->montant,
                        ]);
                    }

                    transfer::where('id', $request->id)->delete();

                    return response()->json(['status' => 1, 'msg' => 'Transfer avec succes']);
                } elseif ($request->type === 'delete-transfert-cv') {

                    $trf = transfer::where('id', $request->id)->first();
                    $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

                    caisse::where('musos_id', $this->id_muso())->update([
                        'caisseVert' => $caisse_info->caisseVert + $trf->montant,
                    ]);

                    if ($trf->transfer_caisse == "Caisse-bleue") {
                        caisse::where('musos_id', $this->id_muso())->update([
                            'caisseBleue' => $caisse_info->caisseBleue - $trf->montant,
                        ]);
                    } elseif ($trf->transfer_caisse == "Caisse-rouge") {
                        caisse::where('musos_id', $this->id_muso())->update([
                            'caisseRouge' => $caisse_info->caisseRouge - $trf->montant,
                        ]);
                    }

                    transfer::where('id', $request->id)->delete();

                    return response()->json(['status' => 1, 'msg' => 'Transfer avec succes']);
                } elseif ($request->type === 'delete-transfert-cb') {

                    $trf = transfer::where('id', $request->id)->first();
                    $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

                    caisse::where('musos_id', $this->id_muso())->update([
                        'caisseBleue' => $caisse_info->caisseBleue + $trf->montant,
                    ]);

                    if ($trf->transfer_caisse == "Caisse-rouge") {
                        caisse::where('musos_id', $this->id_muso())->update([
                            'caisseRouge' => $caisse_info->caisseRouge - $trf->montant,
                        ]);
                    } elseif ($trf->transfer_caisse == "Caisse-vert") {
                        caisse::where('musos_id', $this->id_muso())->update([
                            'caisseVert' => $caisse_info->caisseVert - $trf->montant,
                        ]);
                    }

                    transfer::where('id', $request->id)->delete();

                    return response()->json(['status' => 1, 'msg' => 'Transfer avec succes']);
                }

            } else {
                return response()->json(['status' => 1, 'msg' => 'Mauvais mot de passe']);
            }

        }

    }
}