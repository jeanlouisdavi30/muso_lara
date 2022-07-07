@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'modifier-info') {
    $timeline = "active";
} elseif (Request::route()->getName() === 'member.info') {
    $activity = "active";
} elseif (Request::route()->getName() === 'modifier-password') {
    $password = "active";
} elseif (Request::route()->getName() === 'voir-emprunt') {
    $voiremprunt = "active";
} elseif (Request::route()->getName() === 'nouveau-pret') {
    $nouveaupret = "active";
} elseif (Request::route()->getName() === 'nouveau-pret') {
    $list_emprunts = "active";
} elseif (Request::route()->getName() === 'voir-paiement-emprunt') {
    $mpaiement = "active";
}

?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">
                                    {{__("messages.pmembre")}} </a></li>
                            <li class="nav-item">
                                <a class="nav-link" <?php if (isset($timeline)) {echo $timeline;}?>
                                    href="{{ url('modifier-info' ) }}/{{ $membre->id }}">
                                    {{__("messages.minfo")}}
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ url('modifier-password' ) }}/{{ $membre->id }}">
                                    {{__("messages.m_pass")}}</a>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="#photo" data-toggle="tab">
                                    {{__("messages.photo")}}</a>
                            </li>

                            <li class="nav-item"><a class="nav-link"
                                    href="{{ url('transaction-membre')}}/{{$membre->id}}">
                                    {{__("messages.transaction")}}</a>
                            </li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="<?php if (isset($activity)) {echo $activity;}?> tab-pane" id="activity">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__("messages.info_p")}} </h3>
                                </div>
                                <!-- Post -->
                                <div class="post clearfix">

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>{{__("messages.nom")}}</b> <a
                                                class="float-right">{{$membre->last_name}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.prenom")}}</b> <a
                                                class="float-right">{{$membre->first_name}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.sexe")}}</b> <a class="float-right">{{$membre->sexe}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.d_naissance")}}</b> <a
                                                class="float-right">{{$membre->date_birth}}</a>
                                        </li>

                                        <li class="list-group-item">
                                            <b>{{__("messages.telephone")}}</b> <a
                                                class="float-right">{{$membre->phone}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.identite")}}</b> <a
                                                class="float-right">{{$membre->type_of_id}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>#</b> <a class="float-right">{{$membre->id_number}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{__("messages.mantrimonial")}}</b> <a
                                                class="float-right">{{$membre->matrimonial_state}}</a>
                                        </li>

                                        <li class="list-group-item">
                                            <b>{{__("messages.fonction")}}</b> <a
                                                class="float-right">{{$membre->function}}</a>
                                        </li>
                                    </ul>
                                    <a class="btn btn-danger btn-sm "
                                        onclick="if (! confirm('Vous voulez vraiment Supprimer ce membre ?')) { return false; }"
                                        href="{{ url('delete-member')}}/{{ $membre->id}}">
                                        <i class="fas fa-trash">
                                        </i>
                                        {{__("messages.btn_supprimer")}}
                                    </a>
                                </div>
                                <!-- /.post -->

                            </div>
                            <!-- /.tab-pane -->
                            <div class="<?php if (isset($timeline)) {echo $timeline;}?> tab-pane" id="timeline">
                                <!-- The timeline -->
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i>
                                        {{ session('success') }}
                                        !</h5>
                                </div>
                                @endif

                                <div class="card-header">
                                    <h3 class="card-title"> {{__("messages.modifier")}}</h3>
                                </div>

                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" action="{{ route('update-membre') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="exampleInputEmail1">{{__("messages.nom")}}</label>
                                                <input type="text" value="{{$membre->last_name}}" name="nom"
                                                    class="form-control" placeholder=".col-3">
                                                @error('nom')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-3">
                                                <label for="exampleInputEmail1">{{__("messages.prenom")}}</label>
                                                <input type="text" name="prenom" class="form-control"
                                                    value="{{$membre->first_name}}" id="
                                    exampleInputEmail1" placeholder="Prenom">
                                                @error('prenom')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div>
                                        </br>
                                        <input type="hidden" name="id" class="form-control" value="{{$membre->id}}"
                                            id="exampleInputEmail1" placeholder="Nom">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="exampleInputEmail1">{{__("messages.sexe")}}</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="sexe">
                                                        <option value="{{$membre->sexe}}">{{$membre->sexe}}</option>
                                                        <option value="">Choix sexe</option>
                                                        <option value="F">F</option>
                                                        <option value="M">M</option>
                                                    </select>
                                                </div>
                                                @error('sexe')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-3">
                                                <label for="exampleInputEmail1">Date de naissance</label>
                                                <input type="text" name="date_birth" class="form-control"
                                                    value="{{$membre->date_birth}}" id="
                                    exampleInputEmail1" placeholder="Prenom">
                                                @error('date_birth')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{__("messages.telephone")}}</label>
                                                    <input type="text" name="phone" class="form-control"
                                                        value="{{$membre->phone}}" id="exampleInputEmail1"
                                                        placeholder="phone">
                                                    @error('phone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{__("messages.identite")}}</label>
                                                    <input type="text" name="type_of_id" class="form-control"
                                                        value="{{$membre->type_of_id}}" id="exampleInputEmail1"
                                                        placeholder="#">
                                                    @error('type_of_id')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">#</label>
                                                    <input type="text" name="id_number" class="form-control"
                                                        value="{{$membre->id_number}}" id="exampleInputEmail1"
                                                        placeholder="#">
                                                    @error('id_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail1">{{__("messages.mantrimonial")}}</label>
                                                    <input type="text" name="matrimonial_state" class="form-control"
                                                        value="{{$membre->matrimonial_state}}" id="exampleInputEmail1"
                                                        placeholder="#">
                                                    @error('matrimonial_state')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">{{__("messages.fonction")}}</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="function">
                                                        <option value="{{$membre->function}}">{{$membre->function}}
                                                        </option>
                                                        <option value="">Choisir Fonction</option>

                                                        <option value="President">President</option>
                                                        <option value="Secretaire">Secretaire</option>
                                                        <option value="Tresorier">Tresorier</option>
                                                        <option value="Membre">Membre</option>
                                                    </select>
                                                </div>
                                                @error('sexe')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{$membre->email}}" id="exampleInputEmail1"
                                                        placeholder="Enter email">
                                                    @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary">{{__("messages.btn_modifier")}}</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="<?php if (isset($password)) {echo $password;}?> tab-pane" id="password">



                                @if (session('success_password'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i>
                                        {{ session('success_password') }}
                                        !</h5>
                                </div>
                                @endif
                                <!-- The timeline -->
                                <div class="card-header">
                                    <h3 class="card-title">{{__("messages.modifier")}} {{__("messages.password")}}</h3>
                                </div>

                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" action="{{ route('modifier.pass.membre') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="exampleInputEmail1">{{__("messages.password")}}</label>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="">
                                                @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                        </div>
                                        </br>
                                        <input type="hidden" name="id" class="form-control" value="{{$membre->id}}"
                                            id="exampleInputEmail1" placeholder="Nom">



                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary">{{__("messages.btn_modifier")}}</button>
                                    </div>

                                </form>

                            </div>

                            <div class="tab-pane" id="photo">

                                @if (session('success_password'))
                                <div class="alert alert-success">
                                    {{ session('success_password') }}
                                </div>
                                @endif


                                <!-- The timeline -->
                                <div class="card-header">
                                    <h3 class="card-title"> {{__("messages.photo")}} </h3>
                                </div>

                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" action="{{ route('ulpoad.photo.membre') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4" style="width:200px; height:200px;">
                                                @if($membre->picture != "picture.png")
                                                <img style="max-width:100%"
                                                    src="{{ url('public/images_all/'.$membre->picture) }}">
                                                @endif
                                            </div>

                                            <div class="col-3">
                                                <label for="exampleInputEmail1">{{__("messages.ch_photo")}}</label>
                                                <input type="file" name="file" class="form-control"
                                                    onchange="form.submit()">
                                                @error('file')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div>
                                        </br>
                                        <input type="hidden" name="id" class="form-control" value="{{$membre->id}}"
                                            id="exampleInputEmail1" placeholder="Nom">


                                    </div>


                                </form>
                            </div>

                            <!-- /.tab-pane -->
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


@endsection