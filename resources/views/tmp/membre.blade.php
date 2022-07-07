<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from adminlte.io/themes/v3/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Dec 2021 13:57:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muso mobile</title>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/images/favicon.ico')}} ">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css')}} ">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../../code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css')}} ">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote-bs4.min.css')}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <?php $info = DB::table('users')
                ->join('members', 'members.users_id', '=', 'users.id')
                ->leftJoin('musos', 'musos.id', '=', 'members.musos_id')
                ->where('members.users_id',Auth::user()->id)->get(); ?>
                @foreach($info as $key)
                <span> {{ $key->name_muso}} </span>
                @endforeach
                <li class="breadcrumb-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Deconnexion') }}
                        </x-responsive-nav-link>
                    </form>


                </li>


            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('public/dist/img/logo_muso.png ') }} " alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Musomobil</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        </br>
                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    MUSO
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('parametre-muso')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Paramétrer Muso</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('decision.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Décision</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('rencontre.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rencontre </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Réinitialiser Muso</p>
                                    </a>
                                </li>



                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    MEMBRES
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-info right">
                                        <?php 
                                        
                                        $musos = DB::table('musos')->where('users_id',Auth::user()->id)->get(); 
                                            foreach($musos as $key){
                                            $info =  DB::table('members')
                                            ->where('musos_id',$key->id)
                                            ->where('deleted_at','=',Null)->get();
                                             echo  $info->count();
                                            }
                                        ?>

                                    </span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ajouter-membre')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Ajouter Membre</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('lister-membre')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Liste Membre</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('lister-membre')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Exclure Membre</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        </br>
                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    CAISE VERT
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Parametre CV</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Cotisation CV</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Contribution CB</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Remboursement CB</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport CV</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    CAISE rouge
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Parametre CR</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Cotisation CR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Dépense CR</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport CR</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    CAISE BLEU
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Parametres CB</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Contribution Externe</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Remboursement Externe</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Décaissement CV</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Remboursement CV</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>List des Prêt CB</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport CB</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        </br>
                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon 	fas fa-money-check"></i>
                                <p>
                                    Prêt
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>demande de Prêt</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Decaissement</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Remboursement</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport Prêt</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    RAPPORT
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport CV</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport CR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Rapport CB</p>
                                    </a>
                                </li>

                            </ul>
                        </li>



                    </ul>


                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Mutuelle Solidarité</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->


            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>785524<sup style="font-size: 20px">gds</sup></h3>

                                    <p>Caisse Blue</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>12248<sup style="font-size: 20px">gds</sup></h3>

                                    <p>Caisse vert</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>52698<sup style="font-size: 20px">gds</sup></h3>

                                    <p>Caisse rouge</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->

                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            @yield('content')

        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="#">Musomobile</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('public/plugins/jquery/jquery.min.js')}} "></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js')}} "></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
    <!-- ChartJS -->
    <script src="{{ asset('public/plugins/chart.js/Chart.min.js')}} "></script>
    <!-- Sparkline -->
    <script src="{{ asset('public/plugins/sparklines/sparkline.js')}} "></script>
    <!-- JQVMap -->
    <script src="{{ asset('public/plugins/jqvmap/jquery.vmap.min.js')}} "></script>
    <script src="{{ asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js')}} "></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('public/plugins/jquery-knob/jquery.knob.min.js')}} "></script>
    <!-- daterangepicker -->
    <script src="{{ asset('public/plugins/moment/moment.min.js')}} "></script>
    <script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js')}} "></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}} "></script>
    <!-- Summernote -->
    <script src="{{ asset('public/plugins/summernote/summernote-bs4.min.js')}} "></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}} "></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public/dist/js/adminlte.js')}} "></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('public/dist/js/demo.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('public/dist/js/pages/dashboard.js')}}"></script>
    <!-- jQuery -->
    <script src="{{ asset('public/plugins/jquery/jquery.min.js')}} "></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}} "></script>
    <script src="{{ asset('public/plugins/jszip/jszip.min.js')}} "></script>
    <script src="{{ asset('public/plugins/pdfmake/pdfmake.min.js')}} "></script>
    <script src="{{ asset('public/plugins/pdfmake/vfs_fonts.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}} "></script>
    <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}} "></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public/dist/js/adminlte.min.js')}} "></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('public/dist/js/demo.js')}} "></script>
    <!-- Page specific script -->
    <script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    </script>
</body>

<!-- Mirrored from adminlte.io/themes/v3/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Dec 2021 13:57:48 GMT -->

</html>