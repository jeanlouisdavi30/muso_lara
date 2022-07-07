@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'transfert-cr') {
    $liste_transfert = "active";
} elseif (Request::route()->getName() === 'nouveau-transfert-cr') {
    $transfert = "active";
} elseif (Request::route()->getName() === 'voir-transfert-cr') {
    $voirtransfer = "active";
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

<!-- Main content -->
<section class="content">




    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="alert  alert-dismissible col-md-7">
                    <h2>
                        {{__("messages.transferts")}} {{__("messages.cr")}} </h2>
                </div>

                <div class="card">

                    <div class="card-header p-2">

                        <ul class="nav nav-pills">

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($liste_transfert)) {echo $liste_transfert;}?>"
                                    href="#liste_transfert" data-toggle="tab">{{__("messages.transferts")}}
                                    {{__("messages.Sortons")}}
                                </a>
                            </li>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($tranfert_entrants)) {echo $tranfert_entrants;}?>"
                                    href="#tranfert_entrants" data-toggle="tab">{{__("messages.Entrants")}}
                                </a>
                            </li>
                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($transfert)) {echo $transfert;}?>"
                                    href="{{ url('nouveau-transfert-cr') }}"> {{__("messages.transfert")}}
                                </a>
                            </li>
                            <?php }?>

                            <?php if (isset($voirtransfer)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voirtransfer)) {echo $voirtransfer;}?>"
                                    href="#voirtransfer" data-toggle="tab"> {{__("messages.voir")}}
                                    {{__("messages.transferts")}}
                                </a>
                            </li>
                            <?php }?>

                        </ul>

                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">


                            <div class="<?php if (isset($transfert)) {echo $transfert;}?> tab-pane" id="transfert">
                                <div class="row">
                                    <div class="col-md-6">

                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif


                                        <!-- /.card-header -->
                                        <form method="post" action="{{ route('save-transfert-cr') }}">
                                            @csrf



                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.date")}}</label>
                                                <input type="date" name="date_entre" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('date_entre')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.titre")}}</label>
                                                <input type="text" name="titre" class="form-control"
                                                    id="exampleInputEmail1" placeholder="titre">
                                                @error('titre')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.montant")}}</label>
                                                <input type="text" name="montant" class="form-control"
                                                    id="exampleInputEmail1" placeholder="montant">
                                                @error('montant')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.caisse")}}</label>
                                                <input type="hidden" name="caisse" class="form-control"
                                                    id="exampleInputEmail1" value="Caisse-rouge">

                                                <select name="transfer_caisse" class="form-control">
                                                    <option value=""> {{__("messages.selectionner")}}
                                                        {{__("messages.caisse")}} </option>
                                                    <option value="Caisse-bleue"> {{__("messages.cb")}} </option>
                                                    <option value="Caisse-vert"> {{__("messages.cv")}}</option>
                                                </select>
                                                @error('transfer_caisse')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.autre_d")}}</label>
                                                <textarea class="form-control" name="detail"></textarea>
                                                @error('detail')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary">{{__("messages.btn_enregistrer")}}</button>
                                            </div>

                                        </form>


                                    </div>
                                </div>
                            </div>


                            <div class="<?php if (isset($liste_transfert)) {echo $liste_transfert;}?> tab-pane"
                                id="liste_transfert">


                                <div class="card-body">

                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.titre")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>{{__("messages.transfert")}}</th>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                                <th></th><?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($transfer))
                                            @foreach($transfer as $k)

                                            <tr>

                                                <td>
                                                    <?php $date = new DateTime($k->date_entre);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->titre}}</td>
                                                <td>{{$k->montant}} {{ $settings->curency }}</td>
                                                <td>{{$k->transfer_caisse}}</td>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-transfert-cr')}}/{{ $k->id}}"> <i
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




                            <div class="<?php if (isset($tranfert_entrants)) {echo $tranfert_entrants;}?> tab-pane"
                                id="tranfert_entrants">


                                <div class="card-body">

                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.titre")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>{{__("messages.caisses")}}</th>
                                                <th>{{__("messages.autre_d")}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($transfer_entrants))
                                            @foreach($transfer_entrants as $k)

                                            <tr>

                                                <td>
                                                    <?php $date = new DateTime($k->date_entre);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->titre}}</td>
                                                <td>{{$k->montant}} {{ $settings->curency }}</td>
                                                <td>{{$k->caisse}}</td>
                                                <td>{{$k->detail}}</td>

                                            </tr>

                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>

                            <div class="<?php if (isset($voirtransfer)) {echo $voirtransfer;}?> tab-pane"
                                id="voirtransfer">

                                <div class="card-body">
                                    <div class="post clearfix">
                                        <?php if (!empty($transfer_id)) {?>
                                        <div class="row">

                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.titre")}}</b> <a
                                                            class="float-right">{{$transfer_id->titre}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant")}}</b> <a
                                                            class="float-right">{{$transfer_id->montant}}
                                                            {{$settings->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.date")}} {{__("messages.decaissement")}}</b>
                                                        <a class="float-right"><?php $date = new DateTime($transfer_id->date_entre);
    echo $date->format('d-M-Y');?></a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.transfert")}}</b> <a
                                                            class="float-right">{{$transfer_id->transfer_caisse}}</a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>{{__("messages.autre_d")}}</b> <a
                                                            class="float-right">{{$transfer_id->detail}}</a>
                                                    </li>

                                            </div>






                                        </div>
                                        <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                        <x-autorisation type="delete-transfert-cr" :autorisation="$autorisation"
                                            :id="$transfer_id->id" />

                                        <?php }?>
                                    </div>
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