@extends('tmp.muso')

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President") {?>
            <div class="col-md-4">
                <!-- general form elements -->
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

                <div class="card card-primary">


                    <!-- /.card-header -->
                    <!-- form start -->
                    @if (Request::route()->getName() === 'rencontre.index')
                    <form method="POST" action="{{ route('rencontre.store') }}" enctype="multipart/form-data">
                        @elseif (Request::route()->getName() === 'rencontre.edit')
                        <form method="POST" action="{{ route('rencontre.update',[$rencontre->id] ) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @endif
                            @csrf

                            <div class="card-body">

                                <div class="card-header">
                                    <h3 class="card-title">{{__("messages.ajt_rencontre")}}</h3>
                                </div>
                                </br>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <input class="form-check-input" type="checkbox" name="cv"
                                                value="caisse-vert">
                                            <label class="form-check-label">{{__("messages.cv")}}</label>
                                        </div>
                                        <div class="col-5">
                                            <input class="form-check-input" type="checkbox" name="cr"
                                                value="caisse-rouge">
                                            <label class="form-check-label">{{__("messages.cr")}}</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("messages.titre")}}</label>
                                    <input type="text" name="title_meetting" class="form-control"
                                        value="@if(isset($rencontre->title_meetting)){{ $rencontre->title_meetting}} @endif"
                                        id="exampleInputEmail1" placeholder="Titre" required>
                                    @error('title_meetting')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("messages.date_rencontre")}}</label>
                                    <input type="date" name="date_meetting"
                                        value="<?php if (isset($rencontre->date_meetting)) {echo $rencontre->date_meetting;}?>"
                                        class="form-control" id="exampleInputEmail1" required>
                                    @error('date_meetting')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>



                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                @if (Request::route()->getName() === 'rencontre.index')
                                <button type="submit"
                                    class="btn btn-primary">{{__("messages.btn_enregistrer")}}</button>
                                @else
                                <button type="submit" class="btn btn-primary">{{__("messages.btn_modifier")}}</button>
                                @endif
                        </form>
                        @if(isset($rencontre->id))




                        {!! Form::open(['method'=>'DELETE', 'url' =>route('rencontre.destroy',
                        $rencontre->id),'style' =>'display:inline']) !!}

                        {!! Form::button('delete', array('type' =>
                        'submit','class' =>
                        'btn btn-danger','title' => 'Supprimer Rencontre','onclick'=>'if (! confirm("Vous voulez
                        vraiment Supprimer cette rencontre ?"")) { return false; }')) !!}

                        {!! Form::close() !!}
                        @endif
                </div>

            </div>

            <?php }?>

        </div>


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__("messages.l_rencontre")}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{__("messages.titre")}}</th>
                                <th>{{__("messages.date_rencontre")}}</th>
                                <th>{{__("messages.text_poces")}}</th>
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                <th></th><?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_rencontre as $k)
                            <tr>
                                <td>{{$k->title_meetting}}</td>
                                <td>
                                    <?php $date = new DateTime($k->date_meetting);
echo $date->format('d-M-Y');?>

                                </td>
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                <td>
                                    @if(empty($k->proces))
                                    <a class="btn btn-danger btn-sm" href="{{ route('proces',[$k->id]) }}">
                                        <i class="fas fas fa-edit">
                                        </i>
                                        {{__("messages.ajouter")}}
                                    </a>
                                    @else


                                    <a class="btn btn-primary btn-sm" href="{{ route('voir-proces',[$k->id]) }}">
                                        <i class="fas fas fa-table">
                                        </i>
                                        {{__("messages.voir")}}
                                    </a>


                                    @endif

                                </td>

                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('rencontre.edit',[$k->id]) }}">
                                        <i class="fas fas fa-edit">
                                        </i>
                                        {{__("messages.btn_modifier")}}
                                    </a>

                                </td>
                                <?php }?>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>
<!-- /.card -->

@endsection