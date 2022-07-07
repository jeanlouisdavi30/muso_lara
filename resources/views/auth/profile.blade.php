@extends('tmp.muso')

@section('content')


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ url('public/'.Auth::user()->picture) }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

                        <p class="text-muted text-center">Administration Muso</p>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Info Muso
                                </a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Profile
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Parametres
                                </a>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Modifier
                                    Password
                                </a>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">
                                    Adresse
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post">

                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post clearfix">

                                    <!-- /.user-block -->
                                    <p>
                                        INFO MUSO
                                    </p>


                                </div>
                                <!-- /.post -->

                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">

                                    <div class="container">
                                        <div class="row">

                                            <div class="col-md-10 offset-2">
                                                <div class="panel panel-default">
                                                    <h2>Change password</h2>

                                                    <div class="panel-body">
                                                        @if (session('error'))
                                                        <div class="alert alert-danger">
                                                            {{ session('error') }}
                                                        </div>
                                                        @endif

                                                        @if (session('success'))
                                                        <div class="alert alert-success">
                                                            {{ session('success') }}
                                                        </div>
                                                        @endif

                                                        @if($errors)
                                                        @foreach ($errors->all() as $error)
                                                        <div class="alert alert-danger">{{ $error }}</div>
                                                        @endforeach

                                                        @endif
                                                        <form class="form-horizontal" method="POST"
                                                            action="{{ route('changePasswordPost') }}" id="main_form">
                                                            {{ csrf_field() }}

                                                            <div
                                                                class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                                                <label for="new-password"
                                                                    class="col-md-4 control-label">Current
                                                                    Password</label>

                                                                <div class="col-md-6">
                                                                    <input id="current-password" type="password"
                                                                        class="form-control" name="current-password"
                                                                        required>

                                                                    @if ($errors->has('current-password'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('current-password') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                    <span style="color:red;"
                                                                        class="error-text current_error"></span>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                                                <label for="new-password"
                                                                    class="col-md-4 control-label">New Password</label>

                                                                <div class="col-md-6">
                                                                    <input id="new-password" type="password"
                                                                        class="form-control" name="new-password"
                                                                        required>

                                                                    @if ($errors->has('new-password'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('new-password') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="new-password-confirm"
                                                                    class="col-md-4 control-label">Confirm New
                                                                    Password</label>

                                                                <div class="col-md-6">
                                                                    <input id="new-password-confirm" type="password"
                                                                        class="form-control"
                                                                        name="new-password_confirmation" required>
                                                                </div>
                                                                <span style="color:red;"
                                                                    class="error-text confirm_error"></span>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-6 col-md-offset-4">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Change Password
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputExperience"
                                                placeholder="Experience"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputSkills"
                                                placeholder="Skills">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to the <a href="#">terms and
                                                        conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="{{ asset('public/plugins/jquery/jquery.min.js')}} "></script>
<script src="{{ asset('public/js/main.js')}} "></script>

@endsection