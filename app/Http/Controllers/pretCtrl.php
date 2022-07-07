<?php

namespace App\Http\Controllers;

use App\Models\autorisation;
use App\Models\caisse;
use App\Models\comite;
use App\Models\fichier_rbs;
use App\Models\members;
use App\Models\muso;
use App\Models\paiement_pret;
use App\Models\pret;
use App\Models\pretAprouver;
use App\Models\pret_apayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pretCtrl extends Controller
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
        $allprets = pret::where('musos_id', $this->id_muso())->get();
        if (Auth::user()->utype == "admin") {
            $allmembre = members::where('musos_id', $this->id_muso())->get();
        } else {
            $info_user = members::select('musos.id as id_muso', 'members.id as id_membre')->join('musos', 'musos.id', '=', 'members.musos_id')
                ->where('members.users_id', Auth::user()->id)->first();
            $allmembre = members::where('id', $info_user->id_membre)->where('musos_id', $this->id_muso())->get();
        }
        return view('prets.index', compact('allmembre', 'allprets'));
    }

    public function aaprouve_DP(Request $request)
    {

        $request->validate([
            'date_decaissement' => ['required', 'string'],
            'montant' => ['required', 'string'],
            'pourcentage_interet' => ['required', 'string'],
            'duree' => ['required', 'string'],
            'pmensuel' => ['required', 'string'],
            'intere_mensuel' => ['required', 'string'],
            'ttalmensuel' => ['required', 'string'],
            'montanttotal' => ['required', 'string'],
        ]);

        $comite = comite::where('prets_id', $request->id_pret)->get();

        if ($comite->isEmpty()) {

            comite::create([
                'musos_id' => $this->id_muso(),
                'prets_id' => $request->id_pret,
                'type' => "Approuver",
            ]);

        } else {

            comite::where('prets_id', $request->id_pret)->update([
                'type' => "Approuver",
            ]);

        }

        pret::where('id', $request->id_pret)->update([
            'statut' => "Approuver",
        ]);

        $date_echeance = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $request->duree . ' months'));
        $pmensuel = floor($request->pmensuel * 100) / 100;
        $intere_mensuel = floor($request->intere_mensuel * 100) / 100;
        $ttalmensuel = floor($request->ttalmensuel * 100) / 100;
        $montanttotal = floor($request->montanttotal * 100) / 100;

        pret::where('id', $request->id_pret)->update([
            'montant' => $request->montant,
            'pourcentage_interet' => $request->pourcentage_interet,
            'duree' => $request->duree,
            'pmensuel' => $pmensuel,
            'date_decaissement' => $request->date_decaissement,
            'intere_mensuel' => $intere_mensuel,
            'ttalmensuel' => $ttalmensuel,
            'montanttotal' => $montanttotal,

        ]);

        pret_apayer::where('prets_id', $request->id_pret)->delete();

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

        pretAprouver::create([
            'musos_id' => $this->id_muso(),
            'prets_id' => $request->id_pret,
            'old_montant' => $request->mt,
            'new_montant' => $request->montant,
        ]);

        return redirect()->back()->with("success", " Prêt Approuver");

    }

    public function update_pret(Request $request)
    {

        $request->validate([
            'membres_id' => ['required', 'string'],
            'titre' => ['required', 'string'],
            'date_decaissement' => ['required', 'string'],
            'montant' => ['required', 'string'],
            'pourcentage_interet' => ['required', 'string'],
            'duree' => ['required', 'string'],
            'pmensuel' => ['required', 'string'],
            'intere_mensuel' => ['required', 'string'],
            'ttalmensuel' => ['required', 'string'],
            'montanttotal' => ['required', 'string'],
        ]);

        $date_echeance = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $request->duree . ' months'));
        $pmensuel = floor($request->pmensuel * 100) / 100;
        $intere_mensuel = floor($request->intere_mensuel * 100) / 100;
        $ttalmensuel = floor($request->ttalmensuel * 100) / 100;
        $montanttotal = floor($request->montanttotal * 100) / 100;

        pret::where('id', $request->id_pret)->update([
            'musos_id' => $this->id_muso(),
            'members_id' => $request->membres_id,
            'titre' => $request->titre,
            'caisse' => $request->caisse,
            'montant' => $request->montant,
            'pourcentage_interet' => $request->pourcentage_interet,
            'duree' => $request->duree,
            'pmensuel' => $pmensuel,
            'date_decaissement' => $request->date_decaissement,
            'intere_mensuel' => $intere_mensuel,
            'ttalmensuel' => $ttalmensuel,
            'montanttotal' => $montanttotal,
            'frais' => $request->frais,
            'echeance' => $date_echeance,
            'utilisation' => $request->utilisation,

        ]);

        pret_apayer::where('prets_id', $request->id_pret)->delete();

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

        return redirect()->back()->with("success", " Prêt Modifier");

    }

    public function save_pret(Request $request)
    {

        $request->validate([
            'membres_id' => ['required', 'string'],
            'caisse' => ['required', 'string'],
            'membres_id' => ['required', 'string'],
            'titre' => ['required', 'string'],
            'date_decaissement' => ['required', 'string'],
            'montant' => ['required', 'string'],
            'pourcentage_interet' => ['required', 'string'],
            'duree' => ['required', 'string'],
            'pmensuel' => ['required', 'string'],
            'intere_mensuel' => ['required', 'string'],
            'ttalmensuel' => ['required', 'string'],
            'montanttotal' => ['required', 'string'],
        ]);

        $date_echeance = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $request->duree . ' months'));
        $pmensuel = floor($request->pmensuel * 100) / 100;
        $intere_mensuel = floor($request->intere_mensuel * 100) / 100;
        $ttalmensuel = floor($request->ttalmensuel * 100) / 100;
        $montanttotal = floor($request->montanttotal * 100) / 100;

        $id_pret = pret::create([
            'musos_id' => $this->id_muso(),
            'members_id' => $request->membres_id,
            'titre' => $request->titre,
            'caisse' => $request->caisse,
            'montant' => $request->montant,
            'pourcentage_interet' => $request->pourcentage_interet,
            'duree' => $request->duree,
            'pmensuel' => $pmensuel,
            'date_decaissement' => $request->date_decaissement,
            'intere_mensuel' => $intere_mensuel,
            'ttalmensuel' => $ttalmensuel,
            'montanttotal' => $montanttotal,
            'frais' => $request->frais,
            'statut' => "Demande",
            'echeance' => $date_echeance,
            'utilisation' => $request->utilisation,

        ])->id;
        $count = 0;

        for ($i = 0; $request->duree > $i; $i++) {
            $count++;
            $date = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $count . ' months'));
            pret_apayer::create([
                'musos_id' => $this->id_muso(),
                'prets_id' => $id_pret,
                'pmensuel' => $pmensuel,
                'intere_mensuel' => $intere_mensuel,
                'ttalmensuel' => $ttalmensuel,
                'paiement' => 'false',
                'date_paiement' => $date,
            ]);

        }

        return redirect()->back()->with("success", " Prêt ajouter");

    }

    public function remboursement($id)
    {

        $montanttotal = paiement_pret::where('id_pret_apayers', $id)->sum('montant');

        $emprunt_global = pret::where('id', $id)->first();

        $montant_res = $emprunt_global->montanttotal - $montanttotal;

        $emprunt_id = pret::select('members.last_name', 'members.first_name', 'members.id as id_membre',
            'prets.titre', 'prets.date_decaissement', 'prets.caisse', 'prets.comite',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets', 'prets.pmensuel', 'prets.intere_mensuel', 'prets.montanttotal')
            ->join('members', 'prets.members_id', '=', 'members.id')
            ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
            ->where('prets.id', $id)->first();
        $paiement = pret_apayer::where('prets_id', $id)->where('paiement', 'false')->first();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('prets.remboursement', compact('emprunt_id', 'autorisation', 'emprunt_global', 'montant_res', 'paiement'));
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

        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('prets.index', compact('pret', 'autorisation'));
    }

    public function voir_echeance_pret($id)
    {

        $paiement = pret_apayer::select('pret_apayers.prets_id', 'settings.curency', 'pret_apayers.paiement', 'pret_apayers.date_paiement',
            'pret_apayers.pmensuel', 'pret_apayers.intere_mensuel',
            'pret_apayers.id as id_pret_apayers', 'pret_apayers.ttalmensuel', 'pret_apayers.ttalmensuel')
            ->join('settings', 'settings.musos_id', '=', 'pret_apayers.musos_id')
            ->where('pret_apayers.prets_id', $id)->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('prets.decaissement', compact('autorisation', 'paiement'));
    }

    public function voir_pay_pret($id)
    {

        $paiement = pret_apayer::select('pret_apayers.prets_id', 'settings.curency', 'pret_apayers.paiement', 'pret_apayers.date_paiement',
            'pret_apayers.pmensuel', 'pret_apayers.intere_mensuel',
            'pret_apayers.id as id_pret_apayers', 'pret_apayers.ttalmensuel', 'pret_apayers.ttalmensuel')
            ->join('settings', 'settings.musos_id', '=', 'pret_apayers.musos_id')
            ->where('pret_apayers.prets_id', $id)->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('prets.index', compact('autorisation', 'paiement'));
    }

    public function fiche_pret($id)
    {
        $pret_id = pret::select('prets.titre', 'prets.date_decaissement', 'prets.montant', 'prets.pourcentage_interet',
            'prets.duree', 'prets.intere_mensuel', 'prets.ttalmensuel', 'members.last_name', 'members.first_name',
            'prets.id as id', 'settings.curency', 'prets.montanttotal')
            ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
            ->join('members', 'members.id', '=', 'prets.members_id')
            ->where('prets.id', $id)->first();
        return view('prets.fiche_emprunt', compact('pret_id'));
    }

    public function envoyer_comite(Request $request)
    {

        $request->validate([
            'id_prets' => ['required', 'string'],
        ]);

        pret::where('id', $request->id_prets)->update([
            'comite' => 'true',
            'statut' => 'en comité',
        ]);

        return redirect()->back()->with("success", " Envoyer en comite");

    }

    public function gestion_comite(Request $request)
    {

        $request->validate([
            'id_prets' => ['required', 'string'],
            'type' => ['required', 'string'],
        ]);

        pret::where('id', $request->id_prets)->update([
            'statut' => $request->type,
        ]);

        $comite = comite::where('prets_id', $request->id_prets)->get();

        if ($comite->isEmpty()) {

            comite::create([
                'musos_id' => $this->id_muso(),
                'prets_id' => $request->id_prets,
                'type' => $request->type,
            ]);

        } else {

            comite::where('prets_id', $request->id_prets)->update([
                'type' => $request->type,
            ]);

        }

        if ($request->type == "Approuver") {
            $mesaj = "Le Prêt est approuver";
        } elseif ($request->type == "Rejeter") {
            $mesaj = "Le Prêt est a ete rejeter";
        } elseif ($request->type == "En attente") {
            $mesaj = "Prêt En attente";
        }

        return redirect()->back()->with("success", $mesaj);

    }

    public function save_remboursement(Request $request)
    {

        $montanttotal = paiement_pret::where('id_pret_apayers', $request->emprunt_apayers_id)->sum('montant');

        $mont = pret::where('id', $request->emprunt_apayers_id)->first();

        $montant_res = $mont->montanttotal - $montanttotal;

        $request->validate([
            'file.*' => 'nullable|sometimes|mimes:png,jpg,jpeg,pdf|max:2048',
            'emprunt_apayers_id' => ['required'],
            'date_pay' => ['required'],
            'numeropc' => ['required'],
            'montant' => ['required', 'lte:' . $montant_res],
            'interet_payer' => ['required'],
            'principale_payer' => ['required'],
            'balance_versement' => ['required'],
            'balance_tt_pret' => ['required'],
        ]);

        if ($request->date_du_paiement > $request->date_pay) {
            $date_pay = "En Avance";
        } elseif ($request->date_paiement == $request->date_pay) {
            $date_pay = "A l'heure";
        } else {
            $date_pay = "En Retard";
        }

        $emprunt_global = pret::where('id', $request->emprunt_apayers_id)->first();

        $paiement_emprunt = paiement_pret::where('id_pret_apayers', $request->emprunt_apayers_id)
            ->limit(1)->orderBy('id', 'Desc')->get();

        $pay = 1;

        if (!$paiement_emprunt->isEmpty()) {

            foreach ($paiement_emprunt as $p) {

                echo "Premier insert </br>";
                echo $p->balance_versement . "</br>";

                if ($p->balance_versement == 0) {
                    $versement_cash = $request->montant;
                } else {

                    $vers = $request->montant - $p->balance_versement;

                    if ($vers < 0) {

                        $versement_cash = $request->montant;

                        $id_p = paiement_pret::create([
                            'id_pret_apayers' => $request->emprunt_apayers_id,
                            'musos_id' => $this->id_muso(),
                            'date_du_paiement' => $p->date_du_paiement,
                            'date_pay' => $request->date_pay,
                            'numeropc' => $request->numeropc,
                            'montant' => $versement_cash,
                            'interet_payer' => 0,
                            'principale_payer' => $versement_cash,
                            'balance_versement' => $p->balance_versement - $request->montant,
                            'balance_tt_pret' => $request->balance_tt_pret,
                            'description' => $request->description,
                            'statut' => $date_pay,
                        ])->id;

                        if ($request->hasFile('file')) {

                            foreach ($request->file('file') as $key => $file) {

                                $file->store('all-images', 'public');
                                $fichier = $file->hashName();
                                $extension = $file->extension();

                                $insert[$key]['fichier'] = $fichier;
                                $insert[$key]['type'] = $extension;
                                $insert[$key]['paiement_emprunts_id'] = $id_p;

                            }

                            fichier_rbs::insert($insert);

                        }

                        $pay = 0;

                    } else {

                        echo "vse: " . $versement_cash = $request->montant - $p->balance_versement;

                        if ($versement_cash == $emprunt_global->ttalmensuel) {
                            $pay = 1;
                        } elseif ($versement_cash == 0) {
                            echo "p: " . $pay = 0;
                        } else {
                            echo "p: " . $pay = 1;
                        }

                        $id_p = paiement_pret::create([
                            'id_pret_apayers' => $request->emprunt_apayers_id,
                            'musos_id' => $this->id_muso(),
                            'date_du_paiement' => $p->date_du_paiement,
                            'date_pay' => $request->date_pay,
                            'numeropc' => $request->numeropc,
                            'montant' => $p->balance_versement,
                            'interet_payer' => 0,
                            'principale_payer' => $p->balance_versement,
                            'balance_versement' => 0,
                            'balance_tt_pret' => $request->balance_tt_pret,
                            'description' => $request->description,
                            'statut' => $date_pay,
                        ])->id;

                        $emprunt = pret_apayer::where('paiement', 'false')->where('prets_id', $request->emprunt_apayers_id)->first();
                        pret_apayer::where('id', $emprunt->id)->update([
                            'paiement' => 'true',
                        ]);

                        if ($request->hasFile('file')) {

                            foreach ($request->file('file') as $key => $file) {

                                $file->store('all-images', 'public');
                                $fichier = $file->hashName();
                                $extension = $file->extension();

                                $insert[$key]['fichier'] = $fichier;
                                $insert[$key]['type'] = $extension;
                                $insert[$key]['paiement_emprunts_id'] = $id_p;

                            }

                            fichier_rbs::insert($insert);

                        }

                    }

                }

            }

        } else { $versement_cash = $request->montant;}

        $bal_sur_paiement = 0;
        $mnt_paye = $versement_cash;
        $mnt_versement = $emprunt_global->ttalmensuel;
        $mnt_a_passer = 0;

        do {
            if ($mnt_paye > $mnt_versement) {

                if ($bal_sur_paiement >= $mnt_versement || $bal_sur_paiement == 0) {
                    $mnt_a_passer = $mnt_versement;
                } else {
                    $mnt_a_passer = $bal_sur_paiement;
                }

                echo "Montant payé: ", $mnt_paye, "<br>";

                $bal_sur_paiement = $mnt_paye - $mnt_versement;
                echo "balance sur paiement: ", $bal_sur_paiement, "<br>";
                echo "Montant à passer: ", $mnt_a_passer, "<p>";

                $mnt_paye = $bal_sur_paiement;

                if ($mnt_a_passer == $emprunt_global->ttalmensuel) {

                    $emprunt = pret_apayer::where('paiement', 'false')->where('prets_id', $request->emprunt_apayers_id)->first();

                    $id_p = paiement_pret::create([
                        'id_pret_apayers' => $request->emprunt_apayers_id,
                        'musos_id' => $this->id_muso(),
                        'date_du_paiement' => $emprunt->date_paiement,
                        'date_pay' => $request->date_pay,
                        'numeropc' => $request->numeropc,
                        'montant' => $mnt_a_passer,
                        'interet_payer' => $emprunt->intere_mensuel,
                        'principale_payer' => $emprunt->pmensuel,
                        'balance_versement' => $request->balance_versement,
                        'balance_tt_pret' => $request->balance_tt_pret,
                        'description' => $request->description,
                        'statut' => $date_pay,
                    ])->id;

                    pret_apayer::where('id', $emprunt->id)->update([
                        'paiement' => 'true',
                    ]);

                    if ($request->hasFile('file')) {

                        foreach ($request->file('file') as $key => $file) {

                            $file->store('all-images', 'public');
                            $fichier = $file->hashName();
                            $extension = $file->extension();

                            $insert[$key]['fichier'] = $fichier;
                            $insert[$key]['type'] = $extension;
                            $insert[$key]['paiement_emprunts_id'] = $id_p;

                        }

                        fichier_rbs::insert($insert);

                    }

                }

            } else {

                if ($bal_sur_paiement > 0) {

                    $mnt_a_passer = $bal_sur_paiement;
                    $bal_sur_paiement = 0;
                    echo "Montant payé: test ", $mnt_paye, "<br>";
                    echo "balance sur paiement: ", $bal_sur_paiement, "<br>";
                    echo "Montant à passer: ", $mnt_a_passer, "<p>";

                    $emprunt = pret_apayer::where('paiement', 'false')->where('prets_id', $request->emprunt_apayers_id)->first();

                    if ($mnt_a_passer > $emprunt->intere_mensuel) {
                        $intereMensuel = $emprunt->intere_mensuel;
                        $principale_payer = $mnt_a_passer - $emprunt->intere_mensuel;
                    } else {
                        $intereMensuel = $mnt_a_passer;
                        $principale_payer = 0;
                    }

                    $balance = $emprunt_global->ttalmensuel - $mnt_a_passer;

                    $id_pp = paiement_pret::create([
                        'id_pret_apayers' => $request->emprunt_apayers_id,
                        'musos_id' => $this->id_muso(),
                        'date_du_paiement' => $emprunt->date_paiement,
                        'date_pay' => $request->date_pay,
                        'numeropc' => $request->numeropc,
                        'montant' => $mnt_a_passer,
                        'interet_payer' => $intereMensuel,
                        'principale_payer' => $principale_payer,
                        'balance_versement' => $balance,
                        'balance_tt_pret' => $request->balance_tt_pret,
                        'description' => $request->description,
                        'statut' => $date_pay,
                    ])->id;

                    if ($balance == 0) {
                        pret_apayer::where('id', $emprunt->id)->update([
                            'paiement' => 'true',
                        ]);

                    }

                    if ($request->hasFile('file')) {

                        foreach ($request->file('file') as $key => $file) {

                            $file->store('all-images', 'public');
                            $fichier = $file->hashName();
                            $extension = $file->extension();

                            $insert[$key]['fichier'] = $fichier;
                            $insert[$key]['type'] = $extension;
                            $insert[$key]['paiement_emprunts_id'] = $id_pp;

                        }

                        fichier_rbs::insert($insert);

                    }

                } else {

                    echo "payer : " . $pay;
                    if ($pay == 1) {

                        $mnt_a_passer = $mnt_paye;
                        $bal_sur_paiement = 0;
                        echo "Montant payé \\\\----- : ", $mnt_paye, "<br>";
                        echo "balance sur paiement: ", $bal_sur_paiement, "<br>";
                        echo "Montant à passer: ", $mnt_a_passer, "<p>";

                        if ($mnt_paye > $emprunt_global->intere_mensuel) {
                            $interet_payer = $emprunt_global->intere_mensuel;
                            $principale_payer = $mnt_paye - $emprunt_global->intere_mensuel;
                            $balance = $emprunt_global->ttalmensuel - $mnt_paye;
                        } else {
                            $interet_payer = $mnt_paye;
                            $principale_payer = 0;
                            $balance = $emprunt_global->ttalmensuel - $mnt_paye;
                        }

                        $balance = $emprunt_global->ttalmensuel - $mnt_a_passer;
                        $emprunt = pret_apayer::where('paiement', 'false')->where('prets_id', $request->emprunt_apayers_id)->first();

                        $id_ps = paiement_pret::create([
                            'id_pret_apayers' => $request->emprunt_apayers_id,
                            'musos_id' => $this->id_muso(),
                            'date_du_paiement' => $emprunt->date_paiement,
                            'date_pay' => $request->date_pay,
                            'numeropc' => $request->numeropc,
                            'montant' => $mnt_a_passer,
                            'interet_payer' => $interet_payer,
                            'principale_payer' => $principale_payer,
                            'balance_versement' => $balance,
                            'balance_tt_pret' => $request->balance_tt_pret,
                            'description' => $request->description,
                            'statut' => $date_pay,
                        ])->id;

                        if ($balance == 0) {
                            pret_apayer::where('id', $emprunt->id)->update([
                                'paiement' => 'true',
                            ]);
                        }

                        if ($request->hasFile('file')) {

                            foreach ($request->file('file') as $key => $file) {

                                $file->store('all-images', 'public');
                                $fichier = $file->hashName();
                                $extension = $file->extension();

                                $insert[$key]['fichier'] = $fichier;
                                $insert[$key]['type'] = $extension;
                                $insert[$key]['paiement_emprunts_id'] = $id_ps;

                            }

                            fichier_rbs::insert($insert);

                        }

                    }

                }

            }

        } while ($bal_sur_paiement > 0);

        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();
        if ($request->caisse == "Caisse-bleue") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseBleue' => $caisse_info->caisseBleue + $request->montant,
            ]);
        } elseif ($request->caisse == "Caisse-vert") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseVert' => $caisse_info->caisseVert + $request->montant,
            ]);
        } elseif ($request->caisse == "Caisse-rouge") {
            caisse::where('musos_id', $this->id_muso())->update([
                'caisseRouge' => $caisse_info->caisseRouge + $request->montant,
            ]);
        }

        return redirect()->back()->with("success", " Paiment ajouter");

    }
}