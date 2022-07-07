<?php

namespace App\Http\Controllers;

use App\Models\cotisationCaisse;
use App\Models\meettings;
use App\Models\members;
use App\Models\muso;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class rencontreCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function proces($id)
    {
        $rencontre = meettings::where('id', $id)->first();
        return view('muso.rencontre.proces', compact('rencontre'));
    }

    public function voir_proces($id)
    {
        $rencontre = meettings::where('id', $id)->first();
        return view('muso.rencontre.voir_proces', compact('rencontre'));
    }

    public function index()
    {

        $all_rencontre = meettings::where('musos_id', $this->id_muso())->get();
        return view('muso.rencontre.index', compact('all_rencontre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_meetting' => ['required', 'string', 'min:10', 'max:255'],
            'date_meetting' => ['required', 'date'],
        ]);

        $membres = members::where('musos_id', $this->id_muso())->get();

        if (!$membres->isEmpty()) {

            $meettings = meettings::create([
                'title_meetting' => $request->title_meetting,
                'date_meetting' => $request->date_meetting,
                'musos_id' => $this->id_muso(),
            ]);

            $montantType = settings::where('musos_id', $this->id_muso())->first();

            if (!empty($request->cr)) {

                foreach ($membres as $key) {
                    cotisationCaisse::create([
                        'members_id' => $key->id,
                        'musos_id' => $this->id_muso(),
                        'meettings_id' => $meettings->id,
                        'montant' => $montantType->cr_cotisation_amount,
                        'type_caisse' => $request->cr,
                    ]);
                }

            }

            if (!empty($request->cv)) {

                foreach ($membres as $key) {
                    cotisationCaisse::create([
                        'members_id' => $key->id,
                        'musos_id' => $this->id_muso(),
                        'meettings_id' => $meettings->id,
                        'montant' => $montantType->cv_cotisation_amount,
                        'type_caisse' => $request->cv,
                    ]);
                }
            }

            return redirect()->back()->with("success", __("messages.sauvegarde"));

        } else {

            return redirect()->back()->with("error", __("messages.error_rencontre"));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $all_rencontre = meettings::where('musos_id', $this->id_muso())->get();
        $rencontre = meettings::where('id', $id)->first();
        return view('muso.rencontre.index', compact('all_rencontre', 'rencontre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_meetting' => ['required', 'string', 'min:10', 'max:255'],
            'date_meetting' => ['required', 'date'],
        ]);
        meettings::where('id', $id)->update([
            'title_meetting' => $request->title_meetting,
            'date_meetting' => $request->date_meetting,
        ]);
        return redirect()->back()->with("success", __("messages.sauvegarde"));
    }

    public function save_proces(Request $request)
    {

        $request->validate([
            'file' => 'mimes:jpeg,png,jpg,gif,pdf,svg|max:20000',
            'proces' => ['required', 'string'],
        ]);

        if ($request->hasFile('file')) {

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('all-images', 'public');

        }

        meettings::where('id', $request->id)->update([
            'proces' => $request->proces,
            'fichier' => $request->file->hashName(),
            'type_fichier' => $request->file->extension(),
        ]);

        return redirect()->back()->with("success", __("messages.sauvegarde"));
    }

    public function modifier_proces(Request $request)
    {

        $request->validate([
            'file' => 'mimes:jpeg,png,jpg,gif,pdf,svg|max:20000',
            'proces' => ['required', 'string'],
        ]);

        if ($request->hasFile('file')) {

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('all-images', 'public');

            meettings::where('id', $request->id)->update([
                'proces' => $request->proces,
                'fichier' => $request->file->hashName(),
                'type_fichier' => $request->file->extension(),
            ]);

        } else {

            meettings::where('id', $request->id)->update([
                'proces' => $request->proces,
                'fichier' => $request->fichier,
            ]);

        }

        return redirect()->back()->with("success", __("messages.sauvegarde"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        meettings::where('id', $id)->delete();
        return Redirect::to('rencontre');
    }
}