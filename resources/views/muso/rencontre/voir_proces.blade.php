@extends('tmp.muso')

@section('content')



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President") {?>
            <div class="col-md-6">
                <!-- general form elements -->

                <h2>{{__("messages.text_poces")}}</h2>
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="{{ url('rencontre') }}">
                                    {{__("messages.retour")}} </a></li>

                        </ul>
                    </div><!-- /.card-header -->
                </div>
                <div class="card card-primary">


                    <div class="card-body">


                        <div class="active tab-pane" id="activity" style=" padding:15px; background-color:white;">
                            <!-- Post -->
                            <div class="post clearfix">

                                <ul class="list-group list-group-unbordered mb-4">



                                    <?php if ($rencontre->type_fichier != "pdf") {?>
                                    <input type="image" data-toggle="modal" data-target="#myModal{{$rencontre->id}}"
                                        class="float-right" src="{{ url('public/images_all/'.$rencontre->fichier) }}"
                                        width="30%" />
                                    <?php } else {?>
                                    <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal"
                                        data-target="#myModal{{$rencontre->id}}">Lire
                                        documenet
                                        PDF</button>
                                    <?php }?>

                                    <div class="modal fade" id="myModal{{$rencontre->id}}" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">

                                                <div class="modal-body">
                                                    <?php if ($rencontre->type_fichier != "pdf") {?>
                                                    <img id="myImg" class="float-right" width="100%"
                                                        src="{{ url('public/images_all/'.$rencontre->fichier) }}"
                                                        alt="Snow">
                                                    <?php } else {?>
                                                    <embed src="{{ url('public/images_all/'.$rencontre->fichier) }}"
                                                        width="450" height="375" type="application/pdf">
                                                    <?php }?>
                                                </div>



                                            </div>

                                        </div>
                                    </div>


                                    <li class="list-group-item">
                                        <b> {{__("messages.titre")}}</b> <a
                                            class="float-right">{{$rencontre->title_meetting}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b> {{__("messages.date_rencontre")}}</b> <a
                                            class="float-right">{{$rencontre->date_meetting}}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b> {{__("messages.p_verbal")}} </b> <a
                                            class="float-right"><?php echo $rencontre->proces; ?></a>
                                    </li>

                                </ul>
                                <a class="btn btn-danger btn-sm" href="{{ route('modifier-proces',[$rencontre->id]) }}">
                                    <i class="fas fas fa-edit">
                                    </i>
                                    {{__("messages.modifier")}}
                                </a>

                            </div>

                        </div>



                    </div>

                </div>

                <?php }?>

            </div>

        </div>
</section>


@endsection