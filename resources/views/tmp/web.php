<?php

use App\Models\membre;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboarCtrl;
use App\Http\Controllers\depensecvCtrl;
use App\Http\Controllers\MusoController;
use App\Http\Controllers\siteController;
use App\Http\Controllers\MembreController;

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
Route::post('save-muso',  [MusoController::class, 'store'])->name('save.muso');




Route::middleware(['verified'])->get('/dashboard',[dashboarCtrl::class, 'index'])->name('dashboard');
//Route::middleware(['verified'])->get('/dashboard',[MusoController::class, 'dash'])->name('dashboard');
Route::middleware(['verified'])->get('/ajouter-membre',[MembreController::class, 'ajouter'])->name('ajouter-membre');
Route::middleware(['verified'])->get('/lister-membre',[MembreController::class, 'lister'])->name('lister-membre');
Route::middleware(['verified'])->post('/update-membre',[MembreController::class, 'update'])->name('update-membre');

Route::group(['middleware' => 'auth'], function() {
    Route::post('save-membre',  [MembreController::class, 'store'])->name('save.membre');
    Route::resource('decision','App\Http\Controllers\DecisionCtrl');
    Route::resource('rencontre','App\Http\Controllers\rencontreCtrl');
    Route::get('/member-info/{id}',[App\Http\Controllers\MembreController::class, 'member_info'])->name('member.info');
    Route::get('/update-member/{id}',[App\Http\Controllers\MembreController::class, 'update_member'])->name('update.member');
    Route::get('/delete-member/{id}',[App\Http\Controllers\MembreController::class, 'delete_member'])->name('delete.member');
    Route::post('/md-password-membre',[App\Http\Controllers\MembreController::class, 'md_pass_membre'])->name('modifier.pass.membre');
    Route::post('/ulpoad-photo-membre',[App\Http\Controllers\MembreController::class, 'upload_photo_m'])->name('ulpoad.photo.membre');


    Route::get('/reload-profile',[App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-profile');
    Route::get('/reload-parametre',[App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-parametre');
    Route::get('/reload-adresse',[App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-adresse');
    Route::get('/reload-autorisation',[App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('reload-autorisation');

    Route::get('/parametre-muso',[App\Http\Controllers\parametreMusoCtrl::class, 'index'])->name('parametre-muso');
    Route::post('/changePassword',[App\Http\Controllers\parametreMusoCtrl::class, 'changePasswordPost'])->name('changePasswordPost');
    Route::post('/update-profil',[App\Http\Controllers\parametreMusoCtrl::class, 'update_profil'])->name('update-profil');
    Route::post('/save-profil',[App\Http\Controllers\parametreMusoCtrl::class, 'save_profil'])->name('save-profil');
    Route::post('/save-parametre',[App\Http\Controllers\parametreMusoCtrl::class, 'save_parametre'])->name('save-parametre');
    Route::post('/update-adresse',[App\Http\Controllers\parametreMusoCtrl::class, 'updateAdresse'])->name('update-adresse');
    Route::post('/update-info-muso',[App\Http\Controllers\parametreMusoCtrl::class, 'updateMuso_info'])->name('update-info-muso');
    Route::post('/save-autorisation',[App\Http\Controllers\parametreMusoCtrl::class, 'save_autorisation'])->name('save-autorisation');

    
    Route::get('/cotisation-cv',[App\Http\Controllers\caisseVertCtrl::class, 'cotisation_vert'])->name('cotisation-caisse-vert');
    Route::post('/paiement-cotisation-cv',[App\Http\Controllers\caisseVertCtrl::class, 'save_paiement'])->name('paiement-caisse-vert');
    Route::post('/rencontre-cotisation',[App\Http\Controllers\caisseVertCtrl::class, 'rencontre_cotisation'])->name('rencontre-cotisation');

    Route::post('/liste-paiement-ccv',[App\Http\Controllers\caisseVertCtrl::class, 'search_pbc'])->name('liste-paiement-ccv');
    Route::get('/supprimer-paiment-ccv/{id}',[App\Http\Controllers\caisseVertCtrl::class, 'destroy'])->name('supprimer-paiment-ccv');
    Route::post('/delete-paiement',[App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-paiement');
    Route::post('/save-autre-paiement',[App\Http\Controllers\caisseVertCtrl::class, 'save_autre_paiement'])->name('save-autre-paiement');




    Route::get('/cotisation-cr',[App\Http\Controllers\caisseRougeCtrl::class, 'cotisation_rouge'])->name('cotisation-caisse-rouge');
    Route::post('/paiement-cotisation-cr',[App\Http\Controllers\caisseRougeCtrl::class, 'save_paiement'])->name('paiement-caisse-rouge');
    Route::post('/rencontre-cotisation-cr',[App\Http\Controllers\caisseRougeCtrl::class, 'rencontre_cotisation'])->name('rencontre-cotisation-cr');

    Route::post('/liste-paiement-ccr',[App\Http\Controllers\caisseRougeCtrl::class, 'search_pbc'])->name('liste-paiement-ccr');
    Route::get('/supprimer-paiment-ccr/{id}',[App\Http\Controllers\caisseRougeCtrl::class, 'destroy'])->name('supprimer-paiment-ccr');
    Route::post('/delete-paiement-cr',[App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-paiement-cr');
    Route::post('/save-autre-paiement-cr',[App\Http\Controllers\caisseRougeCtrl::class, 'save_autre_paiement'])->name('save-autre-paiement-cr');

    
    Route::get('/retrait-cr',[App\Http\Controllers\retraitcrCtrl::class, 'index'])->name('retrait-cr');
    Route::post('/save-retrait',[App\Http\Controllers\retraitcrCtrl::class, 'save_retrait'])->name('save-retrait');
    Route::get('/voir-depense/{id}',[App\Http\Controllers\retraitcrCtrl::class, 'voir_depense'])->name('voir-depense');
    Route::post('/modifier-depense',[App\Http\Controllers\retraitcrCtrl::class, 'eddit_depense'])->name('modifier-depense');
    Route::post('/rapport-depense-cr',[App\Http\Controllers\retraitcrCtrl::class, 'rapport_depense'])->name('rapport-depense-cr');
    Route::get('/rapport-depense-cr',[App\Http\Controllers\retraitcrCtrl::class, 'index'])->name('rapport-depense');
    Route::get('/lister-depense',[App\Http\Controllers\retraitcrCtrl::class, 'index'])->name('lister-depense');

    Route::get('/depense-cv',[App\Http\Controllers\depensecvCtrl::class, 'index'])->name('depense-cv');
    Route::post('/save-depense',[App\Http\Controllers\depensecvCtrl::class, 'save_depense'])->name('save-depense');
    Route::get('/lister-depense-cv',[App\Http\Controllers\depensecvCtrl::class, 'index'])->name('lister-depense-cv');
    Route::get('/voir-depense-cv/{id}',[App\Http\Controllers\depensecvCtrl::class, 'voir_depense'])->name('voir-depense-cv');
    Route::post('/modifier-depense-cv',[App\Http\Controllers\depensecvCtrl::class, 'eddit_depense'])->name('modifier-depense-cv');
    Route::get('/rapport-depensecv',[App\Http\Controllers\depensecvCtrl::class, 'index'])->name('rapport-depensecv');
    Route::post('/rapport-depense-cv',[App\Http\Controllers\depensecvCtrl::class, 'rapport_depense'])->name('rapport-depense-cv');
    Route::post('/delete-autorisation',[App\Http\Controllers\autorisationCtrl::class, 'delete'])->name('delete-autorisation');


    Route::get('/partenaires',[App\Http\Controllers\partenaires::class, 'index'])->name('partenaires');
    Route::post('/save-partenaire',[App\Http\Controllers\partenaires::class, 'save_partenaire'])->name('save-partenaire');
    Route::get('/voir-partenaire/{id}',[App\Http\Controllers\partenaires::class, 'voir_partenaire'])->name('voir-partenaire');
	Route::get('/nouveau-partenaires',[App\Http\Controllers\partenaires::class, 'index'])->name('nouveau-partenaires');
    Route::post('/modifier-partenaire',[App\Http\Controllers\partenaires::class, 'eddit_partenaire'])->name('modifier-partenaire');
	Route::post('/modifier-logo-partenaire',[App\Http\Controllers\partenaires::class, 'eddit_logo'])->name('modifier-logo-partenaire');



});

require __DIR__.'/auth.php';