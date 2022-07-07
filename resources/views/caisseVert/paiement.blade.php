@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'cotisation-caisse-vert' or Request::route()->getName() === 'rencontre-cotisation' or Request::route()->getName() === 'paiement-caisse-vert') {
    $cotisationCV = "active";
} elseif (Request::route()->getName() === 'liste-paiement-ccv') {
    $listpaiement = "active";
} elseif (Request::route()->getName() === 'autre-Paiement' or Request::route()->getName() === 'save-autre-paiement') {
    $autrePaiement = "active";
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


<!-- Main content -->
<section class="content">




    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="alert  alert-dismissible col-md-7">
                    <h2>
                       {{__("messages.ccv")}}</h2>
                </div>
                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($cotisationCV)) {echo $cotisationCV;}?>"
                                    href="#cotisationCV" data-toggle="tab">{{__("messages.p_paiement")}}
                                </a></li>
<!--
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($autrePaiement)) {echo $autrePaiement;}?>"
                                    href="#autrePaiement" data-toggle="tab">{{__("messages.p_paiement")}}Passer autres paiements
                                </a>
                            </li> -->

                            <?php } else { $listpaiement = "active";
    $cotisationCV = "desactive";}?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($listpaiement)) {echo $listpaiement;}?>"
                                    href="#listpaiement" data-toggle="tab">
                                   {{__("messages.affic_paiement")}}
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($allPaiement)) {echo $allPaiement;}?>"
                                    href="#allPaiement" data-toggle="tab">{{__("messages.t_paiement")}}
                                </a>
                            </li>

                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">

                            <div class="<?php if (isset($cotisationCV)) {echo $cotisationCV;}?> tab-pane"
                                id="cotisationCV">


                                <!-- /.card-header -->
                                <form method="post" action="{{ route('rencontre-cotisation') }}">
                                    @csrf
                                    <select name="meettings_id" class="col-md-8 form-control" onchange="form.submit()"
                                        style="margin-left:100px; margin-top:20px;" require>
                                        @if (isset($last_meetting->title_meetting))
                                        <option> {{$last_meetting->title_meetting}} /
                                            <?php $date = new DateTime($last_meetting->date_meetting);
echo $date->format('d-M-Y');?>
                                        </option>
                                        @endif
                                        <option value=""> Selectionner Rencontre </option>
                                        @foreach($all_mettings as $k)
                                        <option value="<?php echo $k->id; ?>">
                                            <?=$k->title_meetting?> /
                                            <?php $date = new DateTime($k->date_meetting);
echo $date->format('d-M-Y');?>
                                        </option>
                                        @endforeach
                                    </select>
                                </form>




                                @if (isset($success))
                                <div style="margin-left:30%; margin-top:10px; width:300px;"
                                    class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                    {{ $success }}
                                </div>
                                @endif

                                <form method="post" action="{{ route('paiement-caisse-vert') }}">
                                    @csrf
                                    <div class="card-body">

                                        <table class="table table-bordered table-striped">

                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>{{__("messages.nom")}}</th>
                                                    <th>{{__("messages.prenom")}}</th>
                                                    <th>{{__("messages.cotisation")}} </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($membre))
                                                @foreach($membre as $k)
                                                <?php $title_meetting = $k->title_meetting;
$date = $k->date_meetting;?>
                                                <tr>
                                                    <td><input type="checkbox" class="chk"
                                                            name="id_cotisation_caisses[]"
                                                            value="{{$k->id_cotisation_caisses}}">

                                                        <input type="hidden" name="montant" value="{{$k->montant}}">

                                                        @error('id_cotisation_caisses')
                                                        <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                    <td>{{$k->last_name}}</td>
                                                    <td>{{$k->first_name}}</td>
                                                    <td>{{$k->montant}} {{$k->curency}} </td>

                                                </tr>
                                                @endforeach
                                                @endif
                                                </br>

                                                <span
                                                    style="margin-left:30%; margin-top:10px; color:#252526; font-weight:bold;">
                                                    @if (isset($title_meetting))
                                                    {{ $title_meetting }}
                                                    <?php $date = new DateTime($date);
echo "( " . $date->format('d-M-Y') . " )";?>
                                                    @endif

                                                </span>

                                            </tbody>

                                        </table>

                                    </div>
                                    <button type="submit" style="margin-left:40%; margin-bottom:20px;"
                                        class="btn btn-primary">{{__("messages.paiement")}}</button>
                                    <!-- /.card-body -->
                                </form>

                            </div>



                            <div class="<?php if (isset($listpaiement)) {echo $listpaiement;}?> tab-pane"
                                id="listpaiement">
                                <!-- /.card-header -->
                                <form method="post" action="{{ route('liste-paiement-ccv') }}">
                                    @csrf
                                    <select name="meettings_id" class="col-md-8 form-control" onchange="form.submit()"
                                        style="margin-left:100px; margin-top:20px;" require>

                                        <option value=""> Selectionner Rencontre </option>
                                        @foreach($all_mettings_paiement as $k)
                                        <option value="<?php echo $k->id; ?>">
                                            <?=$k->title_meetting?> /
                                            <?php $date = new DateTime($k->date_meetting);
echo $date->format('d-M-Y');?>
                                        </option>
                                        @endforeach
                                    </select>
                                </form>

                                <div class="card-body">

                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.nom")}}</th>
                                                <th>{{__("messages.prenom")}}</th>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.cotisation")}} </th>
                                                <th>-</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($membrePaiemment))
                                            @foreach($membrePaiemment as $k)
                                            <?php $title_meetting = $k->title_meetting;
$id_meetting = $k->id;
$musos_id = $k->musos_id;
$curency = $k->curency
?>
                                            <tr>
                                                <td>{{$k->last_name}}</td>
                                                <td>{{$k->first_name}}</td>
                                                <td>
                                                    <?php $date = new DateTime($k->date_paiement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}} </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#myModal{{$k->id_cotisation_caisses}}"><i
                                                            class="far fa-trash-alt">
                                                        </i> {{__("messages.supprimer")}}</button>

                                                </td>

                                            </tr>

                                            <div class="modal fade" id="myModal{{$k->id_cotisation_caisses}}"
                                                role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h4 class="modal-title"> Autorisation pour supprimer un
                                                                paiement </h4>
                                                        </div>
                                                        <span class="affiche" style="font-size:22px; text-align:center">
                                                            <?php if (!empty($autorisation)) {
    echo $autorisation->first_name . " " . $autorisation->last_name;
}
?>
                                                        </span>
                                                        <span class="autAff"
                                                            style="color:red; margin-left:20%; font-size:18px;"></span>
                                                        <div class="modal-body">
                                                            <?php if (!empty($autorisation)) {?>
                                                            <form class="form-horizontal" method="POST"
                                                                action="{{ route('delete-paiement') }}"
                                                                id="autorisationPw">


                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="type"
                                                                    value="delete-paiement">
                                                                <input type="hidden" name="id"
                                                                    value="{{$k->id_cotisation_caisses}}">
                                                                <hr>
                                                                <div class=" form-group row">
                                                                    <label for="inputName"
                                                                        class="col-sm-3 col-form-label">Password</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="password" name="password"
                                                                            class="form-control">

                                                                    </div>
                                                                    <span class="password_error" style="color:red;">
                                                                    </span>

                                                                </div>



                                                                </br>
                                                                <div class="form-group">
                                                                    <div class="col-md-6 col-md-offset-4">
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Envoyer</button>

                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <?php } else {?>

                                                            <div style=" margin-top:10px; width:465px;"
                                                                class="alert alert-success alert-dismissible">

                                                                <h4><i class="icon fas fa-check"></i> Alert!</h4>
                                                                Vous
                                                                devez Ajouter une personne pour
                                                                avoir acces a supprimer
                                                            </div>

                                                            <?php }?>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                            </br>

                                            <p
                                                style="font-size:22px; text-align:center; margin-top:10px; color:#252526; font-weight:bold;">

                                                @if (isset($title_meetting))
                                                {{ $title_meetting }}
                                                @endif

                                            </p>
                                            <p
                                                style="font-size:17px; text-align:center; margin-top:10px; color:#252526;">

                                                <?php if (isset($musos_id) and isset($id_meetting)) {?>
													
													{{__("messages.somme")}} :
													<?php
    $musos = DB::table('cotisation_caisses')
        ->select(DB::raw("sum(montant) as count"))
        ->where('musos_id', $musos_id)
        ->where('meettings_id', $id_meetting)
        ->where('type_caisse', 'caisse-vert')
        ->where('pay', 'true')
        ->first();
    echo $musos->count . " " . $curency;
}
?>
                                            </p>

                                        </tbody>

                                    </table>

                                </div>
                            </div>

                            <div class="<?php if (isset($autrePaiement)) {echo $autrePaiement;}?> tab-pane"
                                id="autrePaiement">
                                <!-- /.card-header -->
                                @if (isset($statut))
                                <div class="alert alert-success">
                                    {{ $statut }}
                                </div>
                                @endif

                                @if (isset($error))
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                                @endif
                                <div class="card-body">

                                    <form method="post" action="{{ route('save-autre-paiement') }}">
                                        @csrf

                                        <?php $muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();?>
                                        <?php $all_membre = DB::table('members')
    ->select('members.last_name', 'members.first_name', 'settings.cv_cotisation_amount', 'settings.curency', 'members.id')
    ->join('settings', 'settings.musos_id', '=', 'members.musos_id')
    ->where('members.musos_id', $id_musos)->get();?>

                                        <select name="members_id" class="col-md-6 form-control" require>

                                            <option value=""> Selectionner Membre </option>
                                            @if(isset($all_membre))
                                            @foreach($all_membre as $k)
                                            <option value="<?php echo $k->id; ?>">
                                                {{$k->last_name}} {{$k->first_name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        </br>
                                        <select name="meettings_id" class="col-md-6 form-control" require>

                                            <option value=""> Selectionner Rencontre
                                            </option>
                                            <?php

$all_rencontre = DB::table('meettings')
    ->select('meettings.title_meetting', 'meettings.date_meetting', 'meettings.id')
    ->join('cotisation_caisses', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
    ->where('meettings.musos_id', $id_musos)
    ->where('cotisation_caisses.type_caisse', 'caisse-vert')
    ->orderByDesc('meettings.created_at')->distinct()->get();
?>

                                            @if(!empty($all_rencontre))
                                            @foreach($all_rencontre as $r)
                                            <option value="<?php echo $r->id; ?>">
                                                <?=$r->title_meetting?>/
                                                <?php $date = new DateTime($r->date_meetting);
echo $date->format('d-M-Y');?>
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        </br>
                                        <div class=" form-group row">

                                            <div class="col-sm-6">
                                                <label for="inputName" class="col-form-label">Cotisation CV</label>
                                                <input type="text" name="cotisation" class="form-control">

                                            </div>
                                            <span class="password_error" style="color:red;">
                                            </span>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-danger">Envoyer</button>

                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>


                            <div class="<?php if (isset($allPaiement)) {echo $allPaiement;}?> tab-pane"
                                id="allPaiement">
                                <div class="card-body">

                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
   
												     <th>{{__("messages.nom")}}</th>
                                                <th>{{__("messages.prenom")}}</th>
												 <th>{{__("messages.rencontres")}}</th>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.cotisation")}} </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

$membrePaiemment = DB::table('members')
    ->select('meettings.title_meetting', 'cotisation_caisses.montant', 'cotisation_caisses.date_paiement', 'cotisation_caisses.id as id_cotisation_caisses', 'members.last_name', 'members.first_name', 'members.phone', 'members.id as id_member',
        'cotisation_caisses.id as id_cotisation_caisses', 'settings.cv_cotisation_amount', 'settings.curency')
    ->join('cotisation_caisses', 'cotisation_caisses.members_id', '=', 'members.id')
    ->join('meettings', 'cotisation_caisses.meettings_id', '=', 'meettings.id')
    ->join('settings', 'settings.musos_id', '=', 'meettings.musos_id')
    ->where('cotisation_caisses.musos_id', $id_musos)
    ->where('cotisation_caisses.pay', 'true')
    ->where('cotisation_caisses.type_caisse', 'caisse-vert')
    ->get();

?>
                                            @if(isset($membrePaiemment))
                                            @foreach($membrePaiemment as $k)
                                            <?php $curency = $k->curency;?>

                                            <tr>
                                                <td>{{$k->last_name}}</td>
                                                <td>{{$k->first_name}}</td>
                                                <td>{{$k->title_meetting}}</td>
                                                <td>
                                                    <?php $date = new DateTime($k->date_paiement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}} </td>


                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>

                                            <span
                                                style="font-size:22px; text-align:center; margin-top:10px; color:#252526;">


                                                <?php if (isset($id_musos) and isset($curency)) { ?>
													{{__("messages.somme")}}
												<?php 	
    $musos = DB::table('cotisation_caisses')
        ->select(DB::raw("sum(montant) as count"))
        ->where('musos_id', $id_musos)
        ->where('type_caisse', 'caisse-vert')
        ->where('pay', 'true')
        ->first();
    echo " : " . $musos->count . " " . $curency;
}
?>
                                            </span>

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
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
var ele = document.getElementsByClassName('chk');
for (var i = 0; i < ele.length; i++) {
    if (ele[i].type == 'checkbox')
        ele[i].checked = true;
}


function deSelect() {
    var ele = document.getElementsByName('chk');
    for (var i = 0; i < ele.length; i++) {
        if (ele[i].type == 'checkbox')
            ele[i].checked = false;

    }
}
</script>

@endsection