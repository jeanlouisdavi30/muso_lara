@extends('tmp.muso')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->



            <div class="col-md-6">

                @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i>
                        {{ session('success') }}
                        !</h5>
                </div>
                @endif


                <div class="alert  alert-dismissible col-md-12">
                    <h2>
                        {{__("messages.ajt_m")}} </h2>
                </div>

                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('save.membre') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.nom")}}</label>
                                <input type="text" name="nom" class="form-control" id="exampleInputEmail1"
                                    placeholder="Nom">
                                @error('nom')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.prenom")}}</label>
                                <input type="text" name="prenom" class="form-control" id="exampleInputEmail1"
                                    placeholder="Prenom">
                                @error('prenom')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="sexe">
                                    <option value="">{{__("messages.sexe")}}</option>
                                    <option value="F">F</option>
                                    <option value="M">M</option>
                                </select>
                            </div>
                            @error('sexe')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.d_naissance")}}</label>
                                <input type="date" name="date_naissance" class="form-control" id="exampleInputEmail1"
                                    placeholder="age">
                                @error('age')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.adresse")}}</label>
                                <input type="text" name="adresse" class="form-control" id="exampleInputEmail1"
                                    placeholder="Adresse">
                                @error('adresse')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.telephone")}}</label>
                                <input type="text" name="phone" class="form-control" id="exampleInputEmail1"
                                    placeholder="phone">
                                @error('phone')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="form-group">
                                <select class="form-control" name="type_of_id">
                                    <option value="">{{__("messages.identite")}}</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Carte identite">Carte identite</option>
                                    <option value="License">License</option>
                                </select>
                            </div>

                            @error('type_of_id')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label for="exampleInputEmail1">Numero identite</label>
                                <input type="text" name="id_number" class="form-control" id="exampleInputEmail1"
                                    placeholder="#">
                                @error('id_number')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.mantrimonial")}}
                                </label>
                                <select class="form-control" name="matrimonial_state">
                                    <option value=""> {{__("messages.mantrimonial")}}</option>
                                    <option value="Celibataire">Celibataire</option>
                                    <option value="Marier">Marier</option>
                                </select>

                                @error('matrimonial_state')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__("messages.fonction")}}
                                </label>
                                <select class="form-control" name="function">
                                    <option value="">Selectionner fonction</option>
                                    <option value="Membre">Membre</option>
                                    <option value="President">President</option>
                                    <option value="Secretaire">Secretaire</option>
                                    <option value="Tresorier">Tresorier</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                    placeholder="Enter email">
                                @error('email')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">{{__("messages.password")}}</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="Password">
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{__("messages.btn_enregistrer")}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
</section>
<!-- /.card -->

@endsection