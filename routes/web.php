<?php
use App\Http\Controllers\dashboarCtrl;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\MusoController;
use App\Http\Controllers\siteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [siteController::class, 'index'])->name('accueil');

Route::get('create-muso', [MusoController::class, 'index'])->name('creation muso');
Route::post('save-muso', [MusoController::class, 'store'])->name('save.muso');

Route::middleware(['verified'])->get('/ajouter-membre', [MembreController::class, 'ajouter'])->name('ajouter-membre');
Route::middleware(['verified'])->get('/lister-membre', [MembreController::class, 'lister'])->name('lister-membre');
Route::middleware(['verified'])->post('/update-membre', [MembreController::class, 'update'])->name('update-membre');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/change-language/{lang}', "\App\Http\Controllers\dashboarCtrl@changeLang");
    Route::middleware(['verified'])->get('/ajouter-membre', [MembreController::class, 'ajouter'])->name('ajouter-membre');
    Route::get('/partenaires', [App\Http\Controllers\partenaires::class, 'index'])->name('partenaires');

    Route::group(['middleware' => 'ChangePWM'], function () {
        Route::get('dashboard', [dashboarCtrl::class, 'index'])->name('dashboard');
        Route::get('/parametre-muso', [App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('parametre-muso');

    });

    Route::post('save-membre', [MembreController::class, 'store'])->name('save.membre');
    Route::resource('decision', 'App\Http\Controllers\DecisionCtrl');
    Route::resource('rencontre', 'App\Http\Controllers\rencontreCtrl')->middleware('CheckFI');
    Route::get('/proces/{id}', [App\Http\Controllers\rencontreCtrl::class, 'proces'])->name('proces');
    Route::get('/modifier-proces/{id}', [App\Http\Controllers\rencontreCtrl::class, 'proces'])->name('modifier-proces');
    Route::get('/voir-proces/{id}', [App\Http\Controllers\rencontreCtrl::class, 'voir_proces'])->name('voir-proces');
    Route::post('/save-proces', [App\Http\Controllers\rencontreCtrl::class, 'save_proces'])->name('save-proces');
    Route::post('/save-proces-update', [App\Http\Controllers\rencontreCtrl::class, 'modifier_proces'])->name('save-proces-update');
    Route::post('/save-vote', [App\Http\Controllers\DecisionCtrl::class, 'save_vote'])->name('save-vote');

    Route::get('/member-info/{id}', [App\Http\Controllers\MembreController::class, 'member_info'])->name('member.info');
    Route::get('/mDP/{id}', [App\Http\Controllers\MembreController::class, 'mdp'])->name('mDP');
    Route::get('/update-member/{id}', [App\Http\Controllers\MembreController::class, 'update_member'])->name('update.member');
    Route::get('/delete-member/{id}', [App\Http\Controllers\MembreController::class, 'delete_member'])->name('delete.member');
    Route::post('/md-password-membre', [App\Http\Controllers\MembreController::class, 'md_pass_membre'])->name('modifier.pass.membre');
    Route::post('/ulpoad-photo-membre', [App\Http\Controllers\MembreController::class, 'upload_photo_m'])->name('ulpoad.photo.membre');
    Route::get('/transaction-membre/{id}', [App\Http\Controllers\MembreController::class, 'transaction'])->name('transaction-membre');

    Route::get('/reload-profile', [App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-profile');
    Route::get('/reload-parametre', [App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-parametre');
    Route::get('/reload-adresse', [App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-adresse');
    Route::get('/reload-autorisation', [App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-autorisation');

    Route::post('/changePassword', [App\Http\Controllers\parametreMusoCtrl::class, 'changePasswordPost'])->name('changePasswordPost');
    Route::post('/update-profil', [App\Http\Controllers\parametreMusoCtrl::class, 'update_profil'])->name('update-profil');
    Route::post('/save-profil', [App\Http\Controllers\parametreMusoCtrl::class, 'save_profil'])->name('save-profil');
    Route::post('/save-parametre', [App\Http\Controllers\parametreMusoCtrl::class, 'save_parametre'])->name('save-parametre');
    Route::post('/update-adresse', [App\Http\Controllers\parametreMusoCtrl::class, 'updateAdresse'])->name('update-adresse');
    Route::post('/update-info-muso', [App\Http\Controllers\parametreMusoCtrl::class, 'updateMuso_info'])->name('update-info-muso');
    Route::post('/save-autorisation', [App\Http\Controllers\parametreMusoCtrl::class, 'save_autorisation'])->name('save-autorisation');
    Route::post('/update-caisse', [App\Http\Controllers\parametreMusoCtrl::class, 'update_caisse'])->name('update-caisse');
    Route::post('/save-reglement', [App\Http\Controllers\parametreMusoCtrl::class, 'save_reglement'])->name('save-reglement');
    Route::get('/reglement-mutuel', [App\Http\Controllers\parametreMusoCtrl::class, 'reglement'])->name('reglement-mutuel');
    Route::get('/reglement-eddit/{id}', [App\Http\Controllers\parametreMusoCtrl::class, 'reglement_edit'])->name('reglement-eddit');

    Route::get('/partenaires', [App\Http\Controllers\partenaires::class, 'index'])->name('partenaires');
    Route::post('/save-partenaire', [App\Http\Controllers\partenaires::class, 'save_partenaire'])->name('save-partenaire');
    Route::get('/voir-partenaire/{id}', [App\Http\Controllers\partenaires::class, 'voir_partenaire'])->name('voir-partenaire');
    Route::get('/nouveau-partenaires', [App\Http\Controllers\partenaires::class, 'index'])->name('nouveau-partenaires');
    Route::post('/modifier-partenaire', [App\Http\Controllers\partenaires::class, 'eddit_partenaire'])->name('modifier-partenaire');
    Route::post('/modifier-logo-partenaire', [App\Http\Controllers\partenaires::class, 'eddit_logo'])->name('modifier-logo-partenaire');

    Route::group(['middleware' => 'CheckFI'], function () {

        Route::get('/cotisation-cv', [App\Http\Controllers\caisseVertCtrl::class, 'cotisation_vert'])->name('cotisation-caisse-vert');
        Route::post('/paiement-cotisation-cv', [App\Http\Controllers\caisseVertCtrl::class, 'save_paiement'])->name('paiement-caisse-vert');
        Route::post('/rencontre-cotisation', [App\Http\Controllers\caisseVertCtrl::class, 'rencontre_cotisation'])->name('rencontre-cotisation');

        Route::post('/liste-paiement-ccv', [App\Http\Controllers\caisseVertCtrl::class, 'search_pbc'])->name('liste-paiement-ccv');
        Route::get('/supprimer-paiment-ccv/{id}', [App\Http\Controllers\caisseVertCtrl::class, 'destroy'])->name('supprimer-paiment-ccv');
        Route::post('/delete-paiement', [App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-paiement');
        Route::post('/save-autre-paiement', [App\Http\Controllers\caisseVertCtrl::class, 'save_autre_paiement'])->name('save-autre-paiement');

        Route::get('/cotisation-cr', [App\Http\Controllers\caisseRougeCtrl::class, 'cotisation_rouge'])->name('cotisation-caisse-rouge');
        Route::post('/paiement-cotisation-cr', [App\Http\Controllers\caisseRougeCtrl::class, 'save_paiement'])->name('paiement-caisse-rouge');
        Route::post('/rencontre-cotisation-cr', [App\Http\Controllers\caisseRougeCtrl::class, 'rencontre_cotisation'])->name('rencontre-cotisation-cr');

        Route::post('/liste-paiement-ccr', [App\Http\Controllers\caisseRougeCtrl::class, 'search_pbc'])->name('liste-paiement-ccr');
        Route::get('/supprimer-paiment-ccr/{id}', [App\Http\Controllers\caisseRougeCtrl::class, 'destroy'])->name('supprimer-paiment-ccr');
        Route::post('/delete-paiement-cr', [App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-paiement-cr');
        Route::post('/save-autre-paiement-cr', [App\Http\Controllers\caisseRougeCtrl::class, 'save_autre_paiement'])->name('save-autre-paiement-cr');

        Route::get('/retrait-cr', [App\Http\Controllers\retraitcrCtrl::class, 'index'])->name('retrait-cr');
        Route::post('/save-retrait', [App\Http\Controllers\retraitcrCtrl::class, 'save_retrait'])->name('save-retrait');
        Route::get('/voir-depense/{id}', [App\Http\Controllers\retraitcrCtrl::class, 'voir_depense'])->name('voir-depense');
        Route::post('/modifier-depense', [App\Http\Controllers\retraitcrCtrl::class, 'eddit_depense'])->name('modifier-depense');
        Route::post('/rapport-depense-cr', [App\Http\Controllers\retraitcrCtrl::class, 'rapport_depense'])->name('rapport-depense-cr');
        Route::get('/rapport-depense-cr', [App\Http\Controllers\retraitcrCtrl::class, 'index'])->name('rapport-depense');
        Route::get('/lister-depense', [App\Http\Controllers\retraitcrCtrl::class, 'index'])->name('lister-depense');

        Route::get('/depense-cv', [App\Http\Controllers\depensecvCtrl::class, 'index'])->name('depense-cv');
        Route::post('/save-depense', [App\Http\Controllers\depensecvCtrl::class, 'save_depense'])->name('save-depense');
        Route::get('/lister-depense-cv', [App\Http\Controllers\depensecvCtrl::class, 'index'])->name('lister-depense-cv');
        Route::get('/voir-depense-cv/{id}', [App\Http\Controllers\depensecvCtrl::class, 'voir_depense'])->name('voir-depense-cv');
        Route::post('/modifier-depense-cv', [App\Http\Controllers\depensecvCtrl::class, 'eddit_depense'])->name('modifier-depense-cv');
        Route::get('/rapport-depensecv', [App\Http\Controllers\depensecvCtrl::class, 'index'])->name('rapport-depensecv');
        Route::post('/rapport-depense-cv', [App\Http\Controllers\depensecvCtrl::class, 'rapport_depense'])->name('rapport-depense-cv');
        Route::post('/delete-autorisation', [App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-autorisation');

        Route::get('/contribution', [App\Http\Controllers\contributionCtrl::class, 'index'])->name('contribution');
        Route::get('/nouveau-don', [App\Http\Controllers\contributionCtrl::class, 'index'])->name('nouveau-don');
        Route::get('/nouveau-pret', [App\Http\Controllers\contributionCtrl::class, 'index'])->name('nouveau-pret');
        Route::post('/save-don', [App\Http\Controllers\contributionCtrl::class, 'save_don'])->name('save-don');
        Route::get('/voir-don/{id}', [App\Http\Controllers\contributionCtrl::class, 'voir_don'])->name('voir-don');
        Route::post('/ajouter-fichier-don', [App\Http\Controllers\contributionCtrl::class, 'save_fichier'])->name('ajouter-fichier-don');
        Route::post('/save-empruts', [App\Http\Controllers\contributionCtrl::class, 'save_empruts'])->name('save-empruts');
        Route::get('/voir-emprunt/{id}', [App\Http\Controllers\contributionCtrl::class, 'voir_emprunt'])->name('voir-emprunt');
        Route::post('/ajouter-fichier-pret', [App\Http\Controllers\contributionCtrl::class, 'save_fichier_pret'])->name('ajouter-fichier-pret');
        Route::get('/voir-paiement-emprunt/{id}', [App\Http\Controllers\contributionCtrl::class, 'voir_pay_emprunt'])->name('voir-paiement-emprunt');
        Route::post('/save-paiement-emprunts', [App\Http\Controllers\contributionCtrl::class, 'save_paiement_emprunts'])->name('save-paiement-emprunts');
        Route::get('/remboursement', [App\Http\Controllers\contributionCtrl::class, 'remboursement'])->name('remboursement');
        Route::get('/remboursement-id/{id}', [App\Http\Controllers\contributionCtrl::class, 'remboursement_id'])->name('remboursement-id');
        Route::post('/save-remboursement', [App\Http\Controllers\contributionCtrl::class, 'save_remboursement'])->name('save-remboursement');
        Route::post('/select-empruts', [App\Http\Controllers\contributionCtrl::class, 'select_empruts'])->name('select-empruts');

        Route::get('/fiche-emprunt/{id}', [App\Http\Controllers\contributionCtrl::class, 'fiche_emprunt'])->name('fiche-emprunt');

        Route::get('/transfert-cv', [App\Http\Controllers\transfertCtrl::class, 'caisse_verte'])->name('transfert-cv');
        Route::post('/save-transfert', [App\Http\Controllers\transfertCtrl::class, 'save_transfert'])->name('save-transfert');
        Route::post('/delete-transfer', [App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-transfer');
        Route::get('/nouveau-transfert', [App\Http\Controllers\transfertCtrl::class, 'caisse_verte'])->name('nouveau-transfert');
        Route::get('/voir-transfert-cv/{id}', [App\Http\Controllers\transfertCtrl::class, 'voir_transfert_cv'])->name('voir-transfert-cv');

        Route::get('/transfert-cr', [App\Http\Controllers\transfertCtrl::class, 'caisse_rouge'])->name('transfert-cr');
        Route::get('/nouveau-transfert-cr', [App\Http\Controllers\transfertCtrl::class, 'caisse_rouge'])->name('nouveau-transfert-cr');
        Route::post('/save-transfert-cr', [App\Http\Controllers\transfertCtrl::class, 'save_transfert_cr'])->name('save-transfert-cr');
        Route::get('/voir-transfert-cr/{id}', [App\Http\Controllers\transfertCtrl::class, 'voir_transfert_cr'])->name('voir-transfert-cr');

        Route::get('/transfert-cb', [App\Http\Controllers\transfertCtrl::class, 'caisse_blue'])->name('transfert-cb');
        Route::get('/nouveau-transfert-cb', [App\Http\Controllers\transfertCtrl::class, 'caisse_blue'])->name('nouveau-transfert-cb');
        Route::post('/save-transfert-cb', [App\Http\Controllers\transfertCtrl::class, 'save_transfert_cb'])->name('save-transfert-cb');
        Route::get('/voir-transfert-cb/{id}', [App\Http\Controllers\transfertCtrl::class, 'voir_transfert_cb'])->name('voir-transfert-cb');

        Route::get('/pret', [App\Http\Controllers\pretCtrl::class, 'index'])->name('pret');
        Route::get('/demande-pret', [App\Http\Controllers\pretCtrl::class, 'index'])->name('demande-pret');
        Route::get('/voir-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'voirpret'])->name('voir-pret');
        Route::post('/save-demande-pret', [App\Http\Controllers\pretCtrl::class, 'save_pret'])->name('save-demande-pret');
        Route::post('/update-demande-pret', [App\Http\Controllers\pretCtrl::class, 'update_pret'])->name('update-demande-pret');
        Route::get('/voir-paiement-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'voir_pay_pret'])->name('voir-paiement-pret');
        Route::get('/fiche-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'fiche_pret'])->name('fiche-pret');
        Route::post('/envoyer-comite', [App\Http\Controllers\pretCtrl::class, 'envoyer_comite'])->name('envoyer-comite');
        Route::post('/gestion-comite', [App\Http\Controllers\pretCtrl::class, 'gestion_comite'])->name('gestion-comite');
        Route::get('/voir-comite/{id}', [App\Http\Controllers\pretCtrl::class, 'voirpret'])->name('voir-comite');
        Route::get('/voir-echeance-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'voir_echeance_pret'])->name('voir-echeance-pret');
        Route::get('/modifier-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'voirpret'])->name('modifier-pret');
        Route::get('/approuver-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'voirpret'])->name('approuver-pret');
        Route::post('/approuver-demande-pret', [App\Http\Controllers\pretCtrl::class, 'aaprouve_DP'])->name('approuver-demande-pret');

        Route::post('/autorisation-decaissement-pret', [App\Http\Controllers\decaissementCtrl::class, 'update_pret'])->name('autorisation-decaissement-pret');
        Route::get('/decaisse-pret/{id}', [App\Http\Controllers\decaissementCtrl::class, 'voirpret'])->name('decaisse-pret');
        Route::get('/decaissement', [App\Http\Controllers\decaissementCtrl::class, 'index'])->name('decaissement');
        Route::get('/voir-pret-encours/{id}', [App\Http\Controllers\decaissementCtrl::class, 'voirpret'])->name('voir-pret-encours');
        Route::get('/remboursement-pret/{id}', [App\Http\Controllers\pretCtrl::class, 'remboursement'])->name('remboursement-pret');
        Route::post('/save-remboursement-pret', [App\Http\Controllers\pretCtrl::class, 'save_remboursement'])->name('save-remboursement-pret');

        Route::get('/modifier-info/{id}', [App\Http\Controllers\MembreController::class, 'member_info'])->name('modifier-info');
        Route::get('/modifier-password/{id}', [App\Http\Controllers\MembreController::class, 'member_info'])->name('modifier-password');

    });

});

require __DIR__ . '/auth.php';