<!DOCTYPE html>
<html lang="en-US">
<!-- Mirrored from prium.github.io/elixir/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Dec 2021 11:41:54 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!--  -->
    <!--    Document Title-->
    <!-- =============================================-->
    <title>Musomobil</title><!--  -->
    <link rel="icon" type="image/png" href="{{ asset('public/assets/images/favicon.ico')}} ">

    <link rel="mask-icon" href="{{ asset('public/assets/images/favicons/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileImage" content="assets/images/favicons/mstile-150x150.png')}}">
    <meta name="theme-color" content="#ffffff"><!--  -->
    <!--    Stylesheets-->
    <!--    =============================================-->
    <!-- Default stylesheets-->
    <link href="{{ asset('public/assets/lib/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Template specific stylesheets-->
    <link href="{{ asset('public/assets/lib/loaders.css/loaders.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Open+Sans:300,400,600,700,800"
        rel="stylesheet">
    <link href="{{ asset('public/assets/lib/iconsmind/iconsmind.css')}}" rel="stylesheet">
    <link href="../../code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/hamburgers/dist/hamburgers.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/remodal/dist/remodal.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/remodal/dist/remodal-default-theme.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/flexslider/flexslider.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/lib/lightbox2/dist/css/lightbox.css')}}" rel="stylesheet">
    <!-- Main stylesheet and color file-->
    <link href="{{ asset('public/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/custom.css')}} " rel="stylesheet">
</head>

<body data-spy="scroll" data-target=".inner-link" data-offset="60">
    <main>

        <section class="background-primary py-3 d-none d-sm-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-auto d-none d-lg-block"><span
                            class="fa fa-map-marker color-warning fw-800 icon-position-fix"></span>
                        <p class="ml-2 mb-0 fs--1 d-inline color-white fw-700">10, Rue Audant, Impasse la paix / Route
                            de Frères, Pétion-Ville, Haiti. </p>
                    </div>
                    <div class="col-auto ml-md-auto order-md-2 d-none d-sm-block"><span
                            class="fa fa-envelope color-warning fw-800 icon-position-fix"></span>
                        <p class="ml-2 mb-0 fs--1 d-inline color-white fw-700">kofip98@yahoo.fr</p>
                    </div>
                    <div class="col-auto"><span class="fa fa-phone color-warning fw-800 icon-position-fix"></span><a
                            class="ml-2 mb-0 fs--1 d-inline color-white fw-700" href="tel:2123865575">(509)2817-0088,
                            212
                            386 5576</a></div>
                </div>
                <!--/.row-->
            </div>
            <!--/.container-->
        </section>
        <div class="znav-white znav-container sticky-top navbar-elixir" id="znav-container">
            <div class="container">
                <nav class="navbar navbar-expand-lg"><a class="navbar-brand overflow-hidden pr-3"
                        href="index-2.html"><img width="50%" src="{{ asset('public/assets/images/logo_muso.png')}} "
                            alt="" /></a><button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <div class="hamburger hamburger--emphatic">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav fs-0 fw-700">
                            <li><a href="JavaScript:void(0)">Accueil</a></li>
                            <li><a href="JavaScript:void(0)">A propos</a></li>
                            <li><a class="d-block mr-md-9" href="#">Contact</a></li>
                        </ul>
                        <ul class="navbar-nav ml-lg-auto">
                            <li><a class="btn btn-outline-primary btn-capsule btn-sm border-2x fw-700"
                                    href="{{ route('login') }}">Connexion</a></li>
                            <li><a class="btn btn-outline-primary btn-capsule btn-sm border-2x fw-700"
                                    href="{{ route('creation muso') }}">Enregistrer</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        @yield('content')

        <section class="background-primary text-center py-4">
            <div class="container">
                <div class="row align-items-center" style="opacity: 0.85">
                    <div class="col-sm-3 text-sm-left"><a href="index-2.html"><img src="assets/images/logo-light.png"
                                alt="" /></a></div>
                    <div class="col-sm-6 mt-3 mt-sm-0">
                        <p class="color-white lh-6 mb-0 fw-600">&copy; Copyright 2022 musomobil.</p>
                    </div>

                </div>
                <!--/.row-->
            </div>
            <!--/.container-->
        </section>
    </main><!--  -->
    <!--    JavaScripts-->
    <!--    =============================================-->
    <script src="../../cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="{{ asset('public/assets/lib/jquery/dist/jquery.min.js')}}"></script>
    <script src="../../cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="{{ asset('public/assets/lib/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('public/assets/lib/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('public/assets/lib/gsap/src/minified/TweenMax.min.js')}}"></script>
    <script src="{{ asset('public/assets/lib/gsap/src/minified/plugins/ScrollToPlugin.min.js')}}"></script>
    <script src="{{ asset('public/assets/lib/CustomEase.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/config.js')}}"></script>
    <script src="{{ asset('public/assets/js/zanimation.js')}}"></script>
    <script src="{{ asset('public/assets/js/inertia.js')}}"></script>
    <!-- Hotjar Tracking Code for http://markup.themewagon.com/tryelixir-->
    <script>
    (function(h, o, t, j, a, r) {
        h.hj = h.hj || function() {
            (h.hj.q = h.hj.q || []).push(arguments)
        };
        h._hjSettings = {
            hjid: 710415,
            hjsv: 6
        };
        a = o.getElementsByTagName('head')[0];
        r = o.createElement('script');
        r.async = 1;
        r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
        a.appendChild(r);
    })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script><!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-76729372-5"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-76729372-5');
    </script>
    <script src="{{ asset('public/assets/lib/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('public/assets/lib/remodal/dist/remodal.js')}}"></script>
    <script src="{{ asset('public/assets/lib/lightbox2/dist/js/lightbox.js')}}"></script>
    <script src="{{ asset('public/assets/lib/flexslider/jquery.flexslider-min.js')}}"></script>
    <script src="{{ asset('public/assets/js/core.js')}}"></script>
    <script src="{{ asset('public/assets/js/main.js')}} "></script>
</body>
<!-- Mirrored from prium.github.io/elixir/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Dec 2021 11:42:22 GMT -->

</html>