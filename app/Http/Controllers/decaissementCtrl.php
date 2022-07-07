<?php

namespace App\Http\Controllers;

use App\Models\caisse;
use App\Models\members;
use App\Models\muso;
use App\Models\pret;
use App\Models\pret_apayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class decaissementCtrl extends Controller
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
        if (Auth::user()->utype == "admin") {
            $all_pret = pret::join('members', 'prets.members_id', '=', 'members.id')
                ->join('comites', 'comites.prets_id', '=', 'prets.id')
                ->where('prets.musos_id', $this->id_muso())
                ->where('comites.type', 'Approuver')
                ->get();
        } else {

            $info_user = members::select('musos.id as id_muso', 'members.id as id_member')->join('musos', 'musos.id', '=', 'members.musos_id')
                ->where('members.users_id', Auth::user()->id)->first();

            $all_pret = pret::join('members', 'prets.members_id', '=', 'members.id')
                ->join('comites', 'comites.prets_id', '=', 'prets.id')
                ->where('prets.musos_id', $this->id_muso())
            //->where('prets.members_id', '4')
                ->where('comites.type', 'Approuver')
                ->get();
        }
        return view('prets.decaissement', compact('all_pret'));
    }

    public function voirpret($id)
    {

        $pret = pret::select('members.last_name', 'members.first_name', 'members.id as id_membre',
            'prets.titre', 'prets.date_decaissement', 'prets.caisse', 'prets.comite',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets', 'prets.pmensuel', 'prets.intere_mensuel', 'prets.montanttotal')
            ->join('members', 'prets.members_id', '=', 'members.id')
            ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
            ->where('prets.id', $id)->first();

        return view('prets.decaissement', compact('pret'));
    }

    public function update_pret(Request $request)
    {

        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

        if ($request->caisse == "Caisse-vert") {
            $caisse_value = $caisse_info->caisseVert;
        } elseif ($request->caisse == "Caisse-rouge") {
            $caisse_value = $caisse_info->caisseRouge;
        } elseif ($request->caisse == "Caisse-bleue") {
            $caisse_value = $caisse_info->caisseBleue;
        }

        $request->validate([
            'date_decaissement' => ['required', 'string'],
            'montant' => ['required', 'lte:' . $caisse_value],
        ]);

        if ($request->caisse == "Caisse-vert") {

            caisse::where('musos_id', $this->id_muso())->update([
                'caisseVert' => $caisse_info->caisseVert - $request->montant,
            ]);

        } elseif ($request->caisse == "Caisse-rouge") {

            caisse::where('musos_id', $this->id_muso())->update([
                'caisseRouge' => $caisse_info->caisseRouge - $request->montant,
            ]);

        } elseif ($request->caisse == "Caisse-bleue") {

            caisse::where('musos_id', $this->id_muso())->update([
                'caisseBleue' => $caisse_info->caisseBleue - $request->montant,
            ]);

        }

        pret::where('id', $request->id_pret)->update([
            'date_decaissement' => $request->date_decaissement,
            'statut' => 'En cours',
        ]);

        pret_apayer::where('prets_id', $request->id_pret)->delete();

        $date_echeance = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $request->duree . ' months'));
        $pmensuel = floor($request->pmensuel * 100) / 100;
        $intere_mensuel = floor($request->intere_mensuel * 100) / 100;
        $ttalmensuel = floor($request->ttalmensuel * 100) / 100;
        $montanttotal = floor($request->montanttotal * 100) / 100;

        $count = 0;

        for ($i = 0; $request->duree > $i; $i++) {
            $count++;
            $date = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $count . ' months'));
            pret_apayer::create([
                'musos_id' => $this->id_muso(),
                'prets_id' => $request->id_pret,
                'pmensuel' => $pmensuel,
                'intere_mensuel' => $intere_mensuel,
                'ttalmensuel' => $ttalmensuel,
                'paiement' => 'false',
                'date_paiement' => $date,
            ]);

        }

        return redirect()->back()->with("success", " Prêt Decaisser");

    }
}