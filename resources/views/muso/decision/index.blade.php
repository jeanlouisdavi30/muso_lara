@extends('tmp.muso')

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

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

                <div class="card card-primary">

                    <!-- form start -->
                    @if (Request::route()->getName() === 'decision.index')
                    <form method="POST" action="{{ route('decision.store') }}" enctype="multipart/form-data">
                        @elseif (Request::route()->getName() === 'decision.edit')
                        <form method="POST" action="{{ route('decision.update',[$decision->id_decision] ) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @endif
                            @csrf

                            <div class="card-body">

                                <div class="card-header">
                                    <h3 class="card-title">{{__("messages.ajt_decision")}}</h3>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("messages.rencontres")}}</label>
                                    <select name="meettings_id" class="form-control">
                                        <?php if (!isset($decision->title_decision)) {?>
                                        <option value="">Selectionner une rencontre</option>
                                        <?php }?>

                                        @if(isset($decision->title_decision))
                                        <option value="<?php echo $decision->id_meetting; ?>">
                                            <?=$decision->title_meetting?></option>

                                        <option value="<?php echo $decision->id_decision; ?>">
                                            <?=$decision->title_meetting?></option>
                                        @endif


                                        @foreach($all_mettings as $k)
                                        <option value="<?php echo $k->id; ?>">
                                            <?=$k->title_meetting?></option>
                                        @endforeach
                                    </select>

                                    @error('meettings_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("messages.titre")}}</label>
                                    <input type="text" name="title_decision" class="form-control"
                                        value="@if(isset($decision->title_decision)){{ $decision->title_decision}} @endif"
                                        id="exampleInputEmail1" placeholder="Titre" required>
                                    @error('title_decision')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("messages.decision")}}</label>
                                    <input type="text" name="decision"
                                        value="@if(isset($decision->decision)){{ $decision->decision}} @endif"
                                        class="form-control" id="exampleInputEmail1" placeholder="Decision" required>
                                    @error('decision')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                @if (Request::route()->getName() === 'decision.index')
                                <button type="submit"
                                    class="btn btn-primary">{{__("messages.btn_enregistrer")}}</button>
                                @else
                                <button type="submit" class="btn btn-primary">{{__("messages.btn_modifier")}}</button>
                                @endif
                        </form>
                        @if(isset($decision->id_decision))




                        {!! Form::open(['method'=>'DELETE', 'url' =>route('decision.destroy',
                        $decision->id_decision),'style' =>'display:inline']) !!}

                        {!! Form::button('delete', array('type' =>
                        'submit','class' =>
                        'btn btn-danger','title' => 'Delete Post','onclick'=>'if (! confirm("Vous voulez
                        vraiment Supprimer cette decision ?"")) { return false; }')) !!}

                        {!! Form::close() !!}
                        @endif
                </div>

            </div>

            <?php }?>

        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__("messages.list_decision")}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{__("messages.rencontres")}}</th>
                                <th>{{__("messages.titre")}}</th>
                                <th>{{__("messages.decision")}}</th>
                                <th>{{__("messages.vote")}}</th>
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                <th></th><?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_decision as $k)
                            <tr>
                                <td>{{$k->title_meetting}}</td>
                                <td>{{$k->title_decision}}</td>
                                <td>{{$k->decision}}
                                </td>
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                <td>
                                    @if(empty($k->total_vote))
                                    <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal"
                                        data-target="#myModal{{$k->id_decision}}">
                                        vote</button>

                                    <div class="modal fade" id="myModal{{$k->id_decision}}" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">

                                                <div class="modal-body">

                                                    <span class="autAff"
                                                        style="color:red; margin-left:41%; font-size:18px;">
                                                    </span>

                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('save-vote') }}" enctype="multipart/form-data"
                                                        id="save_note">

                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="id_decision"
                                                            value="{{ $k->id_decision}}">



                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{__("messages.vote")}}</label></br>

                                                            <input type="number" name="vote" class="form-control">

                                                            <span class="vote_error" style="color:red;"> </span>
                                                        </div>



                                                        <div class="card-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">{{__("messages.btn_enregistrer")}}</button>

                                                        </div>

                                                    </form>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">{{__('messages.btn_ferme')}}</button>
                                                </div>

                                            </div>
                                        </div>
                                        @else

                                        {{$k->total_vote}}

                                        @endif
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm"
                                        href="{{ route('decision.edit',[$k->id_decision]) }}">
                                        <i class="fas fas fa-folder">
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