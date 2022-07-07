@extends('tmp.muso')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">

                <div class="alert  alert-dismissible col-md-7">
                    <h3>
                       {{__("messages.transaction")}}{{__("messages.membre")}} </h3>

                    <h5 style="color:red;"> <i class="nav-icon fas fa-user"></i> {{$membre->last_name}}
                        {{$membre->first_name}} </h5>
                </div>

                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#pret" data-toggle="tab">
                                    {{__("messages.pret")}} </a></li>
                            <li class="nav-item"><a class="nav-link" href="#cv" data-toggle="tab">{{__("messages.cv")}}
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#cr" data-toggle="tab">{{__("messages.cr")}}
                                </a>
                            </li>

                            <li class="nav-item"><a class="nav-link"
                                    href="{{ url('member-info') }}/{{$membre->id}}">{{__("messages.retour")}}
                                </a>
                            </li>

                        </ul>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane" id="cr">
                                <span style="color:red; font-weight:600; font-size:20px;">Total : {{ $somme_cr}}
                                    {{$settings->curency}}</span>
                                <div class="post clearfix">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__("messages.caisses")}}</th>
                                                <th>{{__("messages.rencontres")}}</th>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($cr as $k)
                                            <tr>
                                                </td>
                                                <td>{{$k->type_caisse}}</td>
                                                <td>{{$k->title_meetting}}
                                                </td>
                                                <td>{{$k->date_meetting}}</td>
                                                <td> {{$k->montant}} {{$settings->curency}}</td>

                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.post -->

                            </div>
                            <div class="active tab-pane" id="pret">
                                <span style="color:red; font-weight:600; font-size:20px; ">Total : {{ $somme_pret}}
                                    {{$settings->curency}}</span>
                                <div class="post clearfix">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__("messages.titre")}}</th>
                                                <th>{{__("messages.caisses")}}</th>
                                                <th>{{__("messages.d_naissance")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                                <th>%</th>
                                                <th>{{__("messages.Duree")}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($pret as $k)
                                            <tr>
                                                </td>
                                                <td>{{$k->titre}}</td>
                                                <td>{{$k->caisse}}
                                                </td>
                                                <td> <?php $date = new DateTime($k->date_decaissement);
echo $date->format('d-M-Y');?></td>
                                                <td> {{$k->montant}} {{$settings->curency}}</td>
                                                <td>{{$k->pourcentage_interet}}</td>
                                                <td>{{$k->duree}} Mois</td>
                                                <td><a class="btn btn-danger btn-sm"
                                                        href="{{ url('voir-pret-encours') }}/{{$k->id}}"> {{__("messages.voir")}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.post -->

                            </div>
                            <div class="tab-pane" id="cv">
                                <span style="color:red; font-weight:600; font-size:20px;">Total : {{ $somme_cv}}
                                    {{$settings->curency}}</span>
                                <div class="post clearfix">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__("messages.caisses")}}</th>
                                                <th>{{__("messages.rencontres")}}</th>
                                                <th>{{__("messages.date")}}</th>
                                                <th>{{__("messages.montant")}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($cv as $k)
                                            <tr>
                                                </td>
                                                <td>{{$k->type_caisse}}</td>
                                                <td>{{$k->title_meetting}}
                                                </td>
                                                <td>{{$k->date_meetting}}</td>
                                                <td> {{$k->montant}} {{$settings->curency}}</td>

                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.post -->

                            </div>


                            <!-- /.tab-pane -->
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


@endsection