<!DOCTYPE html>
<html>

<head>
    <title>Login Muso</title>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/images/favicon.ico')}} ">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
        integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public/css/style3.css')}}">
</head>
<!--Coded with love by Mutiullah Samim-->

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="{{ asset('public/assets/images/logo_muso.png')}}" class="brand_logo" alt="Logo">
                    </div>
                </div>
                @if(count($errors) > 0)
                <div class="p-1">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-warning alert-danger fade show" role="alert">{{$error}} <button
                            type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>
                    @endforeach
                </div>
                @endif
                <div class="d-flex justify-content-center form_container">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="email" name="email" :value="old('email')" autofocus required
                                class="form-control input_user" placeholder="email" placeholder="Email">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" required autocomplete="current-password"
                                class="form-control input_pass" placeholder="Password">

                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customControlInline">
                                <label class="custom-control-label signin" for="customControlInline"
                                    style="color:#1386b6;">Se rappeler de moi</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="log_button" value="Login" class="btn login_btn">Login</button>
                        </div>
                    </form>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        <a href="{{ route('creation muso') }}" id="signin" class="signin">Enregistrer une nouvelle Muso

                        </a>
                    </div>

                    <div class="d-flex justify-content-center links">
                        <a href="{{ route('password.request') }}">
                            <p>Mot de passe oublié?
                        </a>
                    </div>
                </div>
                <div class="musomobil">
                    <h5>
                        <center>MUSOMOBIL</center>
                    </h5>
                </div>
            </div>
        </div>
        <div>
            <center><img src="{{ url('public/assets/images/logo-muso.gif') }}"></center>
        </div>
    </div>

</body>

</html>