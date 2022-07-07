<?php

namespace App\Http\Controllers;

use App\Models\autorisation;
use App\Models\caisse;
use App\Models\don;
use App\Models\emprunt;
use App\Models\emprunt_apayer;
use App\Models\fichier_don;
use App\Models\fichier_pret;
use App\Models\fichier_rbs;
use App\Models\members;
use App\Models\muso;
use App\Models\paiement_emprunt;
use App\Models\partenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class contributionCtrl extends Controller
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
        $all_emprunt = emprunt::where('musos_id', $this->id_muso())->get();
        $partenaires = partenaire::where('musos_id', $this->id_muso())->get();
        return view('contribution.index', compact('partenaires', 'all_emprunt'));
    }

    public function remboursement()
    {
        $all_emprunt = emprunt::where('musos_id', $this->id_muso())->get();
        $partenaires = partenaire::where('musos_id', $this->id_muso())->get();
        return view('contribution.remboursement', compact('partenaires', 'all_emprunt'));
    }

    public function remboursement_id($id)
    {

        $montanttotal = paiement_emprunt::where('id_emprunt_apayers', $id)->sum('montant');

        $mont = emprunt::where('id', $id)->first();

        $montant_res = $mont->montanttotal - $montanttotal;

        $emprunt_id = emprunt::select('emprunts.montant', 'emprunts.description', 'emprunts.intere_mensuel', 'emprunts.pmensuel', 'emprunts.montanttotal',
            'emprunts.ttalmensuel', 'emprunts.duree', 'emprunts.pourcentage_interet',
            'emprunts.duree', 'settings.curency', 'emprunts.id as id_emprunts', 'emprunt_apayers.date_paiement')
            ->join('emprunt_apayers', 'emprunt_apayers.emprunts_id', '=', 'emprunts.id')
            ->join('settings', 'settings.musos_id', '=', 'emprunts.musos_id')
            ->where('emprunt_apayers.paiement', 'false')
            ->where('emprunts.id', $id)
            ->orderByDesc('emprunt_apayers.created_at')->first();

        $paiement = emprunt_apayer::where('emprunts_id', $id)->where('paiement', 'false')->first();

        return view('contribution.remboursement_byId', compact('emprunt_id', 'montant_res', 'paiement'));
    }

    public function voir_pay_emprunt($id)
    {

        $don = don::select('don.titre', 'don.montant', 'don.date_decaissement', 'don.numero_cb', 'don.description', 'partenaires.name', 'don.id as id_don')
            ->join('partenaires', 'partenaires.id', '=', 'don.partenaire_id')
            ->join('settings', 'settings.musos_id', '=', 'don.musos_id')
            ->where('don.id', $id)->first();
        $paiement = emprunt_apayer::select('emprunt_apayers.emprunts_id', 'settings.curency', 'emprunt_apayers.paiement', 'emprunt_apayers.date_paiement', 'emprunt_apayers.pmensuel', 'emprunt_apayers.intere_mensuel',
            'emprunt_apayers.id as id_emprunt_apayer', 'emprunt_apayers.ttalmensuel', 'emprunt_apayers.ttalmensuel')
            ->join('settings', 'settings.musos_id', '=', 'emprunt_apayers.musos_id')
            ->where('emprunt_apayers.emprunts_id', $id)->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('contribution.index', compact('don', 'autorisation', 'paiement'));
    }
    public function voir_don($id)
    {

        $don = don::select('don.titre', 'don.montant', 'don.date_decaissement', 'don.numero_cb', 'don.description', 'partenaires.name', 'don.id as id_don')
            ->join('partenaires', 'partenaires.id', '=', 'don.partenaire_id')
            ->join('settings', 'settings.musos_id', '=', 'don.musos_id')
            ->where('don.id', $id)->first();
        $partenaires = partenaire::where('musos_id', $this->id_muso())->get();
        $fichier = fichier_don::where('don_id', $id)->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('contribution.index', compact('don', 'partenaires', 'autorisation', 'fichier'));
    }

    public function voir_emprunt($id)
    {

        $emprunt = emprunt::select('partenaires.name', 'partenaires.id as id_partenaire', 'emprunts.titre', 'emprunts.date_decaissement',
            'emprunts.montant', 'emprunts.description', 'emprunts.intere_mensuel', 'emprunts.pmensuel', 'emprunts.montanttotal',
            'emprunts.ttalmensuel', 'emprunts.duree', 'emprunts.pourcentage_interet', 'emprunts.duree', 'settings.curency', 'emprunts.id as id_emprunts')
            ->join('partenaires', 'partenaires.id', '=', 'emprunts.partenaire_id')
            ->join('settings', 'settings.musos_id', '=', 'emprunts.musos_id')
            ->where('emprunts.id', $id)->first();

        $fichier = fichier_pret::where('emprunts_id', $id)->get();
        $partenaires = partenaire::where('musos_id', $this->id_muso())->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')->where('autorisations.musos_id', $this->id_muso())->first();
        return view('contribution.index', compact('emprunt', 'autorisation', 'fichier', 'partenaires'));
    }

    public function save_don(Request $request)
    {

        $request->validate([
            'partenaire_id' => ['required', 'string'],
            'titre' => ['required', 'string'],
            'montant' => ['required', 'string'],
            'date_decaissement' => ['required', 'string'],
            'numero_cb' => ['string'],
            'description' => ['string'],
        ]);

        $id_don = don::create([
            'musos_id' => $this->id_muso(),
            'partenaire_id' => $request->partenaire_id,
            'titre' => $request->titre,
            'montant' => $request->montant,
            'date_decaissement' => $request->date_decaissement,
            'numero_cb' => $request->numero_cb,
            'description' => $request->description,
        ])->id;

        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();
        caisse::where('musos_id', $this->id_muso())->update([
            'caisseBleue' => $caisse_info->caisseBleue + $request->montant,
        ]);

        return redirect('voir-don/' . $id_don);

    }

    public function save_fichier(Request $request)
    {

        $request->validate([
            'file.*' => 'mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {

            foreach ($request->file('file') as $key => $file) {

                $file->store('all-images', 'public');
                $fichier = $file->hashName();
                $extension = $file->extension();

                $insert[$key]['fichier'] = $fichier;
                $insert[$key]['type'] = $extension;
                $insert[$key]['don_id'] = $request->id;

            }

            fichier_don::insert($insert);

        }

        return redirect()->back()->with("success", " Fichier ajouter");

    }

    public function save_fichier_pret(Request $request)
    {

        $request->validate([
            'file.*' => 'mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {

            foreach ($request->file('file') as $key => $file) {

                $file->store('all-images', 'public');
                $fichier = $file->hashName();
                $extension = $file->extension();

                $insert[$key]['fichier'] = $fichier;
                $insert[$key]['type'] = $extension;
                $insert[$key]['emprunts_id'] = $request->id;

            }

            fichier_pret::insert($insert);

        }

        return redirect()->back()->with("success", " Fichier ajouter");

    }

    public function save_empruts(Request $request)
    {

        $request->validate([
            'partenaire_id' => ['required', 'string'],
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

        $id_emprunt = emprunt::create([
            'musos_id' => $this->id_muso(),
            'partenaire_id' => $request->partenaire_id,
            'titre' => $request->titre,
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
            'description' => $request->description,

        ])->id;
        $count = 0;

        for ($i = 0; $request->duree > $i; $i++) {
            $count++;
            $date = date('Y-m-d', strtotime($request->date_decaissement . ' + ' . $count . ' months'));
            emprunt_apayer::create([
                'musos_id' => $this->id_muso(),
                'emprunts_id' => $id_emprunt,
                'pmensuel' => $pmensuel,
                'intere_mensuel' => $intere_mensuel,
                'ttalmensuel' => $ttalmensuel,
                'paiement' => 'false',
                'date_paiement' => $date,
            ]);

        }

        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();
        caisse::where('musos_id', $this->id_muso())->update([
            'caisseBleue' => $caisse_info->caisseBleue + $request->montant,
        ]);

        return redirect()->back()->with("success", " Emprunt ajouter");

    }

    public function montanttotal($emprunt_apayers_id, $balance_tt_pret, $montanttotal)
    {

        $emprunt_global = emprunt::where('id', $emprunt_apayers_id)->first();
        $sum_montant = paiement_emprunt::where('id_emprunt_apayers', $emprunt_apayers_id)->sum('montant');
        if ($sum_montant > 0) {
            return $balance_tt_pret = $montanttotal - $sum_montant;
        } else {
            return $balance_tt_pret = $montanttotal - $emprunt_global->ttalmensuel;
        }

    }

    public function save_remboursement(Request $request)
    {

        $caisse_info = caisse::where('musos_id', $this->id_muso())->first();

        $montanttotal = paiement_emprunt::where('id_emprunt_apayers', $request->emprunt_apayers_id)->sum('montant');

        $mont = emprunt::where('id', $request->emprunt_apayers_id)->first();

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

        if ($caisse_info->caisseBleue > $request->montant) {

            if ($request->date_du_paiement > $request->date_pay) {
                $date_pay = "En Avance";
            } elseif ($request->date_paiement == $request->date_pay) {
                $date_pay = "A l'heure";
            } else {
                $date_pay = "En Retard";
            }

            $emprunt_global = emprunt::where('id', $request->emprunt_apayers_id)->first();

            $paiement_emprunt = paiement_emprunt::where('id_emprunt_apayers', $request->emprunt_apayers_id)
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

                            $id_p = paiement_emprunt::create([
                                'id_emprunt_apayers' => $request->emprunt_apayers_id,
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

                            $id_p = paiement_emprunt::create([
                                'id_emprunt_apayers' => $request->emprunt_apayers_id,
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

                            $emprunt = emprunt_apayer::where('paiement', 'false')->where('emprunts_id', $request->emprunt_apayers_id)->first();
                            emprunt_apayer::where('id', $emprunt->id)->update([
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

                        $emprunt = emprunt_apayer::where('paiement', 'false')->where('emprunts_id', $request->emprunt_apayers_id)->first();

                        $id_p = paiement_emprunt::create([
                            'id_emprunt_apayers' => $request->emprunt_apayers_id,
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

                        emprunt_apayer::where('id', $emprunt->id)->update([
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

                        $emprunt = emprunt_apayer::where('paiement', 'false')->where('emprunts_id', $request->emprunt_apayers_id)->first();

                        if ($mnt_a_passer > $emprunt->intere_mensuel) {
                            $intereMensuel = $emprunt->intere_mensuel;
                            $principale_payer = $mnt_a_passer - $emprunt->intere_mensuel;
                        } else {
                            $intereMensuel = $mnt_a_passer;
                            $principale_payer = 0;
                        }

                        $balance = $emprunt_global->ttalmensuel - $mnt_a_passer;

                        $id_pp = paiement_emprunt::create([
                            'id_emprunt_apayers' => $request->emprunt_apayers_id,
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
                            emprunt_apayer::where('id', $emprunt->id)->update([
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
                            echo "Montant payé ----- : ", $mnt_paye, "<br>";
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
                            $emprunt = emprunt_apayer::where('paiement', 'false')->where('emprunts_id', $request->emprunt_apayers_id)->first();

                            $id_ps = paiement_emprunt::create([
                                'id_emprunt_apayers' => $request->emprunt_apayers_id,
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
                                emprunt_apayer::where('id', $emprunt->id)->update([
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

            caisse::where('musos_id', $this->id_muso())->update([
                'caisseBleue' => $caisse_info->caisseBleue - $request->montant,
            ]);

            return redirect()->back()->with("success", __("messages.sauvegarde"));
        } else {
            return redirect()->back()->with("Error", __("messages.erreur_remboursement"));
        }

    }

    public function select_empruts(Request $request)
    {

        $request->validate([
            'emprunt' => ['required', 'string'],
        ]);

        $emprunt_id = emprunt::join('emprunt_apayers', 'emprunt_apayers.emprunts_id', '=', 'emprunts.id')
            ->where('emprunt_apayers.emprunts_id', $request->emprunt)
            ->where('emprunt_apayers.paiement', 'false')
            ->orderByDesc('emprunt_apayers.created_at')->distinct()->limit(1)->get();

        $all_emprunt = emprunt::where('musos_id', $this->id_muso())->get();
        return view('contribution.index', compact('emprunt_id', 'all_emprunt'));

    }

    public function fiche_emprunt($id)
    {
        $emprunt_id = emprunt::select('emprunts.titre', 'emprunts.date_decaissement', 'emprunts.montant', 'emprunts.pourcentage_interet',
            'emprunts.duree', 'emprunts.intere_mensuel', 'emprunts.ttalmensuel', 'emprunts.id as id', 'settings.curency', 'emprunts.montanttotal')
            ->join('settings', 'settings.musos_id', '=', 'emprunts.musos_id')->where('emprunts.id', $id)->first();
        return view('contribution.fiche_emprunt', compact('emprunt_id'));
    }

}