<?php

namespace App\Http\Controllers;

use App\Models\decision;
use App\Models\meettings;
use App\Models\members;
use App\Models\muso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DecisionCtrl extends Controller
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

    public function all_decision()
    {
        $all_decision = decision::select('decisions.id as id_decision', 'decisions.title_decision',
            'decisions.decision', 'decisions.total_vote',
            'meettings.title_meetting')
            ->join('meettings', 'meettings.id', '=', 'decisions.meettings_id')
            ->where('meettings.musos_id', $this->id_muso())
            ->orderByDesc('decisions.created_at')->get();
        return $all_decision;
    }

    public function index()
    {
        $all_decision = $this->all_decision();
        $all_mettings = meettings::where('musos_id', $this->id_muso())->get();
        return view('muso.decision.index', compact('all_decision', 'all_mettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'title_decision' => ['required', 'string', 'min:10', 'max:255'],
            'decision' => ['required', 'string', 'min:10', 'max:255'],
            'meettings_id' => ['required', 'string'],
        ]);

        // $request->request->add(['musos_id' =>$this->id_muso()]);
        decision::create($request->all());
        return redirect()->back()->with("success", __("messages.sauvegarde"));
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

        $all_decision = $this->all_decision();
        $all_mettings = meettings::where('musos_id', $this->id_muso())->get();

        $decision = decision::select('decisions.id as id_decision',
            'decisions.title_decision',
            'decisions.decision',
            'decisions.total_vote',
            'meettings.id as id_meetting',
            'meettings.title_meetting')
            ->join('meettings', 'meettings.id', '=', 'decisions.meettings_id')
            ->where('decisions.id', $id)->first();

        return view('muso.decision.index', compact('all_decision', 'decision', 'all_mettings'));
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
            'title_decision' => ['required', 'string', 'min:10', 'max:255'],
            'decision' => ['required', 'string', 'min:10', 'max:255'],
            'meettings_id' => ['required', 'string'],
        ]);
        decision::where('id', $id)->update([
            'title_decision' => $request->title_decision,
            'decision' => $request->decision,
            'meettings_id' => $request->meettings_id,
        ]);
        return redirect()->back()->with("success", __("messages.sauvegarde"));
    }

    public function save_vote(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'vote' => ['required'],
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()]);
        } else {
            decision::where('id', $request->id_decision)->update([
                'total_vote' => $request->vote,
            ]);
            return response()->json(['status' => 1, 'msg' => __("messages.sauvegarde")]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        decision::where('id', $id)->delete();
        $all_decision = $this->all_decision();
        $all_mettings = meettings::where('musos_id', $this->id_muso())->get();
        return view('muso.decision.index', compact('all_decision', 'all_mettings'));
    }
}