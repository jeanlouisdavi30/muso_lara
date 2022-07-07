@extends('tmp.muso')

@section('content')

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

$users = DB::table('users')->where('id', Auth::user()->id)->first();

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0" style="font-weight:500;">
                    {{$name_muso}} @if(isset($info_muso->last_name))
                    - <span style="font-size:17px; color:red;"> <i class="nav-icon fas fa-user"></i>
                        {{ $info_muso->last_name }}
                        {{ $info_muso->first_name }} </span> <span style="font-size:18px;">({{ $users->utype}})</span>
                    @endif
                </h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="card-body">
    <div class="tab-content">

        <div class="row">
            <div class="col-md-9">
                <div class="active tab-pane" id="activity" style=" padding:15px; background-color:white;">
                    <!-- Post -->
                    <div class="post clearfix">
                        <ul class="list-group list-group-unbordered mb-4">
                            <li class="list-group-item">
                                <b> {{__("messages.nommutuel")}}</b> <a class="float-right">{{$info_muso->name_muso}}</a>
                            </li>
                            <li class="list-group-item">
                                <b> {{__("messages.presentation")}}</b> <a class="float-right">{{$info_muso->representing}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__("messages.telephone")}}</b> <a class="float-right">{{$info_muso->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{__("messages.datecreation")}} </b> <a
                                    class="float-right">{{$info_muso->registered_date}}</a>
                            </li>

                            <li class="list-group-item">
                                <b>{{__("messages.pays")}}Pays</b> <a class="float-right">{{$info_muso->contry}}</a>
                            </li>

                            <li class="list-group-item">
                                <b>{{__("messages.reseaux")}}</b> <a class="float-right">{{$info_muso->network}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection