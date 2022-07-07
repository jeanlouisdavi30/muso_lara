@extends('tmp.site')

@section('content')

<div class="flexslider flexslider-simple h-full loading">
    <ul class="slides">
        <li data-zanim-timeline="{}">
            <section class="py-0">
                <div>
                    <div class="background-holder elixir-zanimm-scale"
                        style="background-image:url(./././public/assets/images/slide.png);"
                        data-zanimm='{"from":{"opacity":0.1,"filter":"blur(10px)","scale":1.05},"to":{"opacity":1,"filter":"blur(0px)","scale":1}}'>
                    </div>
                    <!--/.background-holder-->
                    <div class="container">
                        <div class="row h-full py-8 align-items-center" data-inertia='{"weight":1.5}'>
                            <div class="col-sm-8 col-lg-7 px-5 px-sm-3">
                                <div class="overflow-hidden">
                                    <h1 class="fs-4 fs-md-5 zopacity" data-zanim='{"delay":0}'>MUSOMOBIL
                                    </h1>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="color-primary mt-4 mb-5 lh-2 fs-1 fs-md-2 zopacity"
                                        data-zanim='{"delay":0.1}'>Musomobil est une plateforme de gestion des mutuelles
                                        de solidarité (MUSO).</p>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="zopacity" data-zanim='{"delay":0.2}'><a
                                            class="btn btn-primary mr-3 mt-3" href="#">Lire plus<span
                                                class="fa fa-chevron-right ml-2"></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->
                </div>
                <!--/.container-->
            </section>
        </li>
        <li data-zanim-timeline="{}">
            <section class="py-0">
                <div>
                    <div class="background-holder elixir-zanimm-scale"
                        style="background-image:url(./././public/assets/images/slide1.png);"
                        data-zanimm='{"from":{"opacity":0.1,"filter":"blur(10px)","scale":1.05},"to":{"opacity":1,"filter":"blur(0px)","scale":1}}'>
                    </div>
                    <!--/.background-holder-->
                    <div class="container">
                        <div class="row h-full py-8 align-items-center" data-inertia='{"weight":1.5}'>
                            <div class="col-sm-8 col-lg-7 px-5 px-sm-3">
                                <div class="overflow-hidden">
                                    <h1 class="fs-4 fs-md-5 zopacity" data-zanim='{"delay":0}'>Une MUSO</h1>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="color-primary mt-4 mb-5 lh-2 fs-1 fs-md-2 zopacity"
                                        data-zanim='{"delay":0.1}'>Une Mutuelle de Solidarité (MUSO) est un groupe
                                        d’épargne et de crédit autogéré par les membres qui bénéficient de services
                                        financiers répondant à leurs besoins et adaptés à leur capacité .</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/.row-->
                </div>
                <!--/.container-->
            </section>
        </li>

    </ul>
</div>

<section class="background-white  text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md-6">
                <iframe width="660" height="315" src="https://www.youtube.com/embed/WAYfUrqCd3Y"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>

        <!--/.row-->
    </div>
    <!--/.container-->
</section>


@endsection