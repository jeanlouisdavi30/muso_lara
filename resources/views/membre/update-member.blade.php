@extends('tmp.muso')

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Modifer membre</h3>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('update-membre') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            <input type="hidden" name="id" class="form-control" value="{{$membre->id}}"
                                id="exampleInputEmail1" placeholder="Nom">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{$membre->first_name}}"
                                    id="exampleInputEmail1" placeholder="Nom">
                                @error('nom')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Prenom</label>
                                <input type="text" name="prenom" class="form-control" value="{{$membre->last_name}}" id="
                                    exampleInputEmail1" placeholder="Prenom">
                                @error('prenom')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

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

                            <div class="form-group">
                                <label for="exampleInputEmail1">age</label>
                                <input type="text" name="age" class="form-control" value="{{$membre->age}}"
                                    id="exampleInputEmail1" placeholder="age">
                                @error('age')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Adresse</label>
                                <input type="text" name="adresse" class="form-control" value="{{$membre->adress}}"
                                    id="exampleInputEmail1" placeholder="Adresse">
                                @error('adresse')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" value="{{$membre->email}}"
                                    id="exampleInputEmail1" placeholder="Enter email">
                                @error('email')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" value="12345678" class="form-control"
                                    id="exampleInputPassword1" placeholder="Password">
                                @error('password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
</section>
<!-- /.card -->

@endsection