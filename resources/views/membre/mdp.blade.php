@extends('tmp.muso')


@section('content')


<section class="content">


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">

                <div class="alert  alert-dismissible col-md-7">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Finaliser votre inscription.
                        </br>
                        <span style="color:red; font-size:19px;">
                            Modifier Password </span>
                    </h3>
                </div>

                @if (session('success_password'))
                <div class="alert alert-success">
                    {{ session('success_password') }}
                </div>
                @endif

                <form method="POST" action="{{ route('modifier.pass.membre') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body" style="border:1px solid #343a40; background-color:white;">
                        <div class="row">

                            <div class="col-md-5">

                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" autocomplete="new-password"
                                        class="form-control input_pass" placeholder="Mot de passe" required>
                                </div>

                                @error('password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <input type="hidden" name="id" class="form-control" value="{{$membre->id}}">

                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password_confirmation" class="form-control input_pass"
                                        value="" placeholder="confirmer mot de passe" required>
                                    <br>

                                </div>
                                @error('password_confirmation')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer col-md-3">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


</section>

@endsection