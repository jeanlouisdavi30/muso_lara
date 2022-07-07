@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'decaissement') {
    $decaissement = "active";
} elseif (Request::route()->getName() === 'decaisse-pret') {
    $decaisse = "active";
} elseif (Request::route()->getName() === 'voir-pret-encours') {
    $VPencours = "active";
} elseif (Request::route()->getName() === 'voir-echeance-pret') {
    $echeance = "active";
}

?>


<?php
if (Auth::user()->utype == "admin") {
    $info_muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->id;
} else {
    $info_muso = DB::table('members')->select('members.last_name', 'members.first_name', 'members.id as id_membre', 'musos.name_muso',
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


                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($decaissement)) {echo $decaissement;}?>"
                                    href="#decaissement" data-toggle="tab"> {{__("messages.pret_dec")}}
                                </a></li>

                            <?php if (isset($decaisse)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($decaisse)) {echo $decaisse;}?>" href="#decaisse"
                                    data-toggle="tab"> {{__("messages.Decaisser")}}
                                </a>
                            </li>
                            <?php }?>

                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($pretencours)) {echo $pretencours;}?>"
                                    href="#pretencours" data-toggle="tab"> {{__("messages.pret_en")}}
                                </a>
                            </li>


                            <?php if (isset($VPencours)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($VPencours)) {echo $VPencours;}?>" href="#VPencours"
                                    data-toggle="tab"> {{__("messages.Decaisser")}} 
                                </a>
                            </li>
                            <?php }?>

                            <?php if (isset($echeance)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($echeance)) {echo $echeance;}?>"
                                    href="#autrePaiement" data-toggle="tab"> {{__("messages.echeance")}} 
                                </a>
                            </li>
                            <?php }?>

                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">



                            <div class="<?php if (isset($decaissement)) {echo $decaissement;}?> tab-pane"
                                id="decaissement">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.membre")}} </th>
                                                <th>{{__("messages.titre")}} </th>
                                                <th>{{__("messages.date")}}  DC</th>
                                                <th>{{__("messages.montant")}} </th>
                                                <th>% {{__("messages.interet")}} </th>
                                                <?php
if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {

    ?> <th></th><?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {

    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.statut', 'Approuver')
        ->orderByDesc('prets.created_at')->distinct()->get();
} else {

    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.members_id', $info_muso->id_membre)
        ->where('prets.statut', 'Approuver')
        ->orderByDesc('prets.created_at')->distinct()->get();
}
?>

                                            @if(isset($all_pret))
                                            @foreach($all_pret as $k)

                                            <tr>

                                                <td>{{$k->last_name}} {{$k->first_name}}</td>
                                                <td>{{$k->titre}}</td>
                                                <td><?php $date = new DateTime($k->date_decaissement);
echo $date->format('d-M-Y');?>
                                                </td>
                                                <td>{{$k->montant}} {{$k->curency}}</td>
                                                <td>{{$k->pourcentage_interet}} %</td>

                                                <?php
if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {

    ?>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('decaisse-pret')}}/{{ $k->id_prets}}">
                                                        <i class="fas fas fa-folder"></i> {{__("messages.Decaisser")}}</a>

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


                            <div class="<?php if (isset($pretencours)) {echo $pretencours;}?> tab-pane"
                                id="pretencours">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                               <th>{{__("messages.membre")}} </th>
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
            'prets.titre', 'prets.date_decaissement',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.statut', 'En cours')
        ->orderByDesc('prets.created_at')->distinct()->get();
} else {
    $all_pret = DB::table('members')
        ->select('members.last_name', 'members.first_name',
            'prets.titre', 'prets.date_decaissement',
            'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
            'prets.duree', 'settings.curency', 'prets.id as id_prets')
        ->join('prets', 'prets.members_id', '=', 'members.id')
        ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
        ->where('prets.musos_id', $id_musos)
        ->where('prets.members_id', $info_muso->id_membre)
        ->where('prets.statut', 'En cours')
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
                                                        href="{{ url('voir-pret-encours')}}/{{ $k->id_prets}}">
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

                            <div class="<?php if (isset($decaisse)) {echo $decaisse;}?> tab-pane" id="decaisse">

                                <div class="card-body">
                                    <div class="post clearfix">
                                        <div class="row">

                                            <?php if (!empty($pret)) {?>
                                            @error('montant')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.membre")}}</b> <a class="float-right">{{$pret->last_name}}
                                                            {{$pret->first_name}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.caisses")}}</b> <a class="float-right"> {{$pret->caisse}} </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.titre")}}</b> <a class="float-right">{{$pret->titre}}</a>
                                                    </li>


                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant")}}</b> <a class="float-right">{{$pret->montant}}
                                                            {{$pret->curency}}</a>
                                                    </li>



                                                </ul>
                                                <form method="post"
                                                    action="{{ route('autorisation-decaissement-pret') }}"
                                                    accept-charset="utf-8">
                                                    @csrf

                                                    <input type="hidden" name="id_pret" value="{{ $pret->id_prets}}">
                                                    <input type="hidden" name="duree" value="{{ $pret->duree}}">
                                                    <input type="hidden" name="montant" value="{{ $pret->montant}}">
                                                    <input type="hidden" name="caisse" value="{{ $pret->caisse}}">
                                                    <input type="hidden" name="pmensuel" value="{{ $pret->pmensuel}}">
                                                    <input type="hidden" name="intere_mensuel"
                                                        value="{{ $pret->intere_mensuel}}">
                                                    <input type="hidden" name="ttalmensuel"
                                                        value="{{ $pret->ttalmensuel}}">
                                                    <input type="hidden" name="montanttotal"
                                                        value="{{ $pret->montanttotal}}">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{__("messages.date")}} {{__("messages.decaissement")}} </label>
                                                        <input type="date" name="date_decaissement" class="form-control"
                                                            id="exampleInputEmail1" placeholder="">
                                                        @error('date_decaissement')
                                                        <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    </br>
                                                    <div class="form-group">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">{{__("messages.btn_enregistrer")}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <?php }?>


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
$all_pret = DB::table('members')
    ->select('members.last_name', 'members.first_name',
        'prets.titre', 'prets.date_decaissement', 'prets.caisse',
        'prets.montant', 'prets.ttalmensuel', 'prets.duree', 'prets.pourcentage_interet',
        'prets.duree', 'settings.curency', 'prets.id as id_prets')
    ->join('prets', 'prets.members_id', '=', 'members.id')
    ->join('settings', 'settings.musos_id', '=', 'prets.musos_id')
    ->where('prets.musos_id', $id_musos)
    ->orderByDesc('prets.created_at')->distinct()->get();
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
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-pret')}}/{{ $k->id_prets}}">
                                                        <i class="fas fas fa-folder"></i> Voir</a>

                                                </td>


                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>



                            <div class="<?php if (isset($VPencours)) {echo $VPencours;}?> tab-pane" id="VPencours">

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
                                                        <b>{{__("messages.date")}} {{__("messages.decaissement")}} </b> <a class="float-right"><?php $date = new DateTime($pret->date_decaissement);
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
                                                        <b>{{__("messages.principal_m")}} </b> <a
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
                                                        <b>{{__("messages.total_m")}} </b> <a
                                                            class="float-right">{{$pret->ttalmensuel}}
                                                            {{$pret->curency}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.montant_t_du")}} </b> <a
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

                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                                <div class="col-md-12" style="padding-top:40px;">
                                                    <a href="{{ url('remboursement-pret/'.$pret->id_prets)}}">

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
                                                <?php }?>



                                                <div class="col-md-12" style="padding-top:40px;">

                                                    <a href="{{ url('fiche-pret/'.$pret->id_prets)}}">

                                                        <div class="info-box mb-2 bg-danger">
                                                            <span class="info-box-icon"><i
                                                                    class="fas fa-money-check"></i></span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">{{__("messages.fiche_em")}}</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>

                                                    </a>
                                                </div>


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

                                    </div>
                                </div>

                            </div>

                            <div class="<?php if (isset($echeance)) {echo $echeance;}?> tab-pane" id="list_emprunts">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
												<th>{{__("messages.date")}} </th>
                                                <th>{{__("messages.principal_m")}} </th>
												<th>{{__("messages.inter_m")}} </th>
                                                <th>{{__("messages.total_m")}}  </th>
												
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