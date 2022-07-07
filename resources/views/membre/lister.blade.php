@extends('tmp.muso')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{__("messages.les_m")}}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{__("messages.nom")}}</th>
                    <th>{{__("messages.prenom")}}</th>
                    <th>{{__("messages.sexe")}}</th>
                    <th>{{__("messages.d_naissance")}}</th>
                    <th>{{__("messages.fonction")}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($membre as $k)
                <tr>
                    </td>
                    <td>{{$k->last_name}}</td>
                    <td>{{$k->first_name}}
                    </td>
                    <td>{{$k->sexe}}</td>
                    <td> {{$k->date_birth}}</td>
                    <td>{{$k->function}}</td>

                    <?php if (Auth::user()->utype == "admin"
    or Auth::user()->utype == "President"
    or Auth::user()->utype == "Tresorier"
    or Auth::user()->id == $k->users_id) {?>

                    <td>
                        <a class="btn btn-info btn-sm" href="{{ url('member-info')}}/{{ $k->id}}">
                            <i class="fas fas fa-folder">
                            </i>
                            {{__("messages.voir")}}
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

@endsection