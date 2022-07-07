@extends('tmp.muso')

@section('content')

<div style="margin:20px; width:72%">

    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css')}} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote-bs4.min.css')}}">
    <h3>Règlements de la mutuelle</h3></br>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="{{ url('parametre-muso') }}">
                            {{__("messages.retour")}} </a></li>


                </ul>
            </div><!-- /.card-header -->
        </div>
        <div class="card card-primary card-outline">

            <!-- /.card-header -->
            <div class="card-body">


                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="form-group">
                    <form class="form-horizontal" method="POST" action="{{ route('save-reglement') }}">

                        {{ csrf_field() }}
                        <textarea id="compose-textarea" name="reglement" class="form-control" style="height: 300px"
                            required>

<?php if (isset($reglement->reglement)) {
    echo $reglement->reglement;
}
?></textarea>
                        </br>
                        <input type="hidden" name="id" value="<?php if (isset($reglement->reglement)) {
    echo $reglement->id;
}
?>">



                        <x-button value="Enregistre" class="btn btn-danger" :type="Auth::user()->utype" />

                        </br>
                        </br>

                    </form>
                </div>

            </div>

        </div>
        <!-- /.card -->
    </div>



</div>

<script src="{{ asset('public/plugins/jquery/jquery.min.js')}} ">
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/dist/js/adminlte.js')}} "></script>
<!-- Summernote -->
<script src="{{ asset('public/plugins/summernote/summernote-bs4.min.js')}} "></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/dist/js/demo.js')}}"></script>
<!-- Page specific script -->
<script>
$(function() {
    //Add text editor
    $('#compose-textarea').summernote()
})
</script>
@endsection