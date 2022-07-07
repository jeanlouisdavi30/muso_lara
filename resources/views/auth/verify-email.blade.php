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
                <span style="color:white; padding-top:40%; text-align:center;">

                    Merci pour votre inscription! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en
                    cliquant sur le lien que nous venons de vous envoyer par e-mail ? Si vous n'avez pas reçu l'e-mail,
                    nous nous ferons un plaisir de vous en envoyer un autre.

                </span>


                @if (session('status') == 'verification-link-sent')
                <span style="color:red; padding-top:10%; text-align:center;">
                    {{ __("Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de l'inscription.") }}
                </span>
                @endif
                <div class="d-flex justify-content-center form_container_reset">


                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <button type="submit" class="btn-danger">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        <a href="{{ route('creation muso') }}" id="signin" class="signin">Enregistrer une nouvelle Muso

                        </a>
                    </div>

                </div>

            </div>
        </div>
        <div>
            <center><img src="{{ url('public/assets/images/logo-muso.gif') }}"></center>
        </div>
    </div>

</body>

</html>