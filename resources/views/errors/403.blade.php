@extends('tmp.muso')


@section('content')


<!-- Main content -->
<section class="content" style="padding-top:10%;">
    <div class="error-page">
        <h2 class="headline text-warning"> 403</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Finaliser votre inscription.</h3>

            <h5> Bienvenue dans le system de Muso mobile </h5>
            Pour terminez l'inscription cliquez sur <a style="color:red;" href="{{ route('parametre-muso')}}">
                Paramétrer </a>


        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
@endsection