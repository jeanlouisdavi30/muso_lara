@extends('tmp.muso')

@section('content')

<section class="content">

    <div class="card-header p-2">
        <ul class="nav nav-pills">

            <li class="nav-item">
                <a class="nav-link" href="{{ url('voir-emprunt') }}/{{$emprunt_id->id}}">{{__("messages.retour")}}
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="{{ url('fiche-emprunt') }}/{{$emprunt_id->id}}">{{__("messages.fiche_em")}}

                </a>
            </li>




        </ul>
    </div><!-- /.card-header -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="row" style="background-color:white; padding-top:40px;">
                    <div class="col-md-6">
                        <ul class="float-left" style="width:450px;">

                            <li class="list-group-item">
                                <b>{{__("messages.date_echeance")}}</b> <a class="float-right">{{$emprunt_id->date_decaissement}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__("messages.montant")}} {{__("messages.decaissement")}}</b> <a class="float-right">{{$emprunt_id->montant}}
                                    {{ $emprunt_id->curency}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__("messages.nombre_mois")}}</b> <a class="float-right">{{$emprunt_id->duree}} Mois</a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-md-6" style="">
                        <ul class="float-right" style="width:450px;">
                            <li class="list-group-item">
                                <b>{{__("messages.taux_interets")}} </b> <a class="float-right">{{$emprunt_id->pourcentage_interet}} %</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__("messages.total_iner")}} </b> <a class="float-right">
                                    <?php
$taux = DB::table('emprunt_apayers')
    ->select(DB::raw("sum(intere_mensuel) as count"))
    ->where('emprunts_id', $emprunt_id->id)
    ->first();
echo $taux->count;
?> {{ $emprunt_id->curency}}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__("messages.total_rem")}}</b> <a class="float-right">{{$emprunt_id->montanttotal}}
                                    {{ $emprunt_id->curency}} </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card">
                    <table id="" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                  <th>{{__("messages.date")}}</th>
                            <th># PC</th>
                            <th>{{__("messages.prin_p")}}</th>
                            <th>{{__("messages.interet")}} </th>
                            <th>{{__("messages.total")}}Total</th>
                            <th>{{__("messages.balance_v")}}</th>
                            <th>{{__("messages.balance_t_p")}} </th>
                            <th>{{__("messages.date_a_pa")}} </th>
                            <th>{{__("messages.statut")}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
$emprunts = DB::table('emprunts')
    ->where('id', $emprunt_id->id)->first();
$emprunts->montanttotal;

$emprunt_apayers = DB::table('paiement_emprunts')
    ->where('id_emprunt_apayers', $emprunt_id->id)->get();
?>

                            @if(isset($emprunt_apayers))
                            @foreach($emprunt_apayers as $k)

                            <tr>


                                <td><?php $date = new DateTime($k->date_pay);
echo $date->format('d-M-Y');?>
                                </td>
                                <td>{{$k->numeropc}} </td>
                                <td>{{$k->principale_payer}} {{ $emprunt_id->curency}}</td>
                                <td>{{$k->interet_payer}} {{ $emprunt_id->curency}}</td>
                                <td>{{$k->montant}} {{ $emprunt_id->curency}}</td>
                                <td>{{$k->balance_versement}} {{ $emprunt_id->curency}}</td>

                                <td>
                                    {{$k->balance_tt_pret}} {{ $emprunt_id->curency}}
                                </td>
                                <td><?php $date = new DateTime($k->date_du_paiement);
echo $date->format('d-M-Y');?>
                                </td>
                                <td>{{$k->statut}} </td>

                            </tr>


                            @endforeach
                            @endif
                            </br>


                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection