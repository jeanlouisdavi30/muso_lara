@extends('tmp.muso')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">



                <div class="alert  alert-dismissible col-md-12">
                    <h2>
                        {{$pret_id->first_name}} {{$pret_id->last_name}}
                        <a style="font-size:22px; margin-left:20px; padding:3px;
                                text-decoration:none; background-color:#dc3545; color:white;"
                            href="{{ url('voir-pret-encours') }}/{{ $pret_id->id}}"> {{__("messages.retour")}}  </a>
                    </h2>
                </div>

                <ul class="float-left" style="width:400px;">


                    <li class="list-group-item">
                        <b>{{__("messages.date_echeance")}} </b> <a class="float-right">{{$pret_id->date_decaissement}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{__("messages.montant")}} {{__("messages.decaissement")}} </b> <a class="float-right">{{$pret_id->montant}}
                            {{ $pret_id->curency}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{__("messages.nombre_mois")}}</b> <a class="float-right">{{$pret_id->duree}} Mois</a>
                    </li>

                </ul>

                <ul class="float-right" style="width:400px;">
                    <li class="list-group-item">
                        <b>{{__("messages.taux_interets")}}  </b> <a class="float-right">{{$pret_id->pourcentage_interet}} %</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{__("messages.total_iner")}}  </b> <a class="float-right">
                            <?php
$taux = DB::table('emprunt_apayers')
    ->select(DB::raw("sum(intere_mensuel) as count"))
    ->where('emprunts_id', $pret_id->id)
    ->first();
echo $taux->count;
?> {{ $pret_id->curency}}
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>{{__("messages.total_rem")}}</b> <a class="float-right">{{$pret_id->montanttotal}}
                            {{ $pret_id->curency}} </a>
                    </li>

                </ul>

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
$emprunt_apayers = DB::table('paiement_prets')
    ->where('id_pret_apayers', $pret_id->id)->get();
?>

                        @if(isset($emprunt_apayers))
                        @foreach($emprunt_apayers as $k)

                        <tr>


                            <td><?php $date = new DateTime($k->date_pay);
echo $date->format('d-M-Y');?>
                            </td>
                            <td>{{$k->numeropc}} </td>
                            <td>{{$k->principale_payer}} {{ $pret_id->curency}}</td>
                            <td>{{$k->interet_payer}} {{ $pret_id->curency}}</td>
                            <td>{{$k->montant}} {{ $pret_id->curency}}</td>
                            <td>{{$k->balance_versement}} {{ $pret_id->curency}}</td>

                            <td>
                                {{$k->balance_tt_pret}} {{ $pret_id->curency}}
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