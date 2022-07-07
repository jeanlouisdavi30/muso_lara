<?php

namespace App\Http\Controllers;

use App\Models\autorisation;
use App\Models\caisse;
use App\Models\cotisationCaisse;
use App\Models\meettings;
use App\Models\members;
use App\Models\muso;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class caisseRougeCtrl extends Controller
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

    public function all_mettings()
    {
        return meettings::select('meettings.date_meetting', 'meettings.title_meetting', 'meettings.id')->join('cotisation_caisses', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
            ->where('meettings.musos_id', $this->id_muso())
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->orderByDesc('meettings.created_at')->distinct()->get();
    }
    public function membre_meettings($meetting_id)
    {
        return members::select('meettings.title_meetting', 'cotisation_caisses.montant', 'cotisation_caisses.id as id_cotisation_caisses', 'members.last_name', 'members.first_name', 'members.phone', 'members.id as id_member',
            'cotisation_caisses.id as id_cotisation_caisses', 'settings.cv_cotisation_amount', 'settings.curency')
            ->join('cotisation_caisses', 'cotisation_caisses.members_id', '=', 'members.id')
            ->join('meettings', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
            ->join('settings', 'settings.musos_id', '=', 'meettings.musos_id')
            ->where('cotisation_caisses.meettings_id', $meetting_id)
            ->where('cotisation_caisses.musos_id', $this->id_muso())
            ->where('cotisation_caisses.pay', 'false')
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->get();
    }

    public function membre_meettings_pay($meetting_id)
    {
        return members::select('meettings.id', 'cotisation_caisses.musos_id', 'cotisation_caisses.date_paiement', 'meettings.title_meetting', 'cotisation_caisses.montant', 'members.last_name', 'members.first_name', 'members.phone', 'members.id as id_member',
            'cotisation_caisses.id as id_cotisation_caisses', 'settings.cv_cotisation_amount', 'settings.curency')
            ->join('cotisation_caisses', 'cotisation_caisses.members_id', '=', 'members.id')
            ->join('meettings', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
            ->join('settings', 'settings.musos_id', '=', 'meettings.musos_id')
            ->where('cotisation_caisses.meettings_id', $meetting_id)
            ->where('cotisation_caisses.musos_id', $this->id_muso())
            ->where('cotisation_caisses.pay', 'true')
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->get();
    }

    public function all_mettings_paiement()
    {
        return meettings::select('meettings.date_meetting', 'meettings.title_meetting', 'meettings.id')
            ->join('cotisation_caisses', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
            ->where('meettings.musos_id', $this->id_muso())
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->orderByDesc('meettings.created_at')->distinct()->get();
    }

    public function last_meetting()
    {
        return meettings::select('meettings.title_meetting', 'meettings.date_meetting', 'meettings.id')
            ->join('cotisation_caisses', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
            ->where('meettings.musos_id', $this->id_muso())
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->orderByDesc('meettings.created_at')
            ->distinct()
            ->limit(1)
            ->first();
    }

    public function all_mettings_diferen_idmeet($id_meetting)
    {
        return meettings::select('meettings.title_meetting', 'meettings.date_meetting', 'meettings.id')
            ->join('cotisation_caisses', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
            ->where('meettings.musos_id', $this->id_muso())
            ->where('cotisation_caisses.type_caisse', 'caisse-rouge')
            ->where('meettings.id', '!=', $id_meetting)
            ->orderByDesc('meettings.created_at')->distinct()->get();
    }
    public function cotisation_rouge()
    {

        $last_meetting = $this->last_meetting();

        if (!empty($last_meetting)) {
            $id_meetting = $last_meetting->id;
        } else {
            $id_meetting = null;
        }

        $all_mettings = $this->all_mettings_diferen_idmeet($id_meetting);

        $all_mettings_paiement = $this->all_mettings_paiement();

        $membre = $this->membre_meettings($id_meetting);

        return view('caisseRouge.paiement', compact('membre', 'all_mettings', 'last_meetting', 'all_mettings_paiement'));
    }

    public function rencontre_cotisation(Request $request)
    {

        $all_mettings = $this->all_mettings();
        $membre = $this->membre_meettings($request->meettings_id);
        $all_mettings_paiement = $this->all_mettings_paiement();
        return view('caisseRouge.paiement', compact('membre', 'all_mettings', 'all_mettings_paiement'));

    }

    public function save_paiement(Request $request)
    {

        $settings = settings::where('musos_id', $this->id_muso())->first();

        if (!empty($request->id_cotisation_caisses)) {
            foreach ($request->id_cotisation_caisses as $k => $value) {

                cotisationCaisse::where('id', $value)->update([
                    'pay' => 'true',
                    'date_paiement' => strftime("%Y/%m/%d"),
                ]);

                $caisse_info = caisse::where('musos_id', $this->id_muso())->first();
                caisse::where('musos_id', $this->id_muso())->update([
                    'caisseRouge' => $caisse_info->caisseRouge + $request->montant,
                ]);
            }

        }
        $all_mettings = $this->all_mettings();
        $success = "Paiement save";
        $all_mettings_paiement = $this->all_mettings_paiement();
        return view('caisseRouge.paiement', compact('all_mettings', 'success', 'all_mettings_paiement'));

    }

    public function search_pbc(request $request)
    {

        $all_mettings_paiement = $this->all_mettings_paiement();

        $membrePaiemment = $this->membre_meettings_pay($request->meettings_id);
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        $all_mettings = $this->all_mettings();

        return view('caisseRouge.paiement', compact('membrePaiemment', 'all_mettings_paiement', 'autorisation', 'all_mettings'));
    }

    public function destroy($id)
    {
        cotisationCaisse::where('id', $id)->delete();
        return Redirect::to('rencontre');
    }

    public function save_autre_paiement(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'meettings_id' => ['required'],
            'members_id' => ['required'],
            'cotisation' => ['required'],
        ]);

        if ($validation->fails()) {

            $error = 'Erreur ! champ vide ';
            $last_meetting = $this->last_meetting();

            if (!empty($last_meetting)) {
                $id_meetting = $last_meetting->id;
            } else {
                $id_meetting = null;
            }

            $all_mettings = $this->all_mettings_diferen_idmeet($id_meetting);

            $all_mettings_paiement = $this->all_mettings_paiement();

            $membre = $this->membre_meettings($id_meetting);

            return view('caisseRouge.paiement', compact('error', 'membre', 'all_mettings', 'last_meetting', 'all_mettings_paiement'));

        } else {

            $membre = members::where('id', $request->members_id)->first();
            $check = cotisationCaisse::where('members_id', $request->members_id)
                ->where('meettings_id', $request->meettings_id)
                ->where('type_caisse', 'caisse-rouge')
                ->where('pay', 'false')->first();

            if (!empty($check->id)) {
                cotisationCaisse::where('id', $check->id)->update([
                    'pay' => 'true',
                    'montant' => $request->cotisation,
                    'date_paiement' => strftime("%Y/%m/%d"),
                ]);

                $caisse_info = caisse::where('musos_id', $this->id_muso())->first();
                caisse::where('musos_id', $this->id_muso())->update([
                    'caisseRouge' => $caisse_info->caisseRouge + $request->cotisation,
                ]);
                $statut = 'Paiement membre: ' . $membre->first_name . " " . $membre->last_name . " Enregistre avec succes !";
            } else {
                $statut = 'Paiement deja enregistrer';
            }

            $last_meetting = $this->last_meetting();

            if (!empty($last_meetting)) {
                $id_meetting = $last_meetting->id;
            } else {
                $id_meetting = null;
            }

            $all_mettings = $this->all_mettings_diferen_idmeet($id_meetting);

            $all_mettings_paiement = $this->all_mettings_paiement();

            $membre = $this->membre_meettings($id_meetting);

            return view('caisseRouge.paiement', compact('statut', 'membre', 'all_mettings', 'last_meetting', 'all_mettings_paiement'));
        }
    }

}