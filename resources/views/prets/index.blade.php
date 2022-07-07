@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'pret') {
    $listepret = "active";
} elseif (Request::route()->getName() === 'demande-pret') {
    $demandepret = "active";
} elseif (Request::route()->getName() === 'voir-pret') {
    $voirpret = "active";
} elseif (Request::route()->getName() === 'voir-comite') {
    $voircomite = "active";
} elseif (Request::route()->getName() === 'nouveau-pret') {
    $nouveaupret = "active";
} elseif (Request::route()->getName() === 'voir-echeance-pret') {
    $echeance = "active";
} elseif (Request::route()->getName() === 'modifier-pret') {
    $modifierpret = "active";
} elseif (Request::route()->getName() === 'approuver-pret') {
    $approuverpret = "active";
}

?>

<?php
if (Auth::user()->utype == "admin") {
    $info_muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->id;
} else {
    $info_muso = DB::table('members')->select('members.last_name', 'members.first_name', 'members.id as id_members', 'musos.name_muso',
        'musos.representing', 'musos.phone', 'musos.registered_date', 'musos.contry', 'musos.network', 'members.musos_id')
        ->join('musos', 'musos.id', '=', 'members.musos_id')
        ->where('members.users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->musos_id;

}
?>


<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">

                <div class="alert  alert-dismissible col-md-7">
                    <h2>
                         {{__("messages.pret")}} / {{__("messages.decaissement")}} </h2>
                </div>
                <div class="card">

                    <div class="card-header p-2">

                        <ul class="nav nav-pills">

                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($listepret)) {echo $listepret;}?>" href="#listepret"
                                    data-toggle="tab">{{__("messages.l_demande")}}
                                </a>
                            </li>



                            <?php if (isset($voirpret)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voirpret)) {echo $voirpret;}?>" href="#voirpret"
                                    data-toggle="tab"> {{__("messages.v_demande")}}
                                </a>
                            </li>
                            <?php }?>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($demandepret)) {echo $demandepret;}?>"
                                    href="{{ route('demande-pret')}}">{{__("messages.n_demande")}}
                                </a></li>


                            <li class="nav-item"><a class="nav-link <?php if (isset($comite)) {echo $comite;}?>"
                                    href="#comite" data-toggle="tab"> {{__("messages.Comite")}}
                                </a></li>


                            <?php if (isset($modifierpret)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($modifierpret)) {echo $modifierpret;}?>"
                                    href="#modifierpret" data-toggle="tab"> {{__("messages.mod_demnade")}}
                                </a>
                            </li>
                            <?php }?>

                            <?php if (isset($approuverpret)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($approuverpret)) {echo $approuverpret;}?>"
                                    href="#approuverpret" data-toggle="tab">{{__("messages.apr_pret")}}
                                </a>
                            </li>
                            <?php }?>


                            <?php if (isset($echeance)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($echeance)) {echo $echeance;}?>"
                                    href="#autrePaiement" data-toggle="tab"> {{__("messages.echéancier")}}
                                </a>
                            </li>
                            <?php }?>


                            <?php if (isset($voircomite)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voircomite)) {echo $voircomite;}?>"
                                    href="#voircomite" data-toggle="tab"> {{__("messages.voir_co")}} 
                                </a>
                            </li>
                            <?php }?>

                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">

                            <div class="<?php if (isset($modifierpret)) {echo $modifierpret;}?> tab-pane"
                                id="modifierpret">

                                <script>
                                function sumMP() {

                                    var montant = document.getElementById('montant').value;
                                    var pourcentage = document.getElementById('pourcentage').value;
                                    var dure = document.getElementById('dure').value;

                                    var interet = parseFloat(montant) * parseFloat(pourcentage) / 100;
                                    var rembouse = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('rembourser').value = interet + rembouse;

                                    var pmensuel = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('pmensuel').value = pmensuel;

                                    var intere_mensuel = parseFloat(pourcentage) / 100;

                                    document.getElementById('intere_mensuel').value = intere_mensuel * parseFloat(
                                        montant);
                                    var rembourser = interet + rembouse;
                                    var sommtotal = rembourser * parseFloat(dure);
                                    document.getElementById('sommtotal').value = sommtotal;


                                }
                                </script>

                                <div class="row">
                                    <div class="col-md-6">



                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif


                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        @if(isset($pret))
                                        <!-- /.card-header -->
                                        <form method="post" action="{{ route('update-demande-pret') }}"
                                            accept-charset="utf-8">
                                            @csrf

                                            <input type="hidden" name="id_pret" value="{{ $pret->id_prets}}">

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.caisses")}}</label>
                                                <select name="caisse" class="form-control" required>
                                                    <option value="{{ $pret->caisse}}">
                                                        {{ $pret->caisse}} </option>
                                                    <option value=""> {{__("messages.selectionner")}} {{__("messages.caisses")}} </option>
                                                    <option value="Caisse-vert"> {{__("messages.cv")}} </option>
                                                    <option value="Caisse-rouge"> {{__("messages.cr")}} </option>
                                                    <option value="Caisse-bleue"> {{__("messages.cb")}} </option>
                                                </select>

                                                @error('caisse')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.membres")}}</label>
                                                <select name="membres_id" class="form-control" required>
                                                    <option value="{{ $pret->id_membre}}">
                                                        {{ $pret->last_name}} {{ $pret->first_name}} </option>
                                                    <option value=""> {{__("messages.selectionner")}} {{__("messages.membres")}} </option>
                                                    @if(!empty($membres_id))
                                                    @foreach($allmembre as $key)
                                                    <option value="{{ $key->id }}"> {{ $key->last_name }}
                                                        {{ $key->first_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                                @error('membres_id')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.titre")}}</label>
                                                <input type="text" name="titre" value="{{ $pret->titre}}"
                                                    class="form-control" id="name" placeholder="">

                                                @error('titre')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.date")}} {{__("messages.decaissement")}} </label>
                                                <input type="date" value="{{ $pret->date_decaissement}}"
                                                    name="date_decaissement" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('date_decaissement')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant")}}</label>
                                                <input type="text" value="{{ $pret->montant}}" onkeyup="sumMP();"
                                                    name="montant" class="form-control" id="montant" placeholder="">
                                                @error('montant')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">% {{__("messages.interet")}}</label>
                                                <input type="text" value="{{ $pret->pourcentage_interet}}"
                                                    onkeyup="sumMP();" name="pourcentage_interet" class="form-control"
                                                    id="pourcentage" placeholder="">
                                                @error('pourcentage_interet')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.Duree")}}</label>
                                                <input type="number" value="{{ $pret->duree}}" onkeyup="sumMP();"
                                                    name="duree" class="form-control" id="dure" placeholder="">
                                                @error('duree')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.principal_m")}} </label>
                                                <input type="text" value="{{ $pret->pmensuel}}" name="pmensuel"
                                                    onkeyup="sumMP();" class="form-control" id="pmensuel"
                                                    placeholder="">
                                                @error('pmensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.inter_m")}} </label>
                                                <input type="text" value="{{ $pret->intere_mensuel}}"
                                                    name="intere_mensuel" onkeyup="sumMP();" class="form-control"
                                                    id="intere_mensuel" placeholder="">
                                                @error('intere_mensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> {{__("messages.total_m")}}</label>
                                                <input type="text" value="{{ $pret->ttalmensuel}}" onkeyup="sumMP();"
                                                    name="ttalmensuel" class="form-control" id="rembourser"
                                                    placeholder="">
                                                @error('ttalmensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant_t_du")}}</label>
                                                <input type="text" value="{{ $pret->montanttotal}}" name="montanttotal"
                                                    class="form-control" id="sommtotal" placeholder="">
                                                @error('montanttotal')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.frais")}}</label>
                                                <input type="text" value="{{ $pret->frais}}" name="frais"
                                                    class="form-control" id="exampleInputEmail1" placeholder="">
                                                @error('frais')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>



                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.utilisation")}} </label>
                                                <textarea value="{{ $pret->utilisation}}" type="text" name="utilisation"
                                                    class="form-control"></textarea>

                                                @error('utilisation')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>



                                            <div class="row">


                                                <div class="col-md-6">

                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm">{{__("messages.modifier")}}</button>

                                                </div>

                                                <div class="col-md-6">
                                                    <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                                    <x-autorisation type="delete-pret" :autorisation="$autorisation"
                                                        :id="$pret->id_pret" />

                                                </div>


                                            </div>


                                        </form>

                                        @endif

                                    </div>

                                </div>

                            </div>
                            <div class="<?php if (isset($approuverpret)) {echo $approuverpret;}?> tab-pane"
                                id="approuverpret">

                                <script>
                                function sumPApp() {

                                    var montant = document.getElementById('montant-a').value;
                                    var pourcentage = document.getElementById('pourcentage-a').value;
                                    var dure = document.getElementById('dure-a').value;

                                    var interet = parseFloat(montant) * parseFloat(pourcentage) / 100;
                                    var rembouse = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('rembourser-a').value = interet + rembouse;

                                    var pmensuel = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('pmensuel-a').value = pmensuel;

                                    var intere_mensuel = parseFloat(pourcentage) / 100;

                                    document.getElementById('intere_mensuel-a').value = intere_mensuel * parseFloat(
                                        montant);
                                    var rembourser = interet + rembouse;
                                    var sommtotal = rembourser * parseFloat(dure);
                                    document.getElementById('sommtotalAppro').value = sommtotal;


                                }
                                </script>

                                <div class="row">


                                    @if(isset($pret))
                                    <h3> Approuver demande </h3>
                                    </br> </br> </br>
                                    <div class="col-md-10">
                                        <ul class="list-group list-group-unbordered mb-4">

                                            <li class="list-group-item">
                                                <b>{{__("messages.membre")}} </b> <a class="float-right">{{$pret->last_name}}
                                                    {{$pret->first_name}}</a>
                                            </li>

                                            <li class="list-group-item">
                                                <b>{{__("messages.caisse")}}</b> <a class="float-right"> {{$pret->caisse}} </a>
                                            </li>

                                            <li class="list-group-item">
                                                <b>{{__("messages.titre")}}</b> <a class="float-right">{{$pret->titre}}</a>
                                            </li>

                                            <li class="list-group-item">
                                                <b>{{__("messages.montant")}} </b> <a class="float-right">{{$pret->montant}}
                                                    {{$pret->curency}}</a>
                                            </li>

                                        </ul>


                                    </div>


                                    <div class="col-md-6">



                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif


                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        <!-- /.card-header -->
                                        <form method="post" action="{{ route('approuver-demande-pret') }}"
                                            accept-charset="utf-8">
                                            @csrf

                                            <input type="hidden" name="mt" value="{{$pret->montant}}">
                                            <input type="hidden" name="id_pret" value="{{$pret->id_prets}}">


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.date")}}  {{__("messages.decaissement")}} </label>
                                                <input type="date" name="date_decaissement" class="form-control"
                                                    id="exampleInputEmail1" value="{{$pret->date_decaissement}}"
                                                    placeholder="">
                                                @error('date_decaissement')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.approuver")}} </label>
                                                <input type="text" onkeyup="sumPApp();" value="{{$pret->montant}}"
                                                    name="montant" class="form-control" id="montant-a" placeholder="">
                                                @error('montant')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">% {{__("messages.interet")}}</label>
                                                <input type="text" value="{{$pret->pourcentage_interet}}"
                                                    onkeyup="sumPApp();" name="pourcentage_interet" class="form-control"
                                                    id="pourcentage-a" placeholder="">
                                                @error('pourcentage_interet')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.Duree")}} </label>
                                                <input type="number" onkeyup="sumPApp();" value="{{$pret->duree}}"
                                                    name="duree" class="form-control" value="{{$pret->duree}}"
                                                    id="dure-a" placeholder="">
                                                @error('Duree')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.principal_m")}}</label>
                                                <input type="text" name="pmensuel" value="{{$pret->pmensuel}}"
                                                    onkeyup="sumPApp();" class="form-control" id="pmensuel-a"
                                                    placeholder="">
                                                @error('numero_cb')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.inter_m")}}</label>
                                                <input type="text" name="intere_mensuel"
                                                    value="{{$pret->intere_mensuel}}" onkeyup="sumPApp();"
                                                    class="form-control" id="intere_mensuel-a" placeholder="">
                                                @error('intere_mensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.total_m")}} </label>
                                                <input type="text" onkeyup="sumPApp();" value="{{$pret->ttalmensuel}}"
                                                    name="ttalmensuel" class="form-control" id="rembourser-a"
                                                    placeholder="">
                                                @error('ttalmensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant_t_du")}}</label>
                                                <input type="text" name="montanttotal" value="{{$pret->montanttotal}}"
                                                    class="form-control" id="sommtotalAppro" placeholder="">
                                                @error('montanttotal')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div style="margin-left:25%; width:300px; padding:15px; float:left;">
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <button type="submit"
                                                            class="btn btn-danger">{{__("messages.enregistrer")}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    @endif
                                </div>

                            </div>

                            <div class="<?php if (isset($demandepret)) {echo $demandepret;}?> tab-pane"
                                id="cotisationCV">

                                <script>
                                function sum() {

                                    var montant = document.getElementById('montant').value;
                                    var pourcentage = document.getElementById('pourcentage').value;
                                    var dure = document.getElementById('dure').value;

                                    var interet = parseFloat(montant) * parseFloat(pourcentage) / 100;
                                    var rembouse = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('rembourser').value = interet + rembouse;

                                    var pmensuel = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('pmensuel').value = pmensuel;

                                    var intere_mensuel = parseFloat(pourcentage) / 100;

                                    document.getElementById('intere_mensuel').value = intere_mensuel * parseFloat(
                                        montant);
                                    var rembourser = interet + rembouse;
                                    var sommtotal = rembourser * parseFloat(dure);
                                    document.getElementById('sommtotal_a').value = sommtotal;


                                }
                                </script>

                                <div class="row">
                                    <div class="col-md-6">



                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif


                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        <!-- /.card-header -->
                                        <form method="post" action="{{ route('save-demande-pret') }}"
                                            accept-charset="utf-8">
                                            @csrf


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.caisses")}} </label>
                                                <select name="caisse" class="form-control">
                                                    <option value=""> {{__("messages.selectionner") }} {{__("messages.caisse")}}  </option>
                                                    <option value="Caisse-vert"> {{__("messages.cv")}} </option>
                                                    <option value="Caisse-rouge"> {{__("messages.cr")}} </option>
                                                    <option value="Caisse-bleue"> {{__("messages.cb")}} </option>
                                                </select>

                                                @error('caisse')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.membres")}}</label>
                                                <select name="membres_id" class="form-control">
                                                    <option value=""> {{__("messages.selectionner")}} {{__("messages.membres")}} </option>
                                                    @if(!empty($allmembre))
                                                    @foreach($allmembre as $key)
                                                    <option value="{{ $key->id }}"> {{ $key->last_name }}
                                                        {{ $key->first_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                                @error('membres_id')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.titre")}}</label>
                                                <input type="text" name="titre" class="form-control" id="name"
                                                    placeholder="">

                                                @error('titre')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.date")}} {{__("messages.decaissement")}}</label>
                                                <input type="date" name="date_decaissement" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('date_decaissement')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> {{__("messages.montant")}} </label>
                                                <input type="text" onkeyup="sum();" name="montant" class="form-control"
                                                    id="montant" placeholder="">
                                                @error('montant')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">% {{__("messages.interet")}}</label>
                                                <input type="text" onkeyup="sum();" name="pourcentage_interet"
                                                    class="form-control" id="pourcentage" placeholder="">
                                                @error('pourcentage_interet')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.Duree")}}</label>
                                                <input type="number" onkeyup="sum();" name="duree" class="form-control"
                                                    id="dure" placeholder="">
                                                @error('pourcentage_interet')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.principal_m")}}</label>
                                                <input type="text" name="pmensuel" onkeyup="sum();" class="form-control"
                                                    id="pmensuel" placeholder="">
                                                @error('numero_cb')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.inter_m")}}</label>
                                                <input type="text" name="intere_mensuel" onkeyup="sum();"
                                                    class="form-control" id="intere_mensuel" placeholder="">
                                                @error('intere_mensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> {{__("messages.total_m")}} </label>
                                                <input type="text" onkeyup="sum();" name="ttalmensuel"
                                                    class="form-control" id="rembourser" placeholder="">
                                                @error('ttalmensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant_t_du")}}</label>
                                                <input type="text" name="montanttotal" class="form-control"
                                                    id="sommtotal_a" placeholder="">
                                                @error('montanttotal')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.frais")}}</label>
                                                <input type="text" name="frais" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('frais')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>



                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.utilisation")}} </label>
                                                <textarea type="text" name="utilisation"
                                                    class="form-control"></textarea>

                                                @error('utilisation')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div style="margin-left:25%; width:300px; padding:15px; float:left;">
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <button type="submit"
                                                            class="btn btn-danger">{{__("messages.enregistrer")}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>

                            </div>


                            <div class="<?php if (isset($comite)) {echo $comite;}?> tab-pane" id="comite">
                                <div class="card-body">
                                    <table id="" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.membre")}}</th>
                                                <th>{{__("messages.titre")}}</th>
                                                <th>{{__("messages.date")}} DC</th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>% {{__("messages.interet")}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {

    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree',
            'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.statut', 'en comité')
        ->orderByDesc('prets.created_at')->distinct()->get();
} else {

    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree',
            'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.members_id', $info_muso->id_members)
        ->where('prets.statut', 'en comité')
        ->orderByDesc('prets.created_at')->distinct()->get();

}

?>

                                            @if(isset($all_pret))
                                            @foreach($all_pret as $k)

                                            <tr>

                                                <td>{{$k->first_name}} {{$k->last_name}}</td>
                                                <td>{{$k->titre}}</td>
                                                <td><?php $date = new DateTime($k->date_decaissement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}}</td>
                                                <td>{{$k->pourcentage_interet}} %</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-comite')}}/{{ $k->id_prets}}">
                                                        <i class="fas fas fa-folder"></i> {{__("messages.voir")}}</a>

                                                </td>


                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>

                            <div class="<?php if (isset($voirpret)) {echo $voirpret;}?> tab-pane" id="voirpret">

                                <div class="card-body">
                                    <div class="post clearfix">

                                        <div class="row">
                                            <?php if (!empty($pret)) {?>
                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.membre")}}</b> <a class="float-right">{{$pret->last_name}}
                                                            {{$pret->first_name}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.caisse")}}</b> <a class="float-right"> {{$pret->caisse}} </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.titre")}}</b> <a class="float-right">{{$pret->titre}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.date")}} {{__("messages.decaissement")}}  </b> <a class="float-right"><?php $date = new DateTime($pret->date_decaissement);
    echo $date->format('d-M-Y');?></a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant")}}</b> <a class="float-right">{{$pret->montant}}
                                                            {{$pret->curency}}</a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>% {{__("messages.interet")}}</b> <a
                                                            class="float-right">{{$pret->pourcentage_interet}} %
                                                        </a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>{{__("messages.Duree")}}</b> <a class="float-right">{{$pret->duree}} Mois
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.principal_m")}}</b> <a
                                                            class="float-right">{{$pret->pmensuel}}
                                                            {{$pret->curency}}
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.inter_m")}}</b> <a
                                                            class="float-right">{{$pret->intere_mensuel}}
                                                            {{$pret->curency}}
                                                        </a>
                                                    </li>



                                                    <li class="list-group-item">
                                                        <b>{{__("messages.total_m")}}Total mensuel</b> <a
                                                            class="float-right">{{$pret->ttalmensuel}}
                                                            {{$pret->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant_t_du")}} </b> <a
                                                            class="float-right">{{$pret->montanttotal}}
                                                            {{$pret->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.utilisation")}}</b> <a
                                                            class="float-right">{{$pret->utilisation}}</a>
                                                    </li>




                                                </ul>
                                            </div>
                                            <div class="col-md-4">






                                                <div class="col-md-12" style="padding-top:40px;">
                                                    <a href="{{ url('voir-echeance-pret/'.$pret->id_prets)}}">

                                                        <div class="info-box mb-2 bg-info">
                                                            <span class="info-box-icon"><i
                                                                    class="fas fa-table"></i></span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">{{__("messages.echeance")}}</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>

                                                    </a>
                                                </div>



                                            </div>
                                            <?php }?>
                                        </div>
                                        </br>

                                        </br>

                                        <div class="row">

                                            <?php
if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {

    if (isset($pret)) {?>

                                            <div class="col-md-6">

                                                <a class="btn btn-danger btn-sm"
                                                    href="{{ url('modifier-pret/'.$pret->id_prets)}}">{{__("messages.modifier")}} </a>


                                            </div>

                                            <div class="col-md-6">
                                                @if($pret->comite == 'false')

                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('envoyer-comite') }}">
                                                    @csrf

                                                    <input type="hidden" name="id_prets" value="{{$pret->id_prets}}">

                                                    <button type="submit"
                                                        onclick=" return confirm('vous voulez envoyer en comite ? ') "
                                                        class="btn btn-warning btn-sm"> {{__("messages.env_comite")}} </button>

                                                </form>

                                                @endif

                                            </div>

                                            <?php }}?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="<?php if (isset($listepret)) {echo $listepret;}?> tab-pane" id="listepret">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                 
												<th>{{__("messages.membre")}} </th>
                                                <th>{{__("messages.caisses")}} </th>
												<th>{{__("messages.titre")}} </th>
                                                <th>{{__("messages.date")}}  DC</th>
                                                <th>{{__("messages.montant")}} </th>
                                                <th>% {{__("messages.interet")}} </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {

    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement', 'prets.caisse', 'prets.statut',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->orderByDesc('prets.created_at')->distinct()->get();

} else {
    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement', 'prets.caisse', 'prets.statut',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.members_id', $info_muso->id_members)
        ->orderByDesc('prets.created_at')->distinct()->get();
}
?>

                                            @if(isset($all_pret))
                                            @foreach($all_pret as $k)

                                            <tr>

                                                <td>{{$k->first_name}} {{$k->last_name}}</td>
                                                <td>{{$k->caisse}}</td>
                                                <td>{{$k->titre}}</td>
                                                <td><?php $date = new DateTime($k->date_decaissement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}}</td>
                                                <td>{{$k->pourcentage_interet}} %</td>
                                                <td>@if($k->statut == 'Demande') Recu
                                                    @else {{$k->statut}} @endif</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-pret')}}/{{ $k->id_prets}}">
                                                        <i class="fas fas fa-folder"></i> {{__("messages.voir")}}</a>

                                                </td>


                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>



                            <div class="<?php if (isset($voircomite)) {echo $voircomite;}?> tab-pane" id="voircomite">

                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <div class="card-body">
                                    <div class="post clearfix">

                                        <div class="row">
                                            <?php if (!empty($pret)) {?>
                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.membre")}}</b> <a class="float-right">{{$pret->last_name}}
                                                            {{$pret->first_name}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.titre")}}</b> <a class="float-right">{{$pret->titre}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.date")}} {{__("messages.decaissement")}}</b> <a class="float-right"><?php $date = new DateTime($pret->date_decaissement);
    echo $date->format('d-M-Y');?></a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant")}}</b> <a class="float-right">{{$pret->montant}}
                                                            {{$pret->curency}}</a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>% {{__("messages.interet")}}</b> <a
                                                            class="float-right">{{$pret->pourcentage_interet}} %
                                                        </a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>{{__("messages.Duree")}}</b> <a class="float-right">{{$pret->duree}} Mois
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.principal_m")}}</b> <a
                                                            class="float-right">{{$pret->pmensuel}}
                                                            {{$pret->curency}}
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.inter_m")}}</b> <a
                                                            class="float-right">{{$pret->intere_mensuel}}
                                                            {{$pret->curency}}
                                                        </a>
                                                    </li>



                                                    <li class="list-group-item">
                                                        <b>{{__("messages.total_m")}}</b> <a
                                                            class="float-right">{{$pret->ttalmensuel}}
                                                            {{$pret->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant_t_du")}}</b> <a
                                                            class="float-right">{{$pret->montanttotal}}
                                                            {{$pret->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>Utilisation</b> <a
                                                            class="float-right">{{$pret->utilisation}}</a>
                                                    </li>




                                                </ul>
                                            </div>
                                            <div class="col-md-4" style="">

                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
        ?>
                                                <div class="col-md-12" style="padding-top:40px;">

                                                    <a href="{{ url('approuver-pret/'.$pret->id_prets)}}"
                                                        style="padding:15px; width:150px;" onclick="
                                                            return confirm('Etre vous sure d approuver ce pret ') "
                                                        class="btn btn-danger btn-sm">{{__("messages.approuver")}}</a>


                                                </div>



                                                <div class="col-md-12" style="padding-top:40px;">

                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('gestion-comite') }}">
                                                        @csrf

                                                        <input type="hidden" name="id_prets"
                                                            value="{{$pret->id_prets}}">
                                                        <input type="hidden" name="type" value="Rejeter">
                                                        <button style="padding:15px; width:150px;" type="submit"
                                                            onclick="
                                                        return confirm('Etre vous sure de emvoyer ce pret en comite ') "
                                                            class="btn btn-warning btn-sm"> {{__("messages.rejeter")}}</button>

                                                    </form>
                                                </div>


                                                <div class="col-md-12" style="padding-top:40px;">
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('gestion-comite') }}">
                                                        @csrf

                                                        <input type="hidden" name="id_prets"
                                                            value="{{$pret->id_prets}}">
                                                        <input type="hidden" name="type" value="En attente">
                                                        <button style="padding:15px; width:150px;" type="submit"
                                                            onclick="
                                                        return confirm('Etre vous sure de emvoyer ce pret en comite ') "
                                                            class="btn btn-danger btn-sm">  {{__("messages.attente")}} </button>

                                                    </form>
                                                </div>
                                                <?php }?>


                                            </div>
                                            <?php }?>
                                        </div>
                                        </br>

                                        </br>

                                    </div>
                                </div>

                            </div>

                            <div class="<?php if (isset($echeance)) {echo $echeance;}?> tab-pane" id="list_emprunts">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>{{__("messages.date")}}Date</th>
                                                <th>{{__("messages.principal_m")}}</th>
                                                <th>{{__("messages.inter_m")}}</th>
                                                <th>{{__("messages.total_m")}}</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $count = 0;?>
                                            @if(isset($paiement))

                                            @foreach($paiement as $k)
                                            <?php $count++;?>
                                            <?php $prets_id = $k->prets_id;
$curency = $k->curency;?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td> <?php $date = new DateTime($k->date_paiement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->pmensuel}} {{$k->curency}}</td>
                                                <td>{{$k->intere_mensuel}} {{$k->curency}}</td>
                                                <td>{{$k->ttalmensuel}} {{$k->curency}}</td>


                                </div>


                                </tr>


                                @endforeach
                                @endif
                                </br>



                                <tr>
                                    <th></th>
                                    <th>{{__("messages.total")}}</th>
                                    <th> <?php

if (!empty($prets_id) and !empty($curency)) {

    $somm1 = DB::table('pret_apayers')
        ->select(DB::raw("sum(pmensuel) as count"))
        ->where('prets_id', $prets_id)
        ->first();
    echo $somm1->count . " " . $curency;

}
?></th>
                                    <th>
                                        <?php

if (!empty($prets_id) and !empty($curency)) {

    $intere_mensuel = DB::table('pret_apayers')
        ->select(DB::raw("sum(intere_mensuel) as count"))
        ->where('prets_id', $prets_id)
        ->first();
    echo $intere_mensuel->count . " " . $curency;

}
?>
                                    </th>
                                    <th>
                                        <?php

if (!empty($prets_id) and !empty($curency)) {

    $ttalmensuel = DB::table('pret_apayers')
        ->select(DB::raw("sum(ttalmensuel) as count"))
        ->where('prets_id', $prets_id)
        ->first();
    echo $ttalmensuel->count . " " . $curency;

}
?>
                                    </th>

                                </tr>
                                </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection