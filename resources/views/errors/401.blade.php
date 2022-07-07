@extends('tmp.muso')


@section('content')

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
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Finaliser votre inscription.

                    </h3>
                </div>

                <div class="error-page">
                    <h2 class="headline text-warning"> 401</h2>

                    <div class="error-content">

                        <h5> Bienvenue dans le system de Muso mobile </h5>
                        Pour change votre mode de passe clique sur </br><a style="font-size:17px; color:red;"
                            href="{{ url('mDP')}}/{{$info_muso->id_members}}">
                            Modifier Password </a>


                    </div>
                    <!-- /.error-content -->
                </div>
            </div>
        </div>
    </div>


</section>

@endsection