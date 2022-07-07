@extends('tmp.muso')

@section('content')

<?php

if (Request::route()->getName() === 'partenaires') {
    $list_partenaire = "active";
} elseif (Request::route()->getName() === 'nouveau-partenaires') {
    $partenaires = "active";
} elseif (Request::route()->getName() === 'voir-partenaire') {
    $voirPartenaire = "active";
} elseif (Request::route()->getName() === 'rapport-depensecv' or Request::route()->getName() === 'rapport-depense-cv') {
    $rapportDepense = "active";
}

?>
<?php
if (Auth::user()->utype == "admin") {
    $info_muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->id;
} else {
    $info_muso = DB::table('members')->select('members.last_name', 'members.first_name', 'musos.name_muso',
        'musos.representing', 'musos.phone', 'musos.registered_date', 'musos.contry', 'musos.network', 'members.musos_id')
        ->join('musos', 'musos.id', '=', 'members.musos_id')
        ->where('members.users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->musos_id;
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">

                <div class="alert  alert-dismissible col-md-7">
                    <h2>
                        {{__("messages.partenaires")}} </h2>
                </div>
                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($list_partenaire)) {echo $list_partenaire;}?>"
                                    href="#list_retrair" data-toggle="tab">{{__("messages.nos_p")}}
                                </a>
                            </li>
                            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                            <li class="nav-item"><a
                                    class="nav-link <?php if (isset($partenaires)) {echo $partenaires;}?>"
                                    href="{{ route('nouveau-partenaires')}}">{{__("messages.nouv_p")}}
                                </a></li>
                            <?php }?>

                            <?php if (isset($voirPartenaire)) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($voirPartenaire)) {echo $voirPartenaire;}?>"
                                    href="#autrePaiement" data-toggle="tab"> {{__("messages.voir")}}
                                </a>
                            </li>
                            <?php }?>
                        </ul>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="tab-content">

                            <div class="<?php if (isset($partenaires)) {echo $partenaires;}?> tab-pane"
                                id="cotisationCV">

                                <div class="row">
                                    <div class="col-md-6">



                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif


                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        <!-- /.card-header -->
                                        <form method="post" action="{{ route('save-partenaire') }}"
                                            enctype="multipart/form-data" accept-charset="utf-8" id="save-partenaire">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.nom")}}</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                    placeholder="">

                                                @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.adresse")}}</label>
                                                <input type="text" name="adresse" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('adresse')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.telephone")}}</label>
                                                <input type="number" name="telf" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('telf')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__("messages.representant")}}</label>
                                                <input type="text" name="representant" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('representant')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>




                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> Site Web</label>
                                                <input type="text" name="site_web" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('site_web')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Presentation du partenaire</label>
                                                <textarea type="text" name="text_representant"
                                                    class="form-control"></textarea>

                                                @error('text_representant')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div style="margin-left:25%; width:300px; padding:15px; float:left;">
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <button type="submit" class="btn btn-danger">{{__("messages.btn_enregistrer")}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>

                            </div>
                            <div class="<?php if (isset($list_partenaire)) {echo $list_partenaire;}?> tab-pane"
                                id="list_retrair">
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>{{__("messages.nom")}}</th>
                                                <th>{{__("messages.adresse")}}</th>
                                                <th>{{__("messages.telephone")}}</th>
                                                <th>{{__("messages.representant")}}</th>
                                                <th>Email</th>
                                                <th>site web</th>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>
                                                <th></th><?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(isset($all_partenaires))
                                            @foreach($all_partenaires as $k)

                                            <tr>

                                                <td>{{$k->name}}</td>
                                                <td>{{$k->adresse}}</td>
                                                <td>{{$k->telf}}</td>
                                                <td>{{$k->representant}} </td>
                                                <td>{{$k->email}} </td>
                                                <td>{{$k->site_web}} </td>
                                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ url('voir-partenaire')}}/{{ $k->id}}"> <i
                                                            class="fas fas fa-folder"></i> {{__("messages.voir")}}</a>

                                                </td>
                                                <?php }?>

                                            </tr>


                                            @endforeach
                                            @endif
                                            </br>


                                        </tbody>

                                    </table>

                                </div>
                            </div>
                            <div class="<?php if (isset($voirPartenaire)) {echo $voirPartenaire;}?> tab-pane"
                                id="list_retrair">

                                <div class="card-body">
                                    <div class="post clearfix">

                                        <div class="row">
                                            <?php if (!empty($data_partenaire)) {?>
                                            <div class="col-md-8">
                                                <ul class="list-group list-group-unbordered mb-4 ">

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.nom")}}</b> <a class="float-right">{{$data_partenaire->name}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.adresse")}}</b> <a
                                                            class="float-right">{{$data_partenaire->adresse}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>{{__("messages.telephone")}}</b> <a
                                                            class="float-right">{{$data_partenaire->telf}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>Email</b> <a
                                                            class="float-right">{{$data_partenaire->email}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>site web</b> <a
                                                            class="float-right">{{$data_partenaire->site_web}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>{{__("messages.representant")}}</b> <a
                                                            class="float-right">{{$data_partenaire->representant}}</a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>Text</b> <a
                                                            class="float-right">{{$data_partenaire->text_representant}}</a>
                                                    </li>




                                                </ul>
                                            </div>
                                            <div class="col-md-4" style="">
                                                @if ($data_partenaire->logo == 'mologo.png')
                                                <img style="margin-left:10%; width:170px; height:150px; border:2px solid #f0f0f0;"
                                                    src="{{ url('public/assets/images/mologo.png') }}">
                                                @else
                                                <img style="margin-left:10%; width:170px; height:150px; border:2px solid #f0f0f0;"
                                                    src="{{ url('public/images_all/'.$data_partenaire->logo) }}">
                                                @endif
                                                <form method="post" action="{{ route('modifier-logo-partenaire') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{$data_partenaire->id}}" />
                                                    <div style="margin-left:10%; width:250px;">
                                                        <div class="form-group">
                                                            <p> Change logo </p>
                                                            <input type="file" name="file" onchange="form.submit()">
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                            <?php }?>
                                        </div>
                                        </br>

                                        <div class="row">


                                            <?php if (isset($data_partenaire)) {?>

                                            <div class="col-md-6">

                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#myModal"><i class="fas fas fa-folder">
                                                    </i> {{__("messages.btn_modifier")}}</button>






                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                      

                                                            <span class="autAff"
                                                                style="color:red; margin-left:20%; font-size:18px;"></span>

                                                            <div class="modal-body">
                                                                <form class="form-horizontal" method="POST"
                                                                    action="{{ route('modifier-partenaire') }}"
                                                                    id="modifierPartenaire">


                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="id" value="<?php if (isset($data_partenaire->id)) {
    echo $data_partenaire->id;
}
    ?>">

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.nom")}}</label>
                                                                        <input type="text" name="name" value="<?php if (isset($data_partenaire->name)) {
        echo $data_partenaire->name;
    }
    ?>" class="form-control" id="name" placeholder="">

                                                                        @error('name')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror


                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.adresse")}}</label>
                                                                        <input type="text" name="adresse" value="<?php if (isset($data_partenaire->adresse)) {
        echo $data_partenaire->adresse;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('adresse')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleInputEmail1">{{__("messages.telephone")}}</label>
                                                                        <input type="number" name="telf" value="<?php if (isset($data_partenaire->telf)) {
        echo $data_partenaire->telf;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('telf')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleInputEmail1">{{__("messages.representant")}}</label>
                                                                        <input type="text" name="representant" value="<?php if (isset($data_partenaire->representant)) {
        echo $data_partenaire->representant;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('representant')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>




                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Email</label>
                                                                        <input type="email" name="email" value="<?php if (isset($data_partenaire->email)) {
        echo $data_partenaire->email;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('email')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1"> Site
                                                                            Web</label>
                                                                        <input type="text" name="site_web" value="<?php if (isset($data_partenaire->site_web)) {
        echo $data_partenaire->site_web;
    }
    ?>" class="form-control" id="exampleInputEmail1" placeholder="">
                                                                        @error('site_web')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">{{__("messages.representant")}}</label>
                                                                        <textarea type="text" name="text_representant"
                                                                            class="form-control"><?php if (isset($data_partenaire->text_representant)) {
        echo $data_partenaire->text_representant;
    }
    ?></textarea>

                                                                        @error('text_representant')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>


                                                                    </br>
                                                                    <div class="form-group">
                                                                        <div class="col-md-6 col-md-offset-4">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">{{__("messages.btn_modifier")}}</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <?php if (!empty($autorisation)) {$autorisation = "valide";} else { $autorisation = "no-valise";}?>
                                                <x-autorisation type="delete-partenaire" :autorisation="$autorisation"
                                                    :id="$data_partenaire->id" />
												<?php }?>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection