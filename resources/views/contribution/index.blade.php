@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'contribution') {
    $contribution = "active";
} elseif (Request::route()->getName() === 'nouveau-don') {
    $nouveaudon = "active";
} elseif (Request::route()->getName() === 'voir-don') {
    $voirdon = "active";
} elseif (Request::route()->getName() === 'voir-emprunt') {
    $voiremprunt = "active";
} elseif (Request::route()->getName() === 'nouveau-pret') {
    $nouveaupret = "active";
} elseif (Request::route()->getName() === 'nouveau-pret') {
    $list_emprunts = "active";
} elseif (Request::route()->getName() === 'voir-paiement-emprunt') {
    $mpaiement = "active";
}

?>
<?php
if (Auth::user()->utype == "admin") {
    $info_muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->id;
} else {
    $info_muso = DB::table('members')->select('members.last_name', 'members.first_name', 'musos.name_muso',
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
                        {{__("messages.contribution")}} </h2>
                </div>
                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($contribution)) {echo $contribution;}?>"
                                    href="#list_retrair" data-toggle="tab">{{__("messages.ls_dons")}}
                                </a>
                            </li>

                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a class="nav-link <?php if (isset($nouveaudon)) {echo $nouveaudon;}?>"
                                    href="{{ route('nouveau-don')}}">{{__("messages.n_dons")}}
                                </a></li>

                            <?php }?>
                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($list_emprunts)) {echo $list_emprunts;}?>"
                                    href="#list_emprunts" data-toggle="tab"> {{__("messages.emprunts")}}
                                </a></li>
                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($nouveaupret)) {echo $nouveaupret;}?>"
                                    href="{{ route('nouveau-pret')}}">{{__("messages.n_Emprunts")}}
                                </a></li>
                            <?php }?>




                            <?php if (isset($voirdon)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voirdon)) {echo $voirdon;}?>" href="#autrePaiement"
                                    data-toggle="tab"> {{__("messages.voir")}}
                                </a>
                            </li>
                            <?php }?>

                            <?php if (isset($mpaiement)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($mpaiement)) {echo $mpaiement;}?>"
                                    href="#autrePaiement" data-toggle="tab"> {{__("messages.echeance")}}
                                </a>
                            </li>
                            <?php }?>


                            <?php if (isset($voiremprunt)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voiremprunt)) {echo $voiremprunt;}?>"
                                    href="#voiremprunt" data-toggle="tab"> {{__("messages.voir")}} 
                                </a>
                            </li>
                            <?php }?>

                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">

                            <div class="<?php if (isset($nouveaudon)) {echo $nouveaudon;}?> tab-pane" id="cotisationCV">

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
                                        <form method="post" action="{{ route('save-don') }}" accept-charset="utf-8">
                                            @csrf

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.partenaires")}} </label>
                                                <select name="partenaire_id" class="form-control">
                                                    <option value=""> {{__("messages.selectionner")}} {{__("messages.partenaires")}} </option>
                                                    @if(!empty($partenaires))
                                                    @foreach($partenaires as $key)
                                                    <option value="{{ $key->id }}"> {{ $key->name }} </option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                                @error('partenaire_id')
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
                                                <label for="exampleInputEmail1">{{__("messages.montant")}}</label>
                                                <input type="text" name="montant" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('montant')
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
                                                <label for="exampleInputEmail1">{{__("messages.chek")}}</label>
                                                <input type="text" name="numero_cb" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('numero_cb')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>



                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.description")}}</label>
                                                <textarea type="text" name="description"
                                                    class="form-control"></textarea>

                                                @error('description')
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


                            <div class="<?php if (isset($nouveaupret)) {echo $nouveaupret;}?> tab-pane"
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
                                    document.getElementById('sommtotal').value = sommtotal;


                                }

                                function sumedit() {

                                    var montant = document.getElementById('montant_').value;
                                    var pourcentage = document.getElementById('pourcentage_').value;
                                    var dure = document.getElementById('dure_').value;

                                    var interet = parseFloat(montant) * parseFloat(pourcentage) /
                                        100;
                                    var rembouse = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('rembourser_').value = interet +
                                        rembouse;

                                    var pmensuel = parseFloat(montant) / parseFloat(dure);

                                    document.getElementById('pmensuel_').value = pmensuel;

                                    var intere_mensuel = parseFloat(pourcentage) / 100;

                                    document.getElementById('intere_mensuel_').value =
                                        intere_mensuel * parseFloat(
                                            montant);
                                    var rembourser = interet + rembouse;
                                    var sommtotal = rembourser * parseFloat(dure);
                                    document.getElementById('sommtotal_').value = sommtotal;


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
                                        <form method="post" action="{{ route('save-empruts') }}" accept-charset="utf-8">
                                            @csrf

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.partenaire")}}</label>
                                                <select name="partenaire_id" class="form-control">
                                                    <option value=""> {{__("messages.selectionner")}} {{__("messages.partenaires")}} </option>
                                                    @if(!empty($partenaires))
                                                    @foreach($partenaires as $key)
                                                    <option value="{{ $key->id }}"> {{ $key->name }} </option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                                @error('partenaire_id')
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
                                                <label for="exampleInputEmail1">{{__("messages.montant")}}</label>
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
                                                <label for="exampleInputEmail1"> {{__("messages.total_m")}}</label>
                                                <input type="text" onkeyup="sum();" name="ttalmensuel"
                                                    class="form-control" id="rembourser" placeholder="">
                                                @error('ttalmensuel')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant_t_du")}} </label>
                                                <input type="text" name="montanttotal" class="form-control"
                                                    id="sommtotal" placeholder="">
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
                                                <label for="exampleInputEmail1"> {{__("messages.desc_pret")}} </label>
                                                <textarea type="text" name="description"
                                                    class="form-control"></textarea>

                                                @error('description')
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
                            <div class="<?php if (isset($contribution)) {echo $contribution;}?> tab-pane"
                                id="list_retrair">
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th> {{__("messages.nom")}} </th>
                                                <th>{{__("messages.titre")}}</th>
                                                <th>{{__("messages.date")}} {{__("messages.decaissement")}} </th>
                                                <th>{{__("messages.montant")}}</th>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                                <th></th> <?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
$don_partenaires = DB::table('partenaires')
    ->select('partenaires.name', 'don.titre', 'don.date_decaissement',
        'don.montant', 'settings.curency', 'don.id as id_don')
    ->join('don', 'don.partenaire_id', '=', 'partenaires.id')
    ->join('settings', 'settings.musos_id', '=', 'don.musos_id')
    ->where('don.musos_id', $id_musos)
    ->orderByDesc('don.created_at')->distinct()->get();
?>

                                            @if(isset($don_partenaires))
                                            @foreach($don_partenaires as $k)

                                            <tr>

                                                <td>{{$k->name}}</td>
                                                <td>{{$k->titre}}</td>
                                                <td><?php $date = new DateTime($k->date_decaissement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}}</td>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-don')}}/{{ $k->id_don}}"> <i
                                                            class="fas fas fa-folder"></i> {{__("messages.voir")}}</a>

                                                </td>
                                                <?php }?>

                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>
                            <div class="<?php if (isset($voirdon)) {echo $voirdon;}?> tab-pane" id="list_retrair">

                                <div class="card-body">
                                    <div class="post clearfix">

                                        <div class="row">
                                            <?php if (!empty($don)) {?>
                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.nom")}}</b> <a class="float-right">{{$don->name}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.titre")}} </b> <a class="float-right">{{$don->titre}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant")}} </b> <a class="float-right">{{$don->montant}}
                                                            {{$k->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.date")}} {{__("messages.decaissement")}}  </b> <a class="float-right"><?php $date = new DateTime($don->date_decaissement);
    echo $date->format('d-M-Y');?></a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>Site Web</b> <a class="float-right">{{$don->numero_cb}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b> {{__("messages.description")}} </b> <a
                                                            class="float-right">{{$don->description}}</a>
                                                    </li>

                                                    <?php $cout = 1;if (!empty($fichier)) {foreach ($fichier as $f) {?>
                                                    <li class="list-group-item">
                                                        <b>Fichier {{$cout ++}} </b>
                                                        <!-- Trigger the Modal -->

                                                        <?php if ($f->type != "pdf") {?>
                                                        <input type="image" data-toggle="modal"
                                                            data-target="#myModal{{$f->id}}" class="float-right"
                                                            src="{{ url('public/images_all/'.$f->fichier) }}"
                                                            width="5%" />
                                                        <?php } else {?>
                                                        <button type="button" class="btn btn-info btn-sm float-right"
                                                            data-toggle="modal" data-target="#myModal{{$f->id}}">Lire
                                                            documenet
                                                            PDF</button>
                                                        <?php }?>

                                                        <div class="modal fade" id="myModal{{$f->id}}" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">

                                                                    <div class="modal-body">
                                                                        <?php if ($f->type != "pdf") {?>
                                                                        <img id="myImg" class="float-right" width="100%"
                                                                            src="{{ url('public/images_all/'.$f->fichier) }}"
                                                                            alt="Snow">
                                                                        <?php } else {?>
                                                                        <embed
                                                                            src="{{ url('public/images_all/'.$f->fichier) }}"
                                                                            width="450" height="375"
                                                                            type="application/pdf">
                                                                        <?php }?>
                                                                    </div>




                                                                </div>

                                                            </div>
                                                        </div>



                                                    </li>
                                                    <?php }}?>



                                                </ul>
                                            </div>
                                            <div class="col-md-4" style="">

                                                <form method="post" action="{{ route('ajouter-fichier-don') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{$don->id_don}}" />
                                                    <div style="margin-left:10%; width:250px;">
                                                        <div class="form-group">
                                                            <p style="font-size:20px; font-weight:bold; color:red;">
                                                               {{__("messages.kontra")}}  </p>
                                                            <input type="file" name="file[]" multiple
                                                                onchange="form.submit()">

                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                            <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                            <x-autorisation type="delete-don" :autorisation="$autorisation"
                                                :id="$don->id_don" />
                                            <?php }?>

                                        </div>
                                        </br>

                                        <div class="row">


                                            <?php if (isset($data_partenaire)) {?>

                                            <div class="col-md-6">

                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#myModal"><i class="fas fas fa-folder">
                                                    </i> {{__("messages.btn_modifier")}}</button>






                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                         

                                                            <span class="autAff"
                                                                style="color:red; margin-left:20%; font-size:18px;"></span>

                                                            <div class="modal-body">
                                                                <form class="form-horizontal" method="POST"
                                                                    action="{{ route('modifier-partenaire') }}"
                                                                    id="modifierPartenaire">


                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="id" value="<?php if (isset($data_partenaire->id)) {
    echo $data_partenaire->id;
}
    ?>">

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.btn_modifier")}}Nom</label>
                                                                        <input type="text" name="name" value="<?php if (isset($data_partenaire->name)) {
        echo $data_partenaire->name;
    }
    ?>" class="form-control" id="name" placeholder="">

                                                                        @error('name')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror


                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.adresse")}}</label>
                                                                        <input type="text" name="adresse" value="<?php if (isset($data_partenaire->adresse)) {
        echo $data_partenaire->adresse;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('adresse')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleInputEmail1">{{__("messages.telephone")}}</label>
                                                                        <input type="number" name="telf" value="<?php if (isset($data_partenaire->telf)) {
        echo $data_partenaire->telf;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('telf')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleInputEmail1">{{__("messages.representant")}}</label>
                                                                        <input type="text" name="representant" value="<?php if (isset($data_partenaire->representant)) {
        echo $data_partenaire->representant;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('representant')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>




                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Email</label>
                                                                        <input type="email" name="email" value="<?php if (isset($data_partenaire->email)) {
        echo $data_partenaire->email;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('email')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1"> Site
                                                                            Web</label>
                                                                        <input type="text" name="site_web" value="<?php if (isset($data_partenaire->site_web)) {
        echo $data_partenaire->site_web;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('site_web')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Presentation du
                                                                            partenaire</label>
                                                                        <textarea type="text" name="text_representant"
                                                                            class="form-control"><?php if (isset($data_partenaire->text_representant)) {
        echo $data_partenaire->text_representant;
    }
    ?></textarea>

                                                                        @error('text_representant')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>


                                                                    </br>
                                                                    <div class="form-group">
                                                                        <div class="col-md-6 col-md-offset-4">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">{{__("messages.btn_modifier")}}</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                                <x-autorisation type="delete-partenaire" :autorisation="$autorisation"
                                                    :id="$data_partenaire->id" />
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="<?php if (isset($voiremprunt)) {echo $voiremprunt;}?> tab-pane"
                                id="voiremprunt">

                                <div class="card-body">
                                    <div class="post clearfix">

                                        <div class="row">
                                            <?php if (!empty($emprunt)) {?>
                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.partenaires")}}</b> <a class="float-right">{{$emprunt->name}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.titre")}}</b> <a class="float-right">{{$emprunt->titre}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.date")}} {{__("messages.decaissement")}} </b> <a class="float-right"><?php $date = new DateTime($emprunt->date_decaissement);
    echo $date->format('d-M-Y');?></a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant")}}</b> <a class="float-right">{{$emprunt->montant}}
                                                            {{$emprunt->curency}}</a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>% {{__("messages.interet")}}</b> <a class="float-right">{{$emprunt->pourcentage_interet}} %
                                                        </a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>{{__("messages.Duree")}}</b> <a class="float-right">{{$emprunt->duree}} Mois
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.principal_m")}} </b> <a
                                                            class="float-right">{{$emprunt->pmensuel}}
                                                            {{$emprunt->curency}}
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.inter_m")}} </b> <a
                                                            class="float-right">{{$emprunt->intere_mensuel}}
                                                            {{$emprunt->curency}}
                                                        </a>
                                                    </li>



                                                    <li class="list-group-item">
                                                        <b>{{__("messages.total_m")}} </b> <a
                                                            class="float-right">{{$emprunt->ttalmensuel}}
                                                            {{$emprunt->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant_t_du")}} </b> <a
                                                            class="float-right">{{$emprunt->montanttotal}}
                                                            {{$emprunt->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.description")}}</b> <a
                                                            class="float-right">{{$emprunt->description}}</a>
                                                    </li>

                                                    <?php $cout = 1;if (!empty($fichier)) {foreach ($fichier as $f) {?>
                                                    <li class="list-group-item">
                                                        <b>Fichier {{$cout ++}} </b>
                                                        <!-- Trigger the Modal -->

                                                        <?php if ($f->type != "pdf") {?>
                                                        <input type="image" data-toggle="modal"
                                                            data-target="#myModal{{$f->id}}" class="float-right"
                                                            src="{{ url('public/images_all/'.$f->fichier) }}"
                                                            width="5%" />
                                                        <?php } else {?>
                                                        <button type="button" class="btn btn-info btn-sm float-right"
                                                            data-toggle="modal" data-target="#myModal{{$f->id}}">Lire
                                                            documenet
                                                            PDF</button>
                                                        <?php }?>

                                                        <div class="modal fade" id="myModal{{$f->id}}" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">

                                                                    <div class="modal-body">
                                                                        <?php if ($f->type != "pdf") {?>
                                                                        <img id="myImg" class="float-right" width="100%"
                                                                            src="{{ url('public/images_all/'.$f->fichier) }}"
                                                                            alt="Snow">
                                                                        <?php } else {?>
                                                                        <embed
                                                                            src="{{ url('public/images_all/'.$f->fichier) }}"
                                                                            width="450" height="375"
                                                                            type="application/pdf">
                                                                        <?php }?>
                                                                    </div>




                                                                </div>

                                                            </div>
                                                        </div>



                                                    </li>
                                                    <?php }}?>



                                                </ul>
                                            </div>
                                            <div class="col-md-4" style="">

                                                <form method="post" action="{{ route('ajouter-fichier-pret') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{$emprunt->id_emprunts }}" />
                                                    <div style="margin-left:10%; width:250px;">
                                                        <div class="form-group">
                                                            <p style="font-size:20px; font-weight:bold; color:red;">
                                                               {{__("messages.kontra")}}  </p>
                                                            <input type="file" name="file[]" multiple
                                                                onchange="form.submit()">

                                                        </div>

                                                    </div>
                                                </form>

                                                <div class="col-md-12" style="padding-top:40px;">
                                                    <a href="{{ url('remboursement-id/'.$emprunt->id_emprunts)}}">

                                                        <div class="info-box mb-2 bg-info">
                                                            <span class="info-box-icon"><i
                                                                    class="fas fa-tag"></i></span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">{{__("messages.remboursement")}}</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>

                                                    </a>
                                                </div>



                                                <div class="col-md-12" style="padding-top:40px;">

                                                    <a href="{{ url('fiche-emprunt/'.$emprunt->id_emprunts)}}">

                                                        <div class="info-box mb-2 bg-danger">
                                                            <span class="info-box-icon"><i
                                                                    class="fas fa-money-check"></i></span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text"> {{__("messages.fiche_em")}} </span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>

                                                    </a>
                                                </div>


                                                <div class="col-md-12" style="padding-top:40px;">
                                                    <a href="{{ url('voir-paiement-emprunt/'.$emprunt->id_emprunts)}}">

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


                                            <?php if (isset($emprunt)) {?>



                                            <div class="col-md-6">
                                                <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                                <x-autorisation type="delete-emprunt" :autorisation="$autorisation"
                                                    :id="$emprunt->id_emprunts" />
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="<?php if (isset($list_emprunts)) {echo $list_emprunts;}?> tab-pane"
                                id="list_emprunts">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.partenaire")}}</th>
                                                <th>{{__("messages.titre")}}</th>
                                                <th>{{__("messages.Date")}} {{__("messages.decaissement")}} </th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>% {{__("messages.interet")}}</th>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                                <th></th><?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
$all_pret = DB::table('partenaires')
    ->select('partenaires.name', 'emprunts.titre', 'emprunts.date_decaissement', 'emprunts.echeance',
        'emprunts.montant', 'emprunts.ttalmensuel', 'emprunts.duree', 'emprunts.pourcentage_interet', 'emprunts.duree', 'settings.curency', 'emprunts.id as id_emprunts')
    ->join('emprunts', 'emprunts.partenaire_id', '=', 'partenaires.id')
    ->join('settings', 'settings.musos_id', '=', 'emprunts.musos_id')
    ->where('emprunts.musos_id', $id_musos)
    ->orderByDesc('emprunts.created_at')->distinct()->get();
?>

                                            @if(isset($all_pret))
                                            @foreach($all_pret as $k)

                                            <tr>

                                                <td>{{$k->name}}</td>
                                                <td>{{$k->titre}}</td>
                                                <td><?php $date = new DateTime($k->date_decaissement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}}</td>
                                                <td>{{$k->pourcentage_interet}} %</td>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-emprunt')}}/{{ $k->id_emprunts}}">
                                                        <i class="fas fas fa-folder"></i> {{__("messages.voir")}}</a>

                                                </td>
                                                <?php }?>

                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>

                            <div class="<?php if (isset($mpaiement)) {echo $mpaiement;}?> tab-pane" id="list_emprunts">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th> {{__("messages.date")}} </th>
                                                <th> {{__("messages.principal_m")}}</th>
                                                <th> {{__("messages.inter_m")}} </th>
                                                <th> {{__("messages.total_m")}} </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $count = 0;?>
                                            @if(isset($paiement))

                                            @foreach($paiement as $k)
                                            <?php $count++;?>
                                            <?php $emprunts_id = $k->emprunts_id;
$curency = $k->curency;?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td> <?php $date = new DateTime($k->date_paiement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->pmensuel}} {{$k->curency}}</td>
                                                <td>{{$k->intere_mensuel}} {{$k->curency}}</td>
                                                <td>{{$k->ttalmensuel}} {{$k->curency}}</td>


                                                <div class="modal fade" id="myModal{{$k->id_emprunt_apayer}}"
                                                    role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">

                                                            <div class="modal-body">

                                                                <h4 class="modal-title">Paiement</h4>

                                                                <span class="autAff"
                                                                    style="color:red; margin-left:20%; font-size:18px;"></span>


                                                                @if($k->paiement == 'false')
                                                                <form class="form-horizontal" method="POST"
                                                                    action="{{ route('save-paiement-emprunts') }}"
                                                                    id="save-emprunts">

                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="id"
                                                                        value="{{$k->id_emprunt_apayer}}">

                                                                    <input type="hidden" name="ttalmensuel"
                                                                        value="{{$k->ttalmensuel}}">
                                                                    <hr>
                                                                    <div class=" form-group row">
                                                                        <label for="inputName"
                                                                            class="col-sm-3 col-form-label">Paiement
                                                                            mensuel</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text"
                                                                                value="{{$k->ttalmensuel}} {{$k->curency}}"
                                                                                class="form-control" disabled>

                                                                        </div>
                                                                        <span class="ttalmensuel_error"
                                                                            style="color:red;">
                                                                        </span>

                                                                    </div>
                                                                    <div class=" form-group row">
                                                                        <label for="inputName"
                                                                            class="col-sm-3 col-form-label">Vesement</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" name="versement"
                                                                                class="form-control">

                                                                        </div>
                                                                        <span class="versement_error"
                                                                            style="color:red;">
                                                                        </span>

                                                                    </div>



                                                                    </br>
                                                                    <div class="form-group">
                                                                        <div class="col-md-6 col-md-offset-4">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Enregistrer</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                @else
                                                                <?php
$all_paiement_emprunts = DB::table('emprunt_apayers')
    ->join('paiement_emprunts', 'paiement_emprunts.id_emprunt_apayers', '=', 'emprunt_apayers.id')
    ->join('settings', 'settings.musos_id', '=', 'emprunt_apayers.musos_id')
    ->where('emprunt_apayers.id', $k->id_emprunt_apayer)->get();
?>


                                                                @if(isset($all_paiement_emprunts))
                                                                @foreach($all_paiement_emprunts as $p)


                                                                <ul
                                                                    style="list-style: none; border:1px solid #f0f0f0; padding:15px;">

                                                                    <li> <span style="font-weight:bold;"> Paiement
                                                                            Mensuel : </span>{{$p->ttalmensuel}}
                                                                        {{$k->curency}}</li>
                                                                    <li><span style="font-weight:bold;"> Versement :
                                                                        </span>{{$p->versement}} {{$k->curency}}</li>
                                                                    <li><span style="font-weight:bold;"> Balance :
                                                                        </span>{{$p->balance}} {{$k->curency}}</li>
                                                                    <li>
                                                                        <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                                                        <x-autorisation type="delete-paiement_emprunts"
                                                                            :autorisation="$autorisation"
                                                                            :id="$p->id_emprunts" />
                                                            </div>

                                                            </li>

                                                            </ul>
                                                            @endforeach @endif @endif
                                                        </div>

                                                    </div>

                                                </div>
                                </div>


                                </tr>


                                @endforeach
                                @endif
                                </br>


                                </tbody>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th> <?php

if (!empty($emprunts_id) and !empty($curency)) {

    $somm1 = DB::table('emprunt_apayers')
        ->select(DB::raw("sum(pmensuel) as count"))
        ->where('emprunts_id', $emprunts_id)
        ->first();
    echo $somm1->count . " " . $curency;

}
?></th>
                                    <th>
                                        <?php

if (!empty($emprunts_id) and !empty($curency)) {

    $intere_mensuel = DB::table('emprunt_apayers')
        ->select(DB::raw("sum(intere_mensuel) as count"))
        ->where('emprunts_id', $emprunts_id)
        ->first();
    echo $intere_mensuel->count . " " . $curency;

}
?>
                                    </th>
                                    <th>
                                        <?php

if (!empty($emprunts_id) and !empty($curency)) {

    $ttalmensuel = DB::table('emprunt_apayers')
        ->select(DB::raw("sum(ttalmensuel) as count"))
        ->where('emprunts_id', $emprunts_id)
        ->first();
    echo $ttalmensuel->count . " " . $curency;

}
?>
                                    </th>

                                </tr>
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