<?php

namespace App\Http\Controllers;

use App;
use App\Models\address_musos;
use App\Models\autorisation;
use App\Models\caisse;
use App\Models\members;
use App\Models\muso;
use App\Models\profile;
use App\Models\reglement;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class parametreMusoCtrl extends Controller
{
    public function index()
    {
        $id_muso = $this->id_muso();
        $profile = profile::where('musos_id', $this->id_muso())->first();
        $info_muso = muso::where('id', $this->id_muso())->first();
        $settings = settings::where('musos_id', $this->id_muso())->first();
        $caisse = caisse::where('musos_id', $this->id_muso())->first();
        $address_musos = address_musos::where('musos_id', $this->id_muso())->first();
        $members = members::where('musos_id', $this->id_muso())->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();
        return view('muso.parametre.accueil', compact('info_muso', 'caisse', 'id_muso', 'profile', 'settings', 'address_musos', 'members', 'autorisation'));
    }

    public function reglement()
    {
        $reglement = reglement::where('musos_id', $this->id_muso())->first();
        return view('muso.parametre.reglement', compact('reglement'));
    }

    public function reglement_edit($id)
    {
        $reglement = reglement::where('id', $id)->where('musos_id', $this->id_muso())->first();
        return view('muso.parametre.reglementEdit', compact('reglement'));
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

    public function changePasswordPost(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {

            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                // The passwords matches
                return response()->json(['status' => 1, 'msg' => "Your current password does not matches with the password."]);
            }

            if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
                // Current password and new password same
                return response()->json(['status' => 1, 'msg' => "New Password cannot be same as your current password."]);
            }

            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();
            return response()->json(['status' => 1, 'msg' => "Password successfully changed!"]);
        }

    }

    public function save_profil(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'vision' => ['required', 'string'],
            'value' => ['required', 'string'],
            'mission' => ['required', 'string'],
            'presantation' => ['required', 'string'],
        ]);

        if ($request->hasFile('file')) {

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file->store('all-images', 'public');

        }

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            $request->request->add(['musos_id' => $this->id_muso()]);
            $request->request->add(['picture' => $request->file->hashName()]);
            $profile = profile::where('musos_id', $this->id_muso())->get();

            profile::create($request->all());
            return response()->json(['status' => 1, 'msg' => __("messages.sauvegarde")]);

        }

    }

    public function update_profil(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'vision' => ['required', 'string'],
            'value' => ['required', 'string'],
            'mission' => ['required', 'string'],
            'presantation' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            $profile = profile::where('musos_id', $this->id_muso())->get();
            foreach ($profile as $k) {
                $id_profile = $k->id;
            }
            profile::where('id', $id_profile)->update([
                'vision' => $request->vision,
                'value' => $request->value,
                'mission' => $request->mission,
                'presantation' => $request->presantation,
            ]);
            return response()->json(['status' => 1, 'msg' => __("messages.sauvegarde")]);

        }

    }

    public function save_reglement(Request $request)
    {

        $request->validate([
            'reglement' => ['required', 'string'],
        ]);

        if (empty($request->id)) {

            reglement::create([
                'reglement' => $request->reglement,
                'musos_id' => $this->id_muso(),
            ]);

            return redirect()->back()->with("success", __("messages.sauvegarde"));
        } else {

            reglement::where('id', $request->id)->update([
                'reglement' => $request->reglement,
            ]);

            return redirect()->back()->with("success", __("messages.sauvegarde"));

        }

    }

    public function update_caisse(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'caisseBleue' => ['required', 'string'],
            'caisseVert' => ['required', 'string'],
            'caisseRouge' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {

            caisse::where('musos_id', $this->id_muso())->update([
                'caisseBleue' => $request->caisseBleue,
                'caisseVert' => $request->caisseVert,
                'caisseRouge' => $request->caisseRouge,
            ]);
            return response()->json(['status' => 1, 'msg' => 'Caisse modifier avec succès']);

        }

    }

    public function updateAdresse(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'contry' => ['required', 'string'],
            'arondisment' => ['required', 'string'],
            'departement' => ['required', 'string'],
            'city' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            $profile = address_musos::where('musos_id', $this->id_muso())->first();
            if (empty($profile->id)) {
                address_musos::create([
                    'musos_id' => $this->id_muso(),
                    'address' => $request->address,
                    'pays' => $request->contry,
                    'arondisment' => $request->arondisment,
                    'departement' => $request->departement,
                    'city' => $request->city,
                ]);
            } else {

                address_musos::where('id', $profile->id)->update([
                    'musos_id' => $this->id_muso(),
                    'address' => $request->address,
                    'pays' => $request->contry,
                    'arondisment' => $request->arondisment,
                    'departement' => $request->departement,
                    'city' => $request->city,
                ]);
            }

            return response()->json(['status' => 1, 'msg' => __("messages.sauvegarde")]);

        }

    }

    public function updateMuso_info(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name_muso' => ['required', 'string', 'min:5', 'max:255'],
            'phone' => ['required', 'int'],
            'representing' => ['required', 'string'],
            'registered_date' => ['required', 'date'],
            'network' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {

            muso::where('id', $request->id)->update([
                'name_muso' => $request->name_muso,
                'phone' => $request->phone,
                'representing' => $request->representing,
                'registered_date' => $request->registered_date,
                'network' => $request->network,
            ]);
            return response()->json(['status' => 1, 'msg' => __("messages.sauvegarde")]);

        }

    }

    public function save_parametre(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'devise' => ['required', 'string'],
            'meetinginterval' => ['required', 'string', 'min:', 'max:255'],
            'comitypresident' => ['required', 'string', 'min:5', 'max:255'],
            'comitytreasurer' => ['required', 'string', 'min:5', 'max:255'],
            'cvcotisationamount' => ['required', 'string'],
            'crcotisationamount' => ['required', 'string'],
            'language' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {

            $settings = settings::where('musos_id', $this->id_muso())->get();

            if ($settings->isEmpty()) {
                settings::create([
                    'curency' => $request->devise,
                    'meeting_interval' => $request->meetinginterval,
                    'comity_president' => $request->comitypresident,
                    'comity_treasurer' => $request->comitytreasurer,
                    'cv_cotisation_amount' => $request->cvcotisationamount,
                    'cr_cotisation_amount' => $request->crcotisationamount,
                    'musos_id' => $this->id_muso(),
                    'language' => $request->language,
                ]);

            } else {
                foreach ($settings as $k) {
                    $id_settings = $k->id;
                }

                settings::where('id', $id_settings)->update([
                    'curency' => $request->devise,
                    'meeting_interval' => $request->meetinginterval,
                    'comity_president' => $request->comitypresident,
                    'comity_treasurer' => $request->comitytreasurer,
                    'cv_cotisation_amount' => $request->cvcotisationamount,
                    'cr_cotisation_amount' => $request->crcotisationamount,
                    'language' => $request->language,
                ]);
            }

            App::setLocale($request->language);
            session()->put("lang_code", $request->language);
            return redirect()->back();

        }

    }

    public function save_autorisation(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'members_id' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            $check = autorisation::where('musos_id', $this->id_muso())->get();
            if (empty($check)) {
                autorisation::create([
                    'members_id' => $request->members_id,
                    'musos_id' => $this->id_muso(),
                    'password' => Hash::make($request->password),
                ]);
            } else {
                autorisation::where('musos_id', $this->id_muso())->delete();
                autorisation::create([
                    'members_id' => $request->members_id,
                    'musos_id' => $this->id_muso(),
                    'password' => Hash::make($request->password),
                ]);

            }
            return response()->json(['status' => 1, 'msg' => 'Parametre password save avec succès ']);
        }

    }

    public function reload_profile()
    {
        $id_muso = $this->id_muso();
        $profile = profile::where('musos_id', $this->id_muso())->first();
        $info_muso = muso::where('id', $this->id_muso())->first();
        $settings = settings::where('musos_id', $this->id_muso())->first();
        $address_musos = address_musos::where('musos_id', $this->id_muso())->first();
        $members = members::where('musos_id', $this->id_muso())->get();
        $autorisation = autorisation::join('members', 'members.id', '=', 'autorisations.members_id')
            ->where('autorisations.musos_id', $this->id_muso())->first();
        return view('muso.parametre.accueil', compact('info_muso', 'id_muso', 'profile', 'settings', 'address_musos', 'members', 'autorisation'));
    }
}