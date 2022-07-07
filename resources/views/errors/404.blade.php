@extends('tmp.ereur')

@section('content')

<section class="content" style="padding:10%;">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page non trouvée.</h3>

            <p>
                Nous n'avons pas trouvé la page que vous cherchiez.
                En attendant, vous pouvez <a href="{{ url('dashboard') }}">
                    retour au tableau de bord</a>
            </p>

        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>

@endsection