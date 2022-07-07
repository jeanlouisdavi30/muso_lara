@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'parametre-muso' or Request::route()->getName() === 'update-info-muso') {
    $parametreMuso = "active";
} elseif (Request::route()->getName() === 'reload-profile') {
    $save_profile = "active";
} elseif (Request::route()->getName() === 'reload-parametre') {
    $reload_parametre = "active";
} elseif (Request::route()->getName() === 'reload-adresse') {
    $reload_adresse = "active";
} elseif (Request::route()->getName() === 'reload-autorisation') {
    $reload_autorisation = "active";
}

?>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($parametreMuso)) {echo $parametreMuso;}?>"
                                    href="#activity" data-toggle="tab">{{__("messages.info")}}
                                </a></li>
                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($save_profile)) {echo $save_profile;}?>"
                                    href="#timeline" data-toggle="tab">{{__("messages.profil")}}
                                </a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($reload_parametre)) {echo $reload_parametre;}?>"
                                    href="#parametre" data-toggle="tab">{{__("messages.parametrer")}}
                                </a>
                            </li>
                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a class="nav-link" href="#password"
                                    data-toggle="tab">{{__("messages.m_pass")}}
                                </a>
                            </li>
                            <?php }?>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($reload_adresse)) {echo $reload_adresse;}?>"
                                    href="#adresse" data-toggle="tab">
                                    {{__("messages.adresse")}}
                                </a>
                            </li>

                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($reload_autorisation)) {echo $reload_autorisation;}?>"
                                    href="#autorisation" data-toggle="tab">
                                    {{__("messages.autorisation")}}
                                </a>
                            </li>


                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($reload_autorisation)) {echo $reload_autorisation;}?>"
                                    href="#caisse" data-toggle="tab">
                                    {{__("messages.caisses")}}
                                </a>
                            </li>

                            <?php }?>

                            <li class="nav-item"><a class="nav-link" href="{{ url('reglement-mutuel') }}">
                                    {{__("messages.reglements")}}
                                </a>
                            </li>


                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">
                        <div class="tab-content">


                            <div class="tab-pane" id="caisse">

                                <span class="afficheCaisse" style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;

                                    "></span>

                                <form class="form-horizontal" method="POST" action="{{ route('update-caisse') }}"
                                    id="mdCaisse">

                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">{{__("messages.cb")}}
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="caisseBleue"
                                                value="{{ $caisse->caisseBleue }}" <x-disabled
                                                :type="Auth::user()->utype" />
                                            required>
                                            <span class="caisseBleue_error" style="color:red;"> </span>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">{{__("messages.cv")}}</label>

                                        <div class="col-md-4">
                                            <input type="text" value="{{ $caisse->caisseVert }}" class="form-control"
                                                name="caisseVert" <x-disabled :type="Auth::user()->utype" /> required>

                                            <span class="caisseVert_error" style="color:red;"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">{{__("messages.cr")}}</label>

                                        <div class="col-md-4">
                                            <input type="text" <x-disabled :type="Auth::user()->utype" />
                                            class="form-control" value="{{ $caisse->caisseRouge }}"
                                            name="caisseRouge">
                                        </div>

                                        <span class="caisseRouge_error" style="color:red;"> </span>
                                    </div>

                                    <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <x-button value="{{__('messages.btn_modifier')}}" class="btn btn-danger"
                                                :type="Auth::user()->utype" />


                                        </div>
                                    </div>

                                    <?php }?>
                                </form>
                            </div>

                            <div class="tab-pane <?php if (isset($parametreMuso)) {echo $parametreMuso;}?>"
                                id="activity">


                                <!-- Post -->
                                <div class="post clearfix">


                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group list-group-unbordered mb-4">
                                                <li class="list-group-item">
                                                    <b>{{__("messages.nommutuel")}}</b> <a
                                                        class="float-right">{{$info_muso->name_muso}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>{{__("messages.presentation")}}</b> <a
                                                        class="float-right">{{$info_muso->representing}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>{{__("messages.telephone")}}</b> <a
                                                        class="float-right">{{$info_muso->phone}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>{{__("messages.datecreation")}}</b> <a
                                                        class="float-right">{{$info_muso->registered_date}}</a>
                                                </li>

                                                <li class="list-group-item">
                                                    <b>{{__("messages.pays")}}</b> <a
                                                        class="float-right">{{$info_muso->contry}}</a>
                                                </li>

                                                <li class="list-group-item">
                                                    <b>{{__("messages.reseaux")}}</b> <a
                                                        class="float-right">{{$info_muso->network}}</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <!-- Trigger the modal with a button -->
                                        <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                        @if(isset($info_muso->id))
                                        <button type="button" class="btn
                                        btn-danger" data-toggle="modal"
                                            data-target="#myModalprofile">{{__("messages.btn_modifier")}}</button>
                                        @endif

                                        <?php }?>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModalprofile" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">

                                                    <span class="affiche"
                                                        style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;">

                                                    </span>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" method="POST"
                                                            action="{{ route('update-info-muso') }}"
                                                            enctype="multipart/form-data" id="main_form_mp">


                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="id"
                                                                value="<?php echo $id_muso; ?>">

                                                            <hr>
                                                            <div class=" form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.nommutuel")}}</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="name_muso"
                                                                        class="form-control" placeholder="name_muso"
                                                                        value=" <?php if (isset($info_muso->name_muso)) {
    echo $info_muso->name_muso;
}
?>">
                                                                </div>
                                                                <span class="name_muso_error" style="color:red;">
                                                                </span>

                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.telephone")}}</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="phone" class="form-control"
                                                                        id="inputName" placeholder="phone" value="<?php if (isset($info_muso->phone)) {
    echo $info_muso->phone;
}
?>">
                                                                </div>

                                                                <span class="phone_error" style="color:red;">
                                                                </span>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.representant")}}</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="representing"
                                                                        class="form-control" id="inputName"
                                                                        placeholder="representing" value="<?php if (isset($info_muso->representing)) {
    echo $info_muso->representing;
}
?>">
                                                                </div>

                                                                <span class="representing_error" style="color:red;">
                                                                </span>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.datecreation")}}</label>
                                                                <div class="col-sm-9">
                                                                    <input type="date" name="registered_date"
                                                                        class="form-control" id="inputName"
                                                                        placeholder="Vision" value="<?php if (isset($info_muso->registered_date)) {
    echo $info_muso->registered_date;
}
?>">
                                                                </div>

                                                                <span class="registered_date_error" style="color:red;">
                                                                </span>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.reseaux")}}</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="network"
                                                                        class="form-control" id="inputName"
                                                                        placeholder="network" value="<?php if (isset($info_muso->network)) {
    echo $info_muso->network;
}
?> ">
                                                                </div>

                                                                <span class="network_error" style="color:red;">
                                                                </span>
                                                            </div>



                                                            </br>
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-md-offset-4">

                                                                    <x-button value="{{__('messages.btn_enregistrer')}}"
                                                                        class="btn btn-primary"
                                                                        :type="Auth::user()->utype" />

                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">{{__('messages.btn_ferme')}}</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.post -->

                            </div>













                            <!-- /.tab-pane -->
                            <div class="tab-pane <?php if (isset($save_profile)) {echo $save_profile;}?>" id="timeline">
                                <!-- The timeline -->


                                <div class="row">

                                    <div class="col-md-8">


                                        </br>
                                        @if(!isset($profile->id))
                                        <div class="panel-body">
                                            @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                            @endif

                                            <span class="affiche"
                                                style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;"></span>


                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('save-profil') }}" enctype="multipart/form-data"
                                                id="main_form">


                                                {{ csrf_field() }}

                                                <input type="hidden" name="musos_id" value="<?php echo $id_muso; ?>">
                                                <span class="musos_id_error" style="color:red;"> </span>
                                                @if(!isset($profile->id))
                                                <div class="form-group row">
                                                    <label for="inputName"
                                                        class="col-sm-3 col-form-label">{{__("messages.photo")}}</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" name="file">
                                                    </div>
                                                    <span class="file_error" style="color:red;"> </span>

                                                </div>
                                                @else
                                                <img width="50%"
                                                    src="{{ url('public/images_all/'.$profile->picture) }}">
                                                @endif
                                                <hr>
                                                <div class=" form-group row">
                                                    <label for="inputName"
                                                        class="col-sm-3 col-form-label">{{__("messages.presentation")}}</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" name="presantation" class="form-control"
                                                            placeholder="Presantation">  @if(isset($profile->presantation)) {{$profile->presantation}} @endif  </textarea>
                                                    </div>
                                                    <span class="presantation_error" style="color:red;"> </span>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputName"
                                                        class="col-sm-3 col-form-label">{{__("messages.mission")}}</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" name="mission" class="form-control"
                                                            id="inputName"
                                                            placeholder="Mission"> @if(isset($profile->mission)) {{$profile->mission}} @endif  </textarea>
                                                    </div>

                                                    <span class="mission_error" style="color:red;"> </span>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputName"
                                                        class="col-sm-3 col-form-label">{{__("messages.valeurs")}}</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" name="value" class="form-control"
                                                            id="inputName"
                                                            placeholder="Value">@if(isset($profile->value)) {{$profile->value}} @endif  </textarea>
                                                    </div>

                                                    <span class="value_error" style="color:red;"> </span>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputName"
                                                        class="col-sm-3 col-form-label">{{__("messages.vision")}}</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" name="vision" class="form-control"
                                                            id="inputName"
                                                            placeholder="Vision">@if(isset($profile->vision)) {{$profile->vision}} @endif  </textarea>
                                                    </div>

                                                    <span class="vision_error" style="color:red;"> </span>
                                                </div>

                                                </br>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <x-button value="{{__('messages.btn_enregistrer')}}"
                                                            class="btn btn-primary" :type="Auth::user()->utype" />
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </form>
                                        </div>
                                        @else
                                    </div>

                                    <div class="col-md-12">
                                        <ul class="list-group list-group-unbordered mb-4">
                                            <li class="list-group-item">
                                                <b>{{__("messages.representant")}}</b> <a
                                                    class="float-right">@if(isset($profile->presantation))
                                                    {{$profile->presantation}} @endif</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.mission")}}</b> <a
                                                    class="float-right">@if(isset($profile->mission))
                                                    {{$profile->mission}} @endif</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.vision")}}</b> <a
                                                    class="float-right">@if(isset($profile->vision))
                                                    {{$profile->vision}} @endif</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>{{__("messages.valeurs")}}</b> <a
                                                    class="float-right">@if(isset($profile->value))
                                                    {{$profile->value}} @endif</a>
                                            </li>


                                        </ul>
                                        @endif
                                    </div>

                                    <div class="container">
                                        <!-- Trigger the modal with a button -->
                                        <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                        @if(isset($profile->id))
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#myModal"> {{__('messages.btn_modifier')}}
                                            profil</button>
                                        @endif

                                        <?php }?>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">

                                                    <span class="affiche"
                                                        style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;">

                                                    </span>

                                                    <div class="modal-body">
                                                        <form class="form-horizontal" method="POST"
                                                            action="{{ route('update-profil') }}"
                                                            enctype="multipart/form-data" id="main_form_profile">


                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="musos_id"
                                                                value="<?php echo $id_muso; ?>">

                                                            <hr>
                                                            <div class=" form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.representant")}}</label>
                                                                <div class="col-sm-9">
                                                                    <textarea type="text" name="presantation"
                                                                        class="form-control"
                                                                        placeholder="Presantation">  @if(isset($profile->presantation)) {{$profile->presantation}} @endif  </textarea>
                                                                </div>
                                                                <span class="presantation_error" style="color:red;">
                                                                </span>

                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.mission")}}</label>
                                                                <div class="col-sm-9">
                                                                    <textarea type="text" name="mission"
                                                                        class="form-control" id="inputName"
                                                                        placeholder="Mission"> @if(isset($profile->mission)) {{$profile->mission}} @endif  </textarea>
                                                                </div>

                                                                <span class="mission_error" style="color:red;"> </span>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.valeurs")}}</label>
                                                                <div class="col-sm-9">
                                                                    <textarea type="text" name="value"
                                                                        class="form-control" id="inputName"
                                                                        placeholder="Value">@if(isset($profile->value)) {{$profile->value}} @endif  </textarea>
                                                                </div>

                                                                <span class="value_error" style="color:red;"> </span>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-3 col-form-label">{{__("messages.vision")}}</label>
                                                                <div class="col-sm-9">
                                                                    <textarea type="text" name="vision"
                                                                        class="form-control" id="inputName"
                                                                        placeholder="Vision">@if(isset($profile->vision)) {{$profile->vision}} @endif  </textarea>
                                                                </div>

                                                                <span class="vision_error" style="color:red;"> </span>
                                                            </div>

                                                            </br>
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-md-offset-4">
                                                                    <x-button value="{{__('messages.modifier')}}"
                                                                        class="btn btn-danger"
                                                                        :type="Auth::user()->utype" />

                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">{{__("messages.btn_ferme")}}</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>












                            <div class="tab-pane <?php if (isset($reload_parametre)) {echo $reload_parametre;}?>"
                                id="parametre">

                                <span class="afficheparametre"
                                    style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;"></span>
                                @if(!isset($settings->id))
                                <form class="form-horizontal" method="POST" action="{{ route('save-parametre') }}"
                                    enctype="multipart/form-data" id="parametre_form">

                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label for="inputName"
                                            class="col-sm-2 col-form-label">{{__("messages.devise")}}</label>
                                        <div class="col-sm-10">
                                            <input required type="text" name="devise" class="form-control"
                                                id="inputName" placeholder="us, hero, gds , peso"
                                                value="@if(isset($settings->curency)){{ $settings->curency}} @endif">
                                        </div>
                                        <span class="devise_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName2"
                                            class="col-sm-2 col-form-label">{{__("messages.idreunion")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <select name="meetinginterval" class="form-control">
                                                <option value="">Selectionner réunion</option>
                                                <option value="Hebdomadaire">Hebdomadaire</option>
                                                <option value="Mensuelle">Mensuelle</option>
                                                <option value="Bimensuelle">Bimensuelle</option>
                                                <option value="Trimestriel">Trimestriel</option>
                                                <option value="Semestriel">Semestriel</option>
                                                <option value="Annuel">Annuel</option>
                                            </select>
                                        </div>
                                        <span class="meetinginterval_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.pcomite")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" required name="comitypresident" class="form-control"
                                                id="inputSkills" placeholder="président du comité"
                                                value="@if(isset($settings->comity_president)){{ $settings->comity_president}} @endif">
                                        </div>
                                        <span class="comitypresident_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.tcomite")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" required name="comitytreasurer" class="form-control"
                                                id="inputSkills" placeholder="trésorier du comité"
                                                value="@if(isset($settings->comity_treasurer)){{ $settings->comity_treasurer}} @endif">
                                        </div>
                                        <span class="comitytreasurer_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.mcotisationcv")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" required name="cvcotisationamount" class="form-control"
                                                id="inputSkills" placeholder="CV Montant"
                                                value="@if(isset($settings->cv_cotisation_amount)){{ $settings->cv_cotisation_amount}} @endif">
                                        </div>
                                        <span class="cvcotisationamount_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.mcotisationcr")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" required name="crcotisationamount" class="form-control"
                                                id="inputSkills" placeholder="CR Montant"
                                                value="@if(isset($settings->cr_cotisation_amount)){{ $settings->cr_cotisation_amount}} @endif">
                                        </div>
                                        <span class="crcotisationamount_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.langue")}}
                                        </label>
                                        <div class="col-sm-10">

                                            <select name="language" class="form-control" required>
                                                <option value="">Selectionner {{__("messages.langue")}}</option>
                                                <option value="fr">Français</option>
                                                <option value="en">Anglais</option>
                                                <option value="cr">Créole</option>
                                                <option value="es">Espagnol</option>
                                            </select>

                                        </div>
                                        <span class="language_error" style="color:red;"> </span>
                                    </div>
                                    <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <x-button value="Enregistre" class="btn btn-danger"
                                                :type="Auth::user()->utype" />

                                        </div>
                                    </div>
                                    <?php }?>
                                </form>
                                @else

                                <div class="col-md-12">
                                    <ul class="list-group list-group-unbordered mb-4">
                                        <li class="list-group-item">
                                            <b>{{__("messages.devise")}}</b> <a
                                                class="float-right">@if(isset($settings->curency))
                                                {{$settings->curency}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.idreunion")}}</b> <a
                                                class="float-right">@if(isset($settings->meeting_interval))
                                                {{$settings->meeting_interval}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.pcomite")}}</b> <a
                                                class="float-right">@if(isset($settings->comity_president))
                                                {{$settings->comity_president}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.tcomite")}}</b> <a
                                                class="float-right">@if(isset($settings->comity_treasurer))
                                                {{$settings->comity_treasurer}} @endif</a>
                                        </li>

                                        <li class="list-group-item">
                                            <b>{{__("messages.mcotisationcv")}}</b> <a
                                                class="float-right">@if(isset($settings->cv_cotisation_amount))
                                                {{$settings->cv_cotisation_amount}} {{$settings->curency}} @endif</a>
                                        </li>


                                        <li class="list-group-item">
                                            <b>{{__("messages.mcotisationcr")}}</b> <a
                                                class="float-right">@if(isset($settings->cr_cotisation_amount))
                                                {{$settings->cr_cotisation_amount}} {{$settings->curency}}@endif</a>
                                        </li>


                                        <li class="list-group-item">
                                            <b>{{__("messages.langue")}}</b> <a class="float-right">
                                                <?php if ($settings->language == "fr") {
    echo "Français";
} elseif ($settings->language == "en") {
    echo "Anglais";
} elseif ($settings->language == "es") {
    echo "Espagnol";
} elseif ($settings->language == "cr") {
    echo "Créole";
} else {
    echo $settings->language;
}?>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                @if(isset($settings->id))
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#myModalSet"> {{__("messages.modifier")}}</button>
                                @endif
                                <?php }?>
                                <!-- Modal -->
                                <div class="modal fade" id="myModalSet" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">

                                            <span class="affiche"
                                                style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;">

                                            </span>
                                            <div class="modal-body">
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('save-parametre') }}" enctype="multipart/form-data"
                                                    id="">


                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="id" value="<?php echo $id_muso; ?>">

                                                    <hr>
                                                    <div class=" form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.devise")}}
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="devise" class="form-control"
                                                                placeholder="us , gds, hero, peso" value=" <?php if (isset($settings->curency)) {
    echo $settings->curency;
}
?>">
                                                        </div>
                                                        <span class="devise_error" style="color:red;">
                                                        </span>

                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.idreunion")}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="meetinginterval"
                                                                class="form-control" id="inputName"
                                                                placeholder="Intervalle de reunion" value="<?php if (isset($settings->meeting_interval)) {
    echo $settings->meeting_interval;
}
?>">
                                                        </div>

                                                        <span class="meetinginterval_error" style="color:red;">
                                                        </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.pcomite")}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="comitypresident"
                                                                class="form-control" id="inputName"
                                                                placeholder="representing" value="<?php if (isset($settings->comity_president)) {
    echo $settings->comity_president;
}
?>">
                                                        </div>

                                                        <span class="comitypresident_error" style="color:red;">
                                                        </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.tcomite")}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="comitytreasurer"
                                                                class="form-control" id="inputName" placeholder="Vision"
                                                                value="<?php if (isset($settings->comity_treasurer)) {
    echo $settings->comity_treasurer;
}
?>">
                                                        </div>

                                                        <span class="comitytreasurer_error" style="color:red;">
                                                        </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.mcotisationcv")}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="cvcotisationamount"
                                                                class="form-control" id="inputName"
                                                                placeholder="network" value="<?php if (isset($settings->cv_cotisation_amount)) {
    echo $settings->cv_cotisation_amount;
}
?> ">
                                                        </div>

                                                        <span class="cvcotisationamount_error" style="color:red;">
                                                        </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.mcotisationcr")}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="crcotisationamount"
                                                                class="form-control" id="inputName"
                                                                placeholder="network" value="<?php if (isset($settings->cr_cotisation_amount)) {
    echo $settings->cr_cotisation_amount;
}
?> ">
                                                        </div>

                                                        <span class="crcotisationamount_error" style="color:red;">
                                                        </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-3 col-form-label">{{__("messages.langue")}}</label>
                                                        <div class="col-sm-9">

                                                            <select name="language" class="form-control" required>
                                                                <?php if (isset($settings->language)) {?>
                                                                <option value="<?php echo $settings->language; ?>">
                                                                    <?php if ($settings->language == "fr") {
    echo "Français";
} elseif ($settings->language == "en") {
    echo "Anglais";
} elseif ($settings->language == "es") {
    echo "Espagnol";
} elseif ($settings->language == "cr") {
    echo "Créole";
} else {
    echo $settings->language;
}?>

                                                                </option>
                                                                <?php }?>
                                                                <option value="">Selectionner {{__("messages.langue")}}
                                                                </option>
                                                                <option value="fr">Français</option>
                                                                <option value="en">Anglais</option>
                                                                <option value="cr">Créole</option>
                                                                <option value="es">Espagnol</option>
                                                            </select>

                                                        </div>

                                                        <span class="language_error" style="color:red;">
                                                        </span>
                                                    </div>

                                                    </br>
                                                    <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-4">
                                                            <x-button value="{{__('messages.btn_enregistrer')}}"
                                                                class="btn btn-primary" :type="Auth::user()->utype" />

                                                        </div>
                                                    </div>
                                                    <?php }?>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">{{__('messages.btn_ferme')}}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endif
                            </div>











                            <div class="tab-pane" id="password">

                                <span class="affichepass"
                                    style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;"></span>

                                <form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}"
                                    id="password_form">
                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label for="new-password"
                                            class="col-md-4 control-label">{{__("messages.mdepass")}}
                                        </label>

                                        <div class="col-md-6">
                                            <input id="current-password" type="password" class="form-control"
                                                name="current-password" placeholder="***********" <x-disabled
                                                :type="Auth::user()->utype" /> required>
                                            <span class="current-password_error" style="color:red;"> </span>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="new-password"
                                            class="col-md-4 control-label">{{__("messages.nouvopass")}}</label>

                                        <div class="col-md-6">
                                            <input id="new-password" type="password" placeholder="***********"
                                                class="form-control" name="new-password" required <x-disabled
                                                :type="Auth::user()->utype" />>

                                            <span class="new-password_error" style="color:red;"> </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="new-password-confirm"
                                            class="col-md-4 control-label">{{__("messages.confirmpass")}} </label>

                                        <div class="col-md-6">
                                            <input id="new-password-confirm" placeholder="***********" type="password"
                                                class="form-control" name="new-password_confirmation" <x-disabled
                                                :type="Auth::user()->utype" />>
                                        </div>

                                        <span class="new-password_confirmation_error" style="color:red;"> </span>
                                    </div>


                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                            <x-button value="{{__('messages.changepass')}}" class="btn btn-danger"
                                                :type="Auth::user()->utype" />
                                            <?php }?>

                                        </div>
                                    </div>
                                </form>
                            </div>







                            <div class="tab-pane <?php if (isset($reload_adresse)) {echo $reload_adresse;}?>"
                                id="adresse">
                                <span class="AffAdress"
                                    style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;"></span>
                                @if(!isset($address_musos->id))
                                <form class="form-horizontal" method="POST" action="{{ route('update-adresse') }}"
                                    id="address_form">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="inputName"
                                            class="col-sm-2 col-form-label">{{__("messages.adresse")}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="address" class="form-control" id="inputName"
                                                placeholder="Address" value="<?php if (isset($address_musos->address) and $address_musos->address != "Null") {
    echo $address_musos->address;
}
?>">
                                        </div>
                                        <span class="address_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName"
                                            class="col-sm-2 col-form-label">{{__("messages.ville")}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="city" class="form-control" id="inputName"
                                                placeholder="Villes" value="<?php if (isset($address_musos->city) and $address_musos->city != "Null") {
    echo $address_musos->city;
}
?>">
                                        </div>
                                        <span class="city_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName"
                                            class="col-sm-2 col-form-label">{{__("messages.pays")}}</label>
                                        <div class="col-sm-10">
                                            <select type="text" id="reg_pays" name="contry" placeholder="Pays"
                                                class="form-control" required>
                                                @if(isset($address_musos->pays))
                                                <option value="{{$address_musos->pays}}">{{$address_musos->pays}}
                                                </option>
                                                @endif
                                                <option value="">Pays</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Åland Islands">Åland Islands</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antarctica">Antarctica</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Bouvet Island">Bouvet Island</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Territory">British Indian</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Rep</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands">Cocos Islands</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo, The Democratic Republic of The">Congo, D.R
                                                </option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands (Malvinas)">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Territories">French Southern T.</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guernsey">Guernsey</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-bissau">Guinea-bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Heard Island and Mcdonald Islands">Heard Island</option>
                                                <option value="Holy See (Vatican City State)">Vatican</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran, Islamic Republic of">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jersey">Jersey</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea, Democratic People's Republic of">Korea, D.P.R.
                                                </option>
                                                <option value="Korea, Republic of">Korea, Republic of</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Lao People's Democratic Republic">Lao People's D.R
                                                </option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libyan Arab Jamahiriya">Libyan Arab J.</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macao">Macao</option>
                                                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia
                                                </option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia, Federated States of">Micronesia</option>
                                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Northern Mariana Islands">Northern Mariana</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Palestinian Territory, Occupied">Palestinian</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Pitcairn">Pitcairn</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Helena">Saint Helena</option>
                                                <option value="Saint Kitts and Nevis">St Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Pierre and Miquelon">Saint Pierre</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Georgia and The South Sandwich Islands">South
                                                    Georgia
                                                </option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Svalbard and Jan Mayen">Svalbard</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syrian Arab Republic">Syrian</option>
                                                <option value="Taiwan, Province of China">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania, United Republic of">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Timor-leste">Timor-leste</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks and Caicos Islands">Turks and Caicos</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="Virgin Islands, British">Virgin Islands, UK</option>
                                                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                <option value="Western Sahara">Western Sahara</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                        <span class="contry_error" style="color:red;"> </span>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2"
                                            class="col-sm-2 col-form-label">{{__("messages.arrondissement")}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="arondisment" class="form-control" id="inputName2"
                                                placeholder="Arondisment" value="<?php if (isset($address_musos->arondisment) and $address_musos->arondisment != "Null") {
    echo $address_musos->arondisment;
}
?>">
                                        </div>
                                        <span class="arondisment_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.departement")}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="departement" class="form-control" id="inputSkills"
                                                placeholder="Departement" value="<?php if (isset($address_musos->departement) and $address_musos->departement != "Null") {
    echo $address_musos->departement;
}
?>">
                                        </div>
                                        <span class="departement_error" style="color:red;"> </span>
                                    </div>

                                    <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <x-button value="Modifier" class="btn btn-danger"
                                                :type="Auth::user()->utype" />

                                        </div>
                                    </div>
                                    <?php }?>
                                </form>
                                @else
                                <div class="col-md-12">
                                    <ul class="list-group list-group-unbordered mb-4">
                                        <li class="list-group-item">
                                            <b>{{__("messages.adresse")}}</b> <a
                                                class="float-right">@if(isset($address_musos->address))
                                                {{$address_musos->address}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.ville")}}</b> <a
                                                class="float-right">@if(isset($address_musos->city))
                                                {{$address_musos->city}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.arrondissement")}}</b> <a
                                                class="float-right">@if(isset($address_musos->arondisment))
                                                {{$address_musos->arondisment}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.departement")}}</b> <a
                                                class="float-right">@if(isset($address_musos->departement))
                                                {{$address_musos->departement}} @endif</a>
                                        </li>

                                        <li class="list-group-item">
                                            <b>{{__("messages.pays")}}</b> <a
                                                class="float-right">@if(isset($address_musos->pays))
                                                {{$address_musos->pays}} @endif</a>
                                        </li>

                                    </ul>

                                </div>
                                @endif
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {
    ?>
                                @if(isset($address_musos->id))
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#myModalAdress"> {{__("messages.modifier")}}</button>
                                @endif
                                <?php }?>
                                <!-- Modal -->
                                <div class="modal fade" id="myModalAdress" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">

                                            <span class="AffAdress"
                                                style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center">
                                            </span>
                                            <div class="modal-body">
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('update-adresse') }}" enctype="multipart/form-data"
                                                    id="address_form">


                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="id" value="<?php echo $id_muso; ?>">

                                                    <hr>
                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-2 col-form-label">{{__("messages.adresse")}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="address" class="form-control"
                                                                id="inputName" placeholder="Address" value="<?php if (isset($address_musos->address) and $address_musos->address != "Null") {
    echo $address_musos->address;
}
?>">
                                                        </div>
                                                        <span class="address_error" style="color:red;"> </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-2 col-form-label">{{__("messages.ville")}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="city" class="form-control"
                                                                id="inputName" placeholder="Villes" value="<?php if (isset($address_musos->city) and $address_musos->city != "Null") {
    echo $address_musos->city;
}
?>">
                                                        </div>
                                                        <span class="city_error" style="color:red;"> </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-2 col-form-label">{{__("messages.pays")}}</label>
                                                        <div class="col-sm-10">
                                                            <select type="text" id="reg_pays" name="contry"
                                                                placeholder="Pays" class="form-control" required>
                                                                @if(isset($address_musos->pays))
                                                                <option value="{{$address_musos->pays}}">
                                                                    {{$address_musos->pays}}
                                                                </option>
                                                                @endif
                                                                <option value="">Pays</option>
                                                                <option value="Afghanistan">Afghanistan</option>
                                                                <option value="Åland Islands">Åland Islands</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa
                                                                </option>
                                                                <option value="Andorra">Andorra</option>
                                                                <option value="Angola">Angola</option>
                                                                <option value="Anguilla">Anguilla</option>
                                                                <option value="Antarctica">Antarctica</option>
                                                                <option value="Antigua and Barbuda">Antigua and
                                                                    Barbuda
                                                                </option>
                                                                <option value="Argentina">Argentina</option>
                                                                <option value="Armenia">Armenia</option>
                                                                <option value="Aruba">Aruba</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Austria">Austria</option>
                                                                <option value="Azerbaijan">Azerbaijan</option>
                                                                <option value="Bahamas">Bahamas</option>
                                                                <option value="Bahrain">Bahrain</option>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                                <option value="Barbados">Barbados</option>
                                                                <option value="Belarus">Belarus</option>
                                                                <option value="Belgium">Belgium</option>
                                                                <option value="Belize">Belize</option>
                                                                <option value="Benin">Benin</option>
                                                                <option value="Bermuda">Bermuda</option>
                                                                <option value="Bhutan">Bhutan</option>
                                                                <option value="Bolivia">Bolivia</option>
                                                                <option value="Bosnia and Herzegovina">Bosnia and
                                                                    Herzegovina</option>
                                                                <option value="Botswana">Botswana</option>
                                                                <option value="Bouvet Island">Bouvet Island</option>
                                                                <option value="Brazil">Brazil</option>
                                                                <option value="British Indian Ocean Territory">
                                                                    British
                                                                    Indian</option>
                                                                <option value="Brunei Darussalam">Brunei Darussalam
                                                                </option>
                                                                <option value="Bulgaria">Bulgaria</option>
                                                                <option value="Burkina Faso">Burkina Faso</option>
                                                                <option value="Burundi">Burundi</option>
                                                                <option value="Cambodia">Cambodia</option>
                                                                <option value="Cameroon">Cameroon</option>
                                                                <option value="Canada">Canada</option>
                                                                <option value="Cape Verde">Cape Verde</option>
                                                                <option value="Cayman Islands">Cayman Islands
                                                                </option>
                                                                <option value="Central African Republic">Central
                                                                    African
                                                                    Rep</option>
                                                                <option value="Chad">Chad</option>
                                                                <option value="Chile">Chile</option>
                                                                <option value="China">China</option>
                                                                <option value="Christmas Island">Christmas Island
                                                                </option>
                                                                <option value="Cocos (Keeling) Islands">Cocos
                                                                    Islands
                                                                </option>
                                                                <option value="Colombia">Colombia</option>
                                                                <option value="Comoros">Comoros</option>
                                                                <option value="Congo">Congo</option>
                                                                <option value="Congo, The Democratic Republic of The">
                                                                    Congo, D.R
                                                                </option>
                                                                <option value="Cook Islands">Cook Islands</option>
                                                                <option value="Costa Rica">Costa Rica</option>
                                                                <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                                <option value="Croatia">Croatia</option>
                                                                <option value="Cuba">Cuba</option>
                                                                <option value="Cyprus">Cyprus</option>
                                                                <option value="Czech Republic">Czech Republic
                                                                </option>
                                                                <option value="Denmark">Denmark</option>
                                                                <option value="Djibouti">Djibouti</option>
                                                                <option value="Dominica">Dominica</option>
                                                                <option value="Dominican Republic">Dominican
                                                                    Republic
                                                                </option>
                                                                <option value="Ecuador">Ecuador</option>
                                                                <option value="Egypt">Egypt</option>
                                                                <option value="El Salvador">El Salvador</option>
                                                                <option value="Equatorial Guinea">Equatorial Guinea
                                                                </option>
                                                                <option value="Eritrea">Eritrea</option>
                                                                <option value="Estonia">Estonia</option>
                                                                <option value="Ethiopia">Ethiopia</option>
                                                                <option value="Falkland Islands (Malvinas)">Falkland
                                                                    Islands</option>
                                                                <option value="Faroe Islands">Faroe Islands</option>
                                                                <option value="Fiji">Fiji</option>
                                                                <option value="Finland">Finland</option>
                                                                <option value="France">France</option>
                                                                <option value="French Guiana">French Guiana</option>
                                                                <option value="French Polynesia">French Polynesia
                                                                </option>
                                                                <option value="French Southern Territories">French
                                                                    Southern T.</option>
                                                                <option value="Gabon">Gabon</option>
                                                                <option value="Gambia">Gambia</option>
                                                                <option value="Georgia">Georgia</option>
                                                                <option value="Germany">Germany</option>
                                                                <option value="Ghana">Ghana</option>
                                                                <option value="Gibraltar">Gibraltar</option>
                                                                <option value="Greece">Greece</option>
                                                                <option value="Greenland">Greenland</option>
                                                                <option value="Grenada">Grenada</option>
                                                                <option value="Guadeloupe">Guadeloupe</option>
                                                                <option value="Guam">Guam</option>
                                                                <option value="Guatemala">Guatemala</option>
                                                                <option value="Guernsey">Guernsey</option>
                                                                <option value="Guinea">Guinea</option>
                                                                <option value="Guinea-bissau">Guinea-bissau</option>
                                                                <option value="Guyana">Guyana</option>
                                                                <option value="Haiti">Haiti</option>
                                                                <option value="Heard Island and Mcdonald Islands">
                                                                    Heard
                                                                    Island</option>
                                                                <option value="Holy See (Vatican City State)">
                                                                    Vatican
                                                                </option>
                                                                <option value="Honduras">Honduras</option>
                                                                <option value="Hong Kong">Hong Kong</option>
                                                                <option value="Hungary">Hungary</option>
                                                                <option value="Iceland">Iceland</option>
                                                                <option value="India">India</option>
                                                                <option value="Indonesia">Indonesia</option>
                                                                <option value="Iran, Islamic Republic of">Iran
                                                                </option>
                                                                <option value="Iraq">Iraq</option>
                                                                <option value="Ireland">Ireland</option>
                                                                <option value="Isle of Man">Isle of Man</option>
                                                                <option value="Israel">Israel</option>
                                                                <option value="Italy">Italy</option>
                                                                <option value="Jamaica">Jamaica</option>
                                                                <option value="Japan">Japan</option>
                                                                <option value="Jersey">Jersey</option>
                                                                <option value="Jordan">Jordan</option>
                                                                <option value="Kazakhstan">Kazakhstan</option>
                                                                <option value="Kenya">Kenya</option>
                                                                <option value="Kiribati">Kiribati</option>
                                                                <option value="Korea, Democratic People's Republic of">
                                                                    Korea, D.P.R.
                                                                </option>
                                                                <option value="Korea, Republic of">Korea, Republic
                                                                    of
                                                                </option>
                                                                <option value="Kuwait">Kuwait</option>
                                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                <option value="Lao People's Democratic Republic">Lao
                                                                    People's D.R
                                                                </option>
                                                                <option value="Latvia">Latvia</option>
                                                                <option value="Lebanon">Lebanon</option>
                                                                <option value="Lesotho">Lesotho</option>
                                                                <option value="Liberia">Liberia</option>
                                                                <option value="Libyan Arab Jamahiriya">Libyan Arab
                                                                    J.
                                                                </option>
                                                                <option value="Liechtenstein">Liechtenstein</option>
                                                                <option value="Lithuania">Lithuania</option>
                                                                <option value="Luxembourg">Luxembourg</option>
                                                                <option value="Macao">Macao</option>
                                                                <option
                                                                    value="Macedonia, The Former Yugoslav Republic of">
                                                                    Macedonia
                                                                </option>
                                                                <option value="Madagascar">Madagascar</option>
                                                                <option value="Malawi">Malawi</option>
                                                                <option value="Malaysia">Malaysia</option>
                                                                <option value="Maldives">Maldives</option>
                                                                <option value="Mali">Mali</option>
                                                                <option value="Malta">Malta</option>
                                                                <option value="Marshall Islands">Marshall Islands
                                                                </option>
                                                                <option value="Martinique">Martinique</option>
                                                                <option value="Mauritania">Mauritania</option>
                                                                <option value="Mauritius">Mauritius</option>
                                                                <option value="Mayotte">Mayotte</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Micronesia, Federated States of">
                                                                    Micronesia</option>
                                                                <option value="Moldova, Republic of">Moldova,
                                                                    Republic
                                                                    of</option>
                                                                <option value="Monaco">Monaco</option>
                                                                <option value="Mongolia">Mongolia</option>
                                                                <option value="Montenegro">Montenegro</option>
                                                                <option value="Montserrat">Montserrat</option>
                                                                <option value="Morocco">Morocco</option>
                                                                <option value="Mozambique">Mozambique</option>
                                                                <option value="Myanmar">Myanmar</option>
                                                                <option value="Namibia">Namibia</option>
                                                                <option value="Nauru">Nauru</option>
                                                                <option value="Nepal">Nepal</option>
                                                                <option value="Netherlands">Netherlands</option>
                                                                <option value="Netherlands Antilles">Netherlands
                                                                    Antilles</option>
                                                                <option value="New Caledonia">New Caledonia</option>
                                                                <option value="New Zealand">New Zealand</option>
                                                                <option value="Nicaragua">Nicaragua</option>
                                                                <option value="Niger">Niger</option>
                                                                <option value="Nigeria">Nigeria</option>
                                                                <option value="Niue">Niue</option>
                                                                <option value="Norfolk Island">Norfolk Island
                                                                </option>
                                                                <option value="Northern Mariana Islands">Northern
                                                                    Mariana</option>
                                                                <option value="Norway">Norway</option>
                                                                <option value="Oman">Oman</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="Palau">Palau</option>
                                                                <option value="Palestinian Territory, Occupied">
                                                                    Palestinian</option>
                                                                <option value="Panama">Panama</option>
                                                                <option value="Papua New Guinea">Papua New Guinea
                                                                </option>
                                                                <option value="Paraguay">Paraguay</option>
                                                                <option value="Peru">Peru</option>
                                                                <option value="Philippines">Philippines</option>
                                                                <option value="Pitcairn">Pitcairn</option>
                                                                <option value="Poland">Poland</option>
                                                                <option value="Portugal">Portugal</option>
                                                                <option value="Puerto Rico">Puerto Rico</option>
                                                                <option value="Qatar">Qatar</option>
                                                                <option value="Reunion">Reunion</option>
                                                                <option value="Romania">Romania</option>
                                                                <option value="Russian Federation">Russian
                                                                    Federation
                                                                </option>
                                                                <option value="Rwanda">Rwanda</option>
                                                                <option value="Saint Helena">Saint Helena</option>
                                                                <option value="Saint Kitts and Nevis">St Kitts and
                                                                    Nevis
                                                                </option>
                                                                <option value="Saint Lucia">Saint Lucia</option>
                                                                <option value="Saint Pierre and Miquelon">Saint
                                                                    Pierre
                                                                </option>
                                                                <option value="Samoa">Samoa</option>
                                                                <option value="San Marino">San Marino</option>
                                                                <option value="Sao Tome and Principe">Sao Tome
                                                                </option>
                                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                                <option value="Senegal">Senegal</option>
                                                                <option value="Serbia">Serbia</option>
                                                                <option value="Seychelles">Seychelles</option>
                                                                <option value="Sierra Leone">Sierra Leone</option>
                                                                <option value="Singapore">Singapore</option>
                                                                <option value="Slovakia">Slovakia</option>
                                                                <option value="Slovenia">Slovenia</option>
                                                                <option value="Solomon Islands">Solomon Islands
                                                                </option>
                                                                <option value="Somalia">Somalia</option>
                                                                <option value="South Africa">South Africa</option>
                                                                <option
                                                                    value="South Georgia and The South Sandwich Islands">
                                                                    South
                                                                    Georgia
                                                                </option>
                                                                <option value="Spain">Spain</option>
                                                                <option value="Sri Lanka">Sri Lanka</option>
                                                                <option value="Sudan">Sudan</option>
                                                                <option value="Suriname">Suriname</option>
                                                                <option value="Svalbard and Jan Mayen">Svalbard
                                                                </option>
                                                                <option value="Swaziland">Swaziland</option>
                                                                <option value="Sweden">Sweden</option>
                                                                <option value="Switzerland">Switzerland</option>
                                                                <option value="Syrian Arab Republic">Syrian</option>
                                                                <option value="Taiwan, Province of China">Taiwan
                                                                </option>
                                                                <option value="Tajikistan">Tajikistan</option>
                                                                <option value="Tanzania, United Republic of">
                                                                    Tanzania
                                                                </option>
                                                                <option value="Thailand">Thailand</option>
                                                                <option value="Timor-leste">Timor-leste</option>
                                                                <option value="Togo">Togo</option>
                                                                <option value="Tokelau">Tokelau</option>
                                                                <option value="Tonga">Tonga</option>
                                                                <option value="Trinidad and Tobago">Trinidad and
                                                                    Tobago
                                                                </option>
                                                                <option value="Tunisia">Tunisia</option>
                                                                <option value="Turkey">Turkey</option>
                                                                <option value="Turkmenistan">Turkmenistan</option>
                                                                <option value="Turks and Caicos Islands">Turks and
                                                                    Caicos</option>
                                                                <option value="Tuvalu">Tuvalu</option>
                                                                <option value="Uganda">Uganda</option>
                                                                <option value="Ukraine">Ukraine</option>
                                                                <option value="United Arab Emirates">United Arab
                                                                    Emirates</option>
                                                                <option value="United Kingdom">United Kingdom
                                                                </option>
                                                                <option value="United States">United States</option>
                                                                <option value="Uruguay">Uruguay</option>
                                                                <option value="Uzbekistan">Uzbekistan</option>
                                                                <option value="Vanuatu">Vanuatu</option>
                                                                <option value="Venezuela">Venezuela</option>
                                                                <option value="Viet Nam">Viet Nam</option>
                                                                <option value="Virgin Islands, British">Virgin
                                                                    Islands,
                                                                    UK</option>
                                                                <option value="Virgin Islands, U.S.">Virgin Islands,
                                                                    U.S.</option>
                                                                <option value="Wallis and Futuna">Wallis and Futuna
                                                                </option>
                                                                <option value="Western Sahara">Western Sahara
                                                                </option>
                                                                <option value="Yemen">Yemen</option>
                                                                <option value="Zambia">Zambia</option>
                                                                <option value="Zimbabwe">Zimbabwe</option>
                                                            </select>
                                                        </div>
                                                        <span class="contry_error" style="color:red;"> </span>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2"
                                                            class="col-sm-2 col-form-label">{{__("messages.arrondissement")}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="arondisment" class="form-control"
                                                                id="inputName2" placeholder="Arondisment" value="<?php if (isset($address_musos->arondisment) and $address_musos->arondisment != "Null") {
    echo $address_musos->arondisment;
}
?>">
                                                        </div>
                                                        <span class="arondisment_error" style="color:red;"> </span>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputSkills"
                                                            class="col-sm-2 col-form-label">{{__("messages.departement")}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="departement" class="form-control"
                                                                id="inputSkills" placeholder="Departement" value="<?php if (isset($address_musos->departement) and $address_musos->departement != "Null") {
    echo $address_musos->departement;
}
?>">
                                                        </div>
                                                        <span class="departement_error" style="color:red;"> </span>
                                                    </div>



                                                    </br>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-4">
                                                            <x-button value="{{__('messages.btn_enregistrer')}}"
                                                                class="btn btn-danger" :type="Auth::user()->utype" />


                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">{{__('messages.btn_ferme')}}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>



















                            <div class="tab-pane <?php if (isset($reload_autorisation)) {echo $reload_autorisation;}?>"
                                id="autorisation">

                                <span class="autAff"
                                    style="color:red; font-weight:600; font-size:22px; background-color:antiquewhite; text-align:center;"></span>
                                @if(!isset($autorisation->id))

                                <form class="form-horizontal" method="POST" action="{{ route('save-autorisation') }}"
                                    enctype="multipart/form-data" id="autorisationPw">

                                    {{ csrf_field() }}



                                    <div class="form-group row">
                                        <label for="inputName2"
                                            class="col-sm-2 col-form-label">{{__("messages.membres")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <select name="members_id" class="form-control" <x-disabled
                                                :type="Auth::user()->utype" />>
                                            <option value="">Selectionner membre</option>
                                            @if(!empty($members))
                                            @foreach($members as $k)
                                            <option value="{{ $k->id }}">
                                                {{ $k->last_name }} {{ $k->first_name }}</option>
                                            @endforeach
                                            @endif

                                            </select>
                                        </div>
                                        <span class="members_id_error" style="color:red;"> </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.password")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="password" required name="password" class="form-control"
                                                id="inputSkills" placeholder="*************" <x-disabled
                                                :type="Auth::user()->utype" />>
                                        </div>
                                        <span class="password_error" style="color:red;">
                                        </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputSkills"
                                            class="col-sm-2 col-form-label">{{__("messages.confirmpass")}}
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="password" required name="password_confirmation"
                                                class="form-control" id="inputSkills" placeholder="*************"
                                                <x-disabled :type="Auth::user()->utype" />>
                                        </div>
                                        <span class="password_confirmation_error" style="color:red;">
                                        </span>
                                    </div>



                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <x-button value="Enregistre" class="btn btn-danger"
                                                :type="Auth::user()->utype" />
                                        </div>
                                    </div>
                                </form>

                                @else
                                <div class="col-md-12">
                                    <ul class="list-group list-group-unbordered mb-4">
                                        <li class="list-group-item">
                                            <b>{{__("messages.membres")}}</b> <a
                                                class="float-right">@if(isset($autorisation->id))
                                                {{$autorisation->last_name}} {{$autorisation->first_name}} @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.password")}}</b> <a
                                                class="float-right">***************</a>
                                        </li>

                                    </ul>


                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#autoPassw"><i class="fas fa-inbox">
                                        </i> {{__("messages.modifier")}}</button>


                                    <!-- Modal -->
                                    <div class="modal fade" id="autoPassw" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">

                                                <span class="affiche"
                                                    style="color:red; font-size:16px; text-align:center">

                                                </span>
                                                <div class="modal-body">
                                                    <span class="autAff"
                                                        style="color:red; margin-left:50%; font-size:18px;"></span>
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('save-autorisation') }}"
                                                        enctype="multipart/form-data" id="autorisationPw">

                                                        {{ csrf_field() }}



                                                        <div class="form-group row">
                                                            <label for="inputName2"
                                                                class="col-sm-4 col-form-label">{{__("messages.membres")}}
                                                            </label>
                                                            <div class="col-sm-7">
                                                                <select name="members_id" class="form-control">
                                                                    <option value="">Selectionner membre</option>
                                                                    @if(!empty($members))
                                                                    @foreach($members as $k)
                                                                    <option value="{{ $k->id }}">
                                                                        {{ $k->last_name }} {{ $k->first_name }}
                                                                    </option>
                                                                    @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>
                                                            <span class="members_id_error" style="color:red;"> </span>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="inputSkills"
                                                                class="col-sm-4 col-form-label">{{__("messages.password")}}
                                                            </label>
                                                            <div class="col-sm-7">
                                                                <input type="password" required name="password"
                                                                    class="form-control" id="inputSkills"
                                                                    placeholder="*************">
                                                            </div>
                                                            <span class="password_error" style="color:red;">
                                                            </span>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="inputSkills"
                                                                class="col-sm-4 col-form-label">{{__("messages.confirmpass")}}
                                                            </label>
                                                            <div class="col-sm-7">
                                                                <input type="password" required
                                                                    name="password_confirmation" class="form-control"
                                                                    id="inputSkills" placeholder="*************">
                                                            </div>
                                                            <span class="password_confirmation_error"
                                                                style="color:red;">
                                                            </span>
                                                        </div>



                                                        <div class="form-group row">
                                                            <div class="offset-sm-2 col-sm-10">
                                                                <x-button value="Enregistre" class="btn btn-danger"
                                                                    :type="Auth::user()->utype" />
                                                            </div>
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    @endif

                                </div>
                                <!-- /.tab-pane -->
                            </div>









                        </div>
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



@endsection