@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'depense-cv' or Request::route()->getName() === 'save-retrait') {

    if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
        $retrair = "active";
    } else {
        $list_retrair = "active";
    }
} elseif (Request::route()->getName() === 'lister-depense-cv') {
    $list_retrair = "active";
} elseif (Request::route()->getName() === 'voir-depense-cv') {
    $voirDepense = "active";
} elseif (Request::route()->getName() === 'rapport-depensecv' or Request::route()->getName() === 'rapport-depense-cv') {
    $rapportDepense = "active";
}

?>

<?php
if (Auth::user()->utype == "admin") {
    $info_muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->id;
    $name_muso = $info_muso->name_muso;
} else {
    $info_muso = DB::table('members')->select('members.last_name', 'members.first_name', 'musos.name_muso',
        'musos.representing', 'musos.phone', 'musos.registered_date', 'musos.contry', 'musos.network', 'members.musos_id')
        ->join('musos', 'musos.id', '=', 'members.musos_id')
        ->where('members.users_id', Auth::user()->id)->first();
    //dd($info);
    $id_musos = $info_muso->musos_id;
    $name_muso = $info_muso->name_muso;
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">

                <div class="alert  alert-dismissible col-md-7">
                    <h2>
                        {{__("messages.ccv")}} </h2>
                </div>
                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a class="nav-link <?php if (isset($retrair)) {echo $retrair;}?>"
                                    href="#cotisationCV" data-toggle="tab">{{__("messages.Ajouter_d")}}
                                </a></li>

                            <?php }?>

                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($list_retrair)) {echo $list_retrair;}?>"
                                    href="#list_retrair" data-toggle="tab">{{__("messages.les_depense")}}
                                </a>
                            </li>
                            <?php if (isset($voirDepense)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voirDepense)) {echo $voirDepense;}?>"
                                    href="#autrePaiement" data-toggle="tab">{{__("messages.depense")}} Info
                                </a>
                            </li>
                            <?php }?>
							

                            <li class="nav-item">
                                <a href="{{ url('rapport-depensecv')}}"
                                    class="nav-link <?php if (isset($rapportDepense)) {echo $rapportDepense;}?>">{{__("messages.rapport")}}
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">
                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <div class="<?php if (isset($retrair)) {echo $retrair;}?> tab-pane" id="cotisationCV">

                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        <!-- /.card-header -->
                                        <form method="post" action="{{ route('save-depense') }}"
                                            enctype="multipart/form-data" accept-charset="utf-8" id="addDepense-cv">
                                            @csrf

                                            <div id="loading" style="position: absolute;
  top: 0px;
  right: 0;">
                                                <p><img src="http://musomobil.jfennews.com/public/assets/images/loading.gif"
                                                        style="width:40%" />
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.description")}}</label>
                                                <input type="text" name="description" class="form-control"
                                                    id="exampleInputEmail1">

                                                <span class="description_error" style="color:red;">
                                                </span>

                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.date")}}</label>
                                                <input type="date" name="date" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                <span class="date_error" style="color:red;">
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant")}}</label>
                                                <input type="number" name="montant" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                <span class="montant_error" style="color:red;">
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.trubrique")}}</label>
                                                <input type="text" name="type" class="form-control"
                                                    id="exampleInputEmail1">
                                                <span class="type_error" style="color:red;">
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.Benéficiaire")}}</label>
                                                <input type="text" name="beneficiare" class="form-control"
                                                    id="exampleInputEmail1">
                                                <span class="beneficiare_error" style="color:red;">
                                                </span>
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.autre_d")}}</label>
                                                <textarea type="text" name="autre_detail"
                                                    class="form-control"></textarea>

                                                <span class="autre_detail_error" style="color:red;">
                                                </span>
                                            </div>




                                    </div>
                                    <div class="col-md-4">

                                        <div style="margin-left:25%; width:250px; padding:15px; border:1px solid;">
                                            <div class="form-group">
                                                <p> {{__("messages.atpieces")}} </p>
                                                <input type="file" name="file[]" multiple>
                                            </div>
                                            <span class="file_error" style="color:red;">
                                            </span>
                                        </div>
                                        <div style="margin-left:25%; width:300px; padding:15px; float:left;">
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-4">
                                                    <button type="submit" class="btn btn-danger">{{__("messages.enregistrer")}}</button>
                                                </div>
                                            </div>
                                        </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                            <?php }?>
                            <div class="<?php if (isset($list_retrair)) {echo $list_retrair;}?> tab-pane"
                                id="list_retrair">
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.description")}}</th>
                                                <th>{{__("messages.Benéficiaire")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>{{__("messages.rubrique")}}</th>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                                <th></th><?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$depensecv = DB::table('depensecv')
    ->select('depensecv.date', 'depensecv.description', 'depensecv.beneficiare', 'depensecv.montant', 'settings.curency', 'depensecv.type', 'depensecv.id as id_depense')
    ->join('settings', 'settings.musos_id', '=', 'depensecv.musos_id')
    ->where('depensecv.musos_id', $id_musos)
    ->orderByDesc('depensecv.created_at')->distinct()->get();
?>

                                            @if(isset($depensecv))
                                            @foreach($depensecv as $k)

                                            <tr>
                                                <td> <?php $date = new DateTime($k->date);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->description}}</td>
                                                <td>{{$k->beneficiare}}</td>
                                                <td>{{$k->montant}} {{$k->curency}}</td>
                                                <td>{{$k->type}} </td>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-depense-cv')}}/{{ $k->id_depense}}"> <i
                                                            class="fas fas fa-folder"></i> Voir</a>

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
                            <div class="<?php if (isset($voirDepense)) {echo $voirDepense;}?> tab-pane"
                                id="list_retrair">
                                <?php if (isset($depenses)) {?>
                                <div class="card-body">
                                    <div class="post clearfix">


                                        <ul class="list-group list-group-unbordered mb-4">
                                            <li class="list-group-item">
                                                <b>{{__("messages.date")}}</b> <a class="float-right">
                                                    <?php $date = new DateTime($depenses->date);
    echo $date->format('d-M-Y');?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.description")}}</b> <a class="float-right">{{$depenses->description}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.rubrique")}}</b> <a class="float-right">{{$depenses->type}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.montant")}}</b> <a class="float-right">{{$depenses->montant}}</a>
                                            </li>

                                            <li class="list-group-item">
                                                <b>{{__("messages.Benéficiaire")}}</b> <a class="float-right">{{$depenses->beneficiare}}</a>
                                            </li>

                                            <li class="list-group-item">
                                                <b>{{__("messages.autre_d")}}</b> <a
                                                    class="float-right">{{$depenses->autre_detail}}</a>
                                            </li>
                                            <?php $cout = 1;if (!empty($fichier)) {foreach ($fichier as $f) {?>
                                            <li class="list-group-item">
                                                <b>Fichier {{$cout ++}} </b>
                                                <!-- Trigger the Modal -->

                                                <?php if ($f->type != "pdf") {?>
                                                <input type="image" data-toggle="modal" data-target="#myModal{{$f->id}}"
                                                    class="float-right"
                                                    src="{{ url('public/images_all/'.$f->fichier) }}" width="5%" />
                                                <?php } else {?>
                                                <button type="button" class="btn btn-info btn-sm float-right"
                                                    data-toggle="modal" data-target="#myModal{{$f->id}}">Lire documenet
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
                                                                <embed src="{{ url('public/images_all/'.$f->fichier) }}"
                                                                    width="450" height="375" type="application/pdf">
                                                                <?php }?>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>



                                            </li>
                                            <?php }}?>

                                        </ul>

                                        </br>
                                        <div class="row">

                                            <div class="col-md-6">

                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#myModal"><i class="fas fas fa-folder">
                                                    </i> {{__("messages.modifier")}} </button>

                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                     

                                                            <span class="autAff"
                                                                style="color:red; margin-left:20%; font-size:18px;"></span>

                                                            <div class="modal-body">
                                                                <form class="form-horizontal" method="POST"
                                                                    action="{{ route('modifier-depense-cv') }}"
                                                                    id="modifierDepense">


                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="id" value="<?php if (isset($depenses->id)) {
        echo $depenses->id;
    }
    ?>">

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.description")}}</label>
                                                                        <input type="text" name="description"
                                                                            class="form-control" id="exampleInputEmail1"
                                                                            placeholder="Description" value="<?php if (isset($depenses->description)) {
        echo $depenses->description;
    }
    ?>">
                                                                        @error('description')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.date")}}</label>
                                                                        <input type="date" name="date"
                                                                            class="form-control" id="exampleInputEmail1"
                                                                            placeholder="" value="<?php if (isset($depenses->date)) {
        echo $depenses->date;
    }
    ?>">
                                                                        @error('date')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.montant")}}</label>
                                                                        <input type="number" name="montant"
                                                                            class="form-control" id="exampleInputEmail1"
                                                                            placeholder="" value="<?php if (isset($depenses->montant)) {
        echo $depenses->montant;
    }
    ?>">
                                                                        @error('montant')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.trubrique")}}</label>
                                                                        <input type="text" name="type"
                                                                            class="form-control" id="exampleInputEmail1"
                                                                            placeholder="Type Rubrique" value="<?php if (isset($depenses->type)) {
        echo $depenses->type;
    }
    ?>">
                                                                        @error('type')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleInputEmail1">{{__("messages.Benéficiaire")}}</label>
                                                                        <input type="text" name="beneficiare"
                                                                            class="form-control" id="exampleInputEmail1"
                                                                            placeholder="Beneficiare" value="<?php if (isset($depenses->beneficiare)) {
        echo $depenses->beneficiare;
    }
    ?>">
                                                                        @error('beneficiare')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.autre_d")}}</label>
                                                                        <textarea type="text" name="autre_detail"
                                                                            class="form-control"><?php if (isset($depenses->autre_detail)) {
        echo $depenses->autre_detail;
    }
    ?></textarea>

                                                                        @error('autre_detail')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>


                                                                    </br>
                                                                    <div class="form-group">
                                                                        <div class="col-md-6 col-md-offset-4">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Enregistrer</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">


                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#myModalDelete"><i class="far fa-trash-alt">
                                                    </i> Supprimer</button>


                                                <div class="modal fade" id="myModalDelete" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">

                                                                <h4 class="modal-title"> Autorisation
                                                                </h4>
                                                            </div>
                                                            <span class="affiche"
                                                                style="font-size:22px; text-align:center">
                                                                {{$depenses->description;}} /
                                                                <?php $date = new DateTime($depenses->date);
    echo $date->format('d-M-Y');?>
                                                            </span>
                                                            <span class="autAff"
                                                                style="color:red; margin-left:20%; font-size:18px;"></span>

                                                            <div class="modal-body">
                                                                <?php if (!empty($autorisation)) { ?>
                                                                <form class="form-horizontal" method="POST"
                                                                    action="{{ route('delete-paiement') }}"
                                                                    id="autorisationPw">


                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="type"
                                                                        value="delete-depense">

                                                                    <input type="hidden" name="id"
                                                                        value="{{$depenses->id}}">
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

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>

                            <div class="<?php if (isset($rapportDepense)) {echo $rapportDepense;}?> tab-pane"
                                id="rapportD">
                                <div class="card-body">
                                    <form action="{{ route('rapport-depense-cv') }}" method="POST">
                                        {{ csrf_field() }}
                                        <center><strong>De : <input type="date" style="width: 223px; padding:14px;"
                                                    name="d1" class="tcal" value="" />
                                                @error('d1')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                A: <input type="date" style="width: 223px; padding:14px;" name="d2"
                                                    class="tcal" value="" />
                                                @error('d2')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <button class="btn btn-info"
                                                    style="width: 123px; height:35px; margin-top:-8px;margin-left:8px;"
                                                    type="submit"><i class="icon icon-search icon-large"></i>
                                                    Rechercher</button>
                                            </strong></center>
                                        </br></br>
                                    </form>
                                    </br>

                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                      <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.description")}}</th>
                                                <th>{{__("messages.Benéficiaire")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>{{__("messages.rubrique")}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @if(isset($rapport))
                                            @foreach($rapport as $k)

                                            <tr>
                                                <td> <?php $date = new DateTime($k->date);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->description}}</td>
                                                <td>{{$k->beneficiare}}</td>
                                                <td>{{$k->montant}} {{ $cc = $k->curency}}</td>
                                                <td>{{$k->type}} </td>


                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>
                                    </br>
                                    @if(isset($somme))
                                    <span style="font-size:22px; font-weight:bold;"> Somme : {{$somme}}
                                        {{$cc}}</span>
                                    @endif
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