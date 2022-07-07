@extends('tmp.muso')

@section('content')


<link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css')}} ">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css')}}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote-bs4.min.css')}}">

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President") {?>
            <div class="col-md-6">

                <h2>{{__("messages.text_poces")}}</h2>
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="{{ url('rencontre') }}">
                                    {{__("messages.retour")}} </a></li>


                        </ul>
                    </div><!-- /.card-header -->
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i>
                        {{ session('success') }}
                        !</h5>
                </div>
                @endif

                @if (session('error'))

                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> {{ session('error') }} !</h5>
                </div>

                @endif
                <!-- general form elements -->
                <div class="card card-primary">


                    <!-- form start -->
                    @if (Request::route()->getName() === 'proces')
                    <form method="POST" action="{{ route('save-proces') }}" enctype="multipart/form-data">
                        @elseif (Request::route()->getName() === 'modifier-proces')
                        <form method="POST" action="{{ route('save-proces-update') }}" enctype="multipart/form-data">
                            @endif
                            @csrf

                            <div class="card-body">

                                <div class="active tab-pane" id="activity"
                                    style=" padding:15px; background-color:white;">
                                    <!-- Post -->
                                    <div class="post clearfix">
                                        <ul class="list-group list-group-unbordered mb-4">
                                            <li class="list-group-item">
                                                <b> {{__("messages.titre")}}</b> <a
                                                    class="float-right">{{$rencontre->title_meetting}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b> {{__("messages.date_rencontre")}}</b> <a
                                                    class="float-right">{{$rencontre->date_meetting}}</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('save-proces') }}" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $rencontre->id}}">
                                    <input type="hidden" name="fichier" value="{{ $rencontre->fichier}}">
                                    <div class="card-body">
                                        <div class="row">


                                            <div class="col-6">
                                                <label for="exampleInputEmail1">{{__("messages.ch_f")}}</label>


                                                <input type="file" name="file">


                                                @error('file')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div>
                                        </br>



                                    </div>



                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__("messages.text_poces")}}</label></br>
                                        <textarea id="compose-textarea" type="text" style="width:100%; height:500px;"
                                            name="proces"
                                            required> @if(!empty($rencontre->proces)) {{$rencontre->proces}} @endif</textarea>
                                        @error('proces')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                @if (Request::route()->getName() === 'proces')
                                <button type="submit"
                                    class="btn btn-primary">{{__("messages.btn_enregistrer")}}</button>
                                @else
                                <button type="submit" class="btn btn-primary">{{__("messages.btn_modifier")}}</button>
                                @endif
                        </form>

                </div>

            </div>

            <?php }?>

        </div>

    </div>
</section>
<!-- /.card -->
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