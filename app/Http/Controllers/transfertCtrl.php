<?php

namespace App\Http\Controllers;

use App\Models\autorisation;
use App\Models\caisse;
use App\Models\cotisationCaisse;
use App\Models\depenseCV;
use App\Models\don;
use App\Models\emprunt;
use App\Models\members;
use App\Models\muso;
use App\Models\paiement_emprunt;
use App\Models\settings;
use App\Models\transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class transfertCtrl extends Controller
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

    public function caisse_rouge()
    {

        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();

        $settings = settings::where('musos_id', $this->id_muso())->first();

        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'Caisse-rouge')->get();

        $transfer_entrants = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-rouge')->get();

        return view('caisseRouge.transfert', compact('transfer', 'settings', 'autorisation', 'transfer_entrants'));
    }

    public function caisse_verte()
    {

        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();

        $settings = settings::where('musos_id', $this->id_muso())->first();

        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'caisse-vert')->get();

        $transfer_entrants = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-verte')->get();

        return view('caisseVert.transfert', compact('transfer', 'settings', 'autorisation', 'transfer_entrants'));
    }

    public function caisse_blue()
    {
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();
        $settings = settings::where('musos_id', $this->id_muso())->first();
        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'caisse-blue')->get();
        $transfer_entrants = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-bleue')->get();
        return view('caisseblue.transfert', compact('transfer', 'settings', 'autorisation', 'transfer_entrants'));
    }

    public function voir_transfert_cb($id)
    {
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();
        $settings = settings::where('musos_id', $this->id_muso())->first();

        $transfer_id = transfer::where('id', $id)->first();
        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'caisse-blue')->get();
        $transfer_entrants = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-bleue')->get();
        return view('caisseblue.transfert', compact('settings', 'autorisation', 'transfer_id', 'transfer_entrants', 'transfer'));
    }

    public function voir_transfert_cv($id)
    {
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();
        $settings = settings::where('musos_id', $this->id_muso())->first();

        $transfer_id = transfer::where('id', $id)->first();
        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'caisse-vert')->get();
        $transfer_entrants = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-verte')->get();
        return view('caisseVert.transfert', compact('settings', 'autorisation', 'transfer_id', 'transfer_entrants', 'transfer'));
    }

    public function voir_transfert_cr($id)
    {
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();
        $settings = settings::where('musos_id', $this->id_muso())->first();

        $transfer_id = transfer::where('id', $id)->first();

        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'caisse-rouge')->get();

        $transfer_entrants = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-rouge')->get();

        return view('caisseRouge.transfert', compact('settings', 'autorisation', 'transfer_id', 'transfer_entrants', 'transfer'));
    }

    public function somme_cv()
    {

        $cotisation_caisses = cotisationCaisse::where('type_caisse', 'caisse-vert')
            ->where('pay', 'true')
            ->where('musos_id', $this->id_muso())->sum('montant');
        $depensecv = depenseCV::where('musos_id', $this->id_muso())->sum('montant');

        $transfer_retraire = transfer::where('caisse', 'Caisse-vert')->where('musos_id', $this->id_muso())->sum('montant');

        $transfer = transfer::where('transfer_caisse', 'Caisse-verte')->where('musos_id', $this->id_muso())->sum('montant');

        $somme_caisse = $cotisation_caisses + $transfer;

        if ($transfer_retraire > $depensecv) {
            $rest = $transfer_retraire - $depensecv;
        } else {
            $rest = $depensecv - $transfer_retraire;
        }
        return $somme_caisse - $rest;

    }

    public function somme_cb()
    {

        $don = don::where('musos_id', $this->id_muso())->sum('montant');
        $emprunt = emprunt::where('musos_id', $this->id_muso())->sum('montant');

        $transfer = transfer::where('musos_id', $this->id_muso())
            ->where('transfer_caisse', 'Caisse-bleue')->sum('montant');

        $retraire_transfer = transfer::where('musos_id', $this->id_muso())
            ->where('caisse', 'Caisse-blue')->sum('montant');

        $paiement_emprunts = paiement_emprunt::where('musos_id', $this->id_muso())->sum('montant');

        $somme_caisse = $don + $emprunt + $transfer;

        return $somme_caisse - $paiement_emprunts - $retraire_transfer;

    }

    public function save_transfert(Request $request)
    {
        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

        $request->validate([
            'date_entre' => ['required', 'date'],
            'titre' => ['required', 'string'],
            'montant' => ['required', 'lte:' . $caisse_info->caisseVert],
            'caisse' => ['required', 'string'],
            'transfer_caisse' => ['string'],
        ]);

        transfer::create([
            'musos_id' => $this->id_muso(),
            'date_entre' => $request->date_entre,
            'titre' => $request->titre,
            'montant' => $request->montant,
            'caisse' => $request->caisse,
            'transfer_caisse' => $request->transfer_caisse,
            'detail' => $request->detail,
        ]);

        caisse::where('musos_id', $this->id_muso())->update([
            'caisseVert' => $caisse_info->caisseVert - $request->montant,
        ]);

        if ($request->transfer_caisse == "Caisse-bleue") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseBleue' => $caisse_info->caisseBleue + $request->montant,
            ]);
        } elseif ($request->transfer_caisse == "Caisse-rouge") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseRouge' => $caisse_info->caisseRouge + $request->montant,
            ]);
        }

        return redirect()->back()->with("success", " Transfert reussir avec succès ");

    }

    public function save_transfert_cr(Request $request)
    {
        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

        $request->validate([
            'date_entre' => ['required', 'date'],
            'titre' => ['required', 'string'],
            'montant' => ['required', 'lte:' . $caisse_info->caisseVert],
            'caisse' => ['required', 'string'],
            'transfer_caisse' => ['string'],
        ]);

        transfer::create([
            'musos_id' => $this->id_muso(),
            'date_entre' => $request->date_entre,
            'titre' => $request->titre,
            'montant' => $request->montant,
            'caisse' => $request->caisse,
            'transfer_caisse' => $request->transfer_caisse,
            'detail' => $request->detail,
        ]);

        caisse::where('musos_id', $this->id_muso())->update([
            'caisseRouge' => $caisse_info->caisseRouge - $request->montant,
        ]);

        if ($request->transfer_caisse == "Caisse-bleue") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseBleue' => $caisse_info->caisseBleue + $request->montant,
            ]);
        } elseif ($request->transfer_caisse == "Caisse-vert") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseVert' => $caisse_info->caisseVert + $request->montant,
            ]);
        }

        return redirect()->back()->with("success", " Transfert reussir avec succès ");

    }

    public function save_transfert_cb(Request $request)
    {

        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

        $request->validate([
            'date_entre' => ['required', 'date'],
            'titre' => ['required', 'string'],
            'montant' => ['required', 'lte:' . $caisse_info->caisseBleue],
            'caisse' => ['required', 'string'],
            'transfer_caisse' => ['string'],
        ]);

        transfer::create([
            'musos_id' => $this->id_muso(),
            'date_entre' => $request->date_entre,
            'titre' => $request->titre,
            'montant' => $request->montant,
            'caisse' => $request->caisse,
            'transfer_caisse' => $request->transfer_caisse,
            'detail' => $request->detail,
        ]);

        caisse::where('musos_id', $this->id_muso())->update([
            'caisseBleue' => $caisse_info->caisseBleue - $request->montant,
        ]);

        if ($request->transfer_caisse == "Caisse-verte") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseVert' => $caisse_info->caisseVert + $request->montant,
            ]);
        } elseif ($request->transfer_caisse == "Caisse-rouge") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseRouge' => $caisse_info->caisseRouge + $request->montant,
            ]);
        }

        return redirect()->back()->with("success", " Transfert reussir avec succès ");

    }

}