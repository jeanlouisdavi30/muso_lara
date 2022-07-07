@extends('tmp.muso')

@section('content')

<div class="row-fluid">


    <?php $info = DB::table('musos')->where('users_id', Auth::user()->id)->first();
$id_musos = $info->id;?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-9">

                    <div class="alert  alert-dismissible col-md-7">
                        <h2>
                            {{__("messages.remboursement")}} </h2>
                    </div>
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">

                                <li class="nav-item">
                                    <a class="nav-link active"
                                        href="{{ url('voir-emprunt') }}/{{$emprunt_id->id_emprunts}}">{{__("messages.retour")}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('fiche-emprunt') }}/{{$emprunt_id->id_emprunts}}">
                                        {{__("messages.fiche_em")}}
                                    </a>
                                </li>




                            </ul>
                        </div><!-- /.card-header -->

                        <div class="card-body">


                            <div class="tab-pane">

                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
                                </script>


                                <div class="row">
                                    <div class="col-md-6">
                                        <script type="text/javascript">
                                        function sumeBalance() {


                                            var balance_total_pret = document.getElementById('balance_total_pret')
                                                .value;

                                            var balanceBN = document.getElementById('balanceBN').value;
                                            var mpayeb = document.getElementById('mpayeb').value;


                                            document.getElementById('balance_ver_b').value = 0;

                                            document.getElementById('balance_total_pret').value = parseFloat(mpayeb) +
                                                parseFloat(balance_total_pret);


                                            var sommeApayer = document.getElementById('sommeApayerB').value;
                                            var sommeDejapayer = document.getElementById('sommeDejapayerB').value;

                                            var somB = parseFloat(balanceBN) + parseFloat(mpayeb);
                                            if (parseFloat(balanceBN) > parseFloat(mpayeb)) {

                                                document.getElementById('balance_ver_b').value = parseFloat(balanceBN) -
                                                    parseFloat(mpayeb);
                                            } else {
                                                document.getElementById('balance_ver_b').value = 0;
                                            }



                                            var tt_sommeDejapayer = parseFloat(mpayeb) + parseFloat(
                                                sommeDejapayer);


                                            var tt_sommeApayer = parseFloat(sommeApayer) - parseFloat(
                                                tt_sommeDejapayer);



                                            document.getElementById('balance_total_pret').value = parseFloat(
                                                tt_sommeApayer);

                                            document.getElementById('balance').value = parseFloat(
                                                mpayeb);


                                        }

                                        function sumeEmprunt() {

                                            var intere_mensuel = document.getElementById('intere_mensuel').value;
                                            var ppayer = document.getElementById('ppayer').value;

                                            var mpaye = document.getElementById('mpaye').value;
                                            var ttalmensuel = document.getElementById('ttalmensuel').value;

                                            if (parseFloat(mpaye) === parseFloat(ttalmensuel)) {
                                                document.getElementById('balance_ver').value = 0;
                                                document.getElementById('inmensuel').value = intere_mensuel;
                                                document.getElementById('ppayer').value = parseFloat(ttalmensuel) -
                                                    parseFloat(intere_mensuel);;
                                            } else if (parseFloat(mpaye) < parseFloat(ttalmensuel)) {

                                                if (parseFloat(mpaye) < parseFloat(intere_mensuel)) {
                                                    document.getElementById('inmensuel').value = mpaye
                                                } else if (parseFloat(intere_mensuel) == parseFloat(mpaye)) {
                                                    document.getElementById('inmensuel').value = intere_mensuel;
                                                } else {
                                                    document.getElementById('ppayer').value = parseFloat(mpaye) -
                                                        parseFloat(intere_mensuel);
                                                    document.getElementById('inmensuel').value = intere_mensuel;
                                                }
                                                var result = parseFloat(ttalmensuel) - parseFloat(mpaye);
                                                document.getElementById('balance_ver').value = result;

                                            } else if (parseFloat(mpaye) > parseFloat(ttalmensuel)) {
                                                var principal_payer = document.getElementById('principal_payer').value;
                                                document.getElementById('balance_ver').value = 0;
                                                document.getElementById('inmensuel').value = intere_mensuel;
                                                document.getElementById('ppayer').value = principal_payer;

                                            }

                                            var sommeApayer = document.getElementById('sommeApayer').value;
                                            var sommeDejapayer = document.getElementById('sommeDejapayer').value;

                                            var tt_sommeDejapayer = parseFloat(mpaye) + parseFloat(
                                                sommeDejapayer);


                                            var tt_sommeApayer = parseFloat(sommeApayer) - parseFloat(
                                                tt_sommeDejapayer);



                                            document.getElementById('balance_total_prett').value = parseFloat(
                                                tt_sommeApayer);

                                        }
                                        </script>
                                        @if($montant_res != '0.0')

                                        <ul style="width:450px;">

                                            <li class="list-group-item">
                                                <b>{{__("messages.principal_m")}}</b> <a
                                                    class="float-right">{{$emprunt_id->pmensuel}}
                                                    {{ $emprunt_id->curency}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.inter_m")}}</b> <a
                                                    class="float-right">{{$emprunt_id->intere_mensuel}}
                                                    {{ $emprunt_id->curency}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.date")}} {{__("messages.paiement")}}</b> <a
                                                    class="float-right">
                                                    <?php $date = new DateTime($emprunt_id->date_paiement);
echo $date->format('d-M-Y');?>
                                                </a>
                                            </li>

                                        </ul>



                                        @if (session('success'))
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            <h5><i class="icon fas fa-check"></i>
                                                {{ session('success') }}
                                                !</h5>
                                        </div>
                                        @endif

                                        @if (session('Error'))
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            <h5><i class="icon fas fa-check"></i>
                                                {{ session('Error') }}
                                                !</h5>
                                        </div>
                                        @endif

                                        <?php
if (empty($paiement->balance_versement)) {
    $new_versement = true;
} else {
    $new_versement = false;
}
?>

                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        <!-- /.card-header -->


                                        <form method="post" action="{{ route('save-remboursement') }}"
                                            accept-charset="utf-8" enctype="multipart/form-data">

                                            @csrf

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.date")}} </label>
                                                <input type="date" name="date_pay" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('date_pay')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1"># PC</label>
                                                <input type="text" name="numeropc" class="form-control" id="montant"
                                                    placeholder="">
                                                @error('numeropc')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <input type='hidden' class='form-control' name='date_du_paiement'
                                                value='{{$paiement->date_paiement}}'>
                                            <input type='hidden' class='form-control' name='emprunt_apayers_id'
                                                value='{{$paiement->emprunts_id}}'>

                                            <input type='hidden' class='form-control' name='id'
                                                value='{{$paiement->id}}'>

                                            <?php
$emprunt_apayers = DB::table('paiement_emprunts')
    ->where('id_emprunt_apayers', $emprunt_id->id_emprunts)
    ->orderByDesc('id')
    ->first();

$sum = DB::table('paiement_emprunts')
    ->select(DB::raw("sum(montant) as count"))
    ->where('id_emprunt_apayers', $emprunt_id->id_emprunts)
    ->first();
if (empty($sum->count)) {
    $total = 0;
} else {
    $total = $sum->count;
}

?>

                                            <?php if (!empty($emprunt_apayers->balance_versement) and $emprunt_apayers->balance_versement > 0) {?>

                                            <label for='exampleInputEmail1'>{{__("messages.montant_p")}}</label>
                                            <input type='number' onkeyup='sumeBalance();' name='montant'
                                                class='form-control' id='mpayeb'>
                                            @error('montant')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <label for='exampleInputEmail1'>{{__("messages.int_p")}} </label>
                                            <input type='number' onkeyup='sumeBalance();' name='interet_payer'
                                                class='form-control' id='interetBalance' value='0'>

                                            <label for='exampleInputEmail1'>{{__("messages.prin_p")}} </label>
                                            <input type='text' onkeyup='sumeBalance();' name='principale_payer'
                                                class='form-control' id='balance'>

                                            <label for='exampleInputEmail1'>{{__("messages.balance_v")}} </label>
                                            <input type='text' onkeyup='sumeBalance();' name='balance_versement'
                                                class='form-control' id='balance_ver_b'>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.balance_t_p")}}</label>
                                                <input type="number" name="balance_tt_pret" class="form-control"
                                                    id="balance_total_pret" onkeyup='sumeBalance();'>
                                                @error('balance_tt_pret')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <input type='hidden' id='sommeApayerB' onkeyup='sumeBalance();'
                                                name="montanttotal" value="<?php echo $emprunt_id->montanttotal; ?>">

                                            <input type='hidden' id='sommeDejapayerB' onkeyup='sumeBalance();'
                                                value="<?php echo $total; ?>">


                                            <input type='hidden' name='date_paiement'
                                                value='{{$paiement->date_paiement}}'>
                                            <input type='hidden' onkeyup='sumeBalance();' class='form-control'
                                                id='balanceBN' value='{{ $emprunt_apayers->balance_versement }}'>

                                            <?php } else {?>

                                            <input type='hidden' id='sommeApayer' onkeyup='sumeEmprunt();'
                                                name="montanttotal" value="<?php echo $emprunt_id->montanttotal; ?>">

                                            <input type='hidden' id='sommeDejapayer' onkeyup='sumeEmprunt();'
                                                value="<?php echo $total; ?>">

                                            <label for=' exampleInputEmail1'> {{__("messages.montant_p")}} </label>
                                            <input type='number' onkeyup='sumeEmprunt();' name='montant'
                                                class='form-control' id='mpaye'>
                                            @error('montant')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <label for='exampleInputEmail1'>{{__("messages.int_p")}} </label>
                                            <input type='number' onkeyup='sumeEmprunt();' name='interet_payer'
                                                class='form-control' id='inmensuel'>

                                            <label for='exampleInputEmail1'>{{__("messages.prin_p")}} </label>
                                            <input type='text' onkeyup='sumeEmprunt();' name='principale_payer'
                                                class='form-control' id='ppayer'>

                                            <label for='exampleInputEmail1'>{{__("messages.balance_v")}}</label>
                                            <input type='text' onkeyup='sumeEmprunt();' name='balance_versement'
                                                class='form-control' id='balance_ver'>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.balance_t_p")}} </label>
                                                <input type="text" name="balance_tt_pret" class="form-control"
                                                    id="balance_total_prett" onkeyup='sumeEmprunt();'>
                                                @error('balance_tt_pret')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <input type='hidden' name='date_paiement'
                                                value='{{$paiement->date_paiement}}'>
                                            <input type='hidden' onkeyup='sumeEmprunt();' class='form-control'
                                                id='ttalmensuel' value='{{$paiement->ttalmensuel}}'>
                                            <input type='hidden' onkeyup='sumeEmprunt();' class='form-control'
                                                id='principal_payer' value='{{$paiement->pmensuel}}'>
                                            <input type='hidden' onkeyup='sumeEmprunt();' class='form-control'
                                                id='intere_mensuel' value='{{$paiement->intere_mensuel}}'>

                                            <?php }?>





                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.desc_pret")}} </label>
                                                <textarea type="text" name="description"
                                                    class="form-control"></textarea>

                                                @error('description')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
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
                                                    <button type="submit"
                                                        class="btn btn-danger">{{__("messages.sauvegarde")}}</button>
                                                </div>
                                            </div>
                                        </div>
                                        </form>

                                    </div>

                                    @else

                                    <span> Fin de remboursement </span>

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