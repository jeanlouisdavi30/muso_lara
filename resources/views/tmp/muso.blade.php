<!DOCTYPE html>
<html>

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
                <?php
if (Auth::user()->utype == "admin") {
    $info_muso = DB::table('musos')->where('users_id', Auth::user()->id)->first();
    $id_musos = $info_muso->id;
    $name_muso = $info_muso->name_muso;
} else {
    $info_muso = DB::table('members')->select('members.last_name', 'members.first_name', 'musos.name_muso',
        'musos.representing', 'musos.phone', 'musos.registered_date', 'musos.contry', 'musos.network', 'members.musos_id')
        ->join('musos', 'musos.id', '=', 'members.musos_id')
        ->where('members.users_id', Auth::user()->id)->first();
    //dd($info);
    $id_musos = $info_muso->musos_id;
    $name_muso = $info_muso->name_muso;
}
?>

                <span> {{ $name_muso}} </span>

                <li class="breadcrumb-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{__("messages.connex")}}
                        </x-responsive-nav-link>
                    </form>

                </li>

                <li class="breadcrumb-item">
                    {{__("messages.langue")}} : <select onchange="changeLanguage(this.value)">
                        <option {{session()->has('lang_code')?(session()->get('lang_code')=='fr'?'selected':''):''}}
                            value="fr">FR</option>
                        <option {{session()->has('lang_code')?(session()->get('lang_code')=='cr'?'selected':''):''}}
                            value="cr">CR</option>
                        <option {{session()->has('lang_code')?(session()->get('lang_code')=='en'?'selected':''):''}}
                            value="en">EN</option>
                        <option {{session()->has('lang_code')?(session()->get('lang_code')=='es'?'selected':''):''}}
                            value="es">SP</option>
                    </select>
                </li>

                <script>
                function changeLanguage(lang) {
                    window.location = '{{url("change-language")}}/' + lang;
                }
                </script>
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
                                        <p>{{__("messages.parametrer")}}</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('rencontre.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.rencontres")}} </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ route('decision.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.decisions")}}</p>
                                    </a>
                                </li>


                                <!--
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Réinitialiser</p>
                                    </a>
                                </li>

-->



                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p style="text-transform:uppercase;">
                                    {{__("messages.membres")}}
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-info right">
                                        <?php

$musos = DB::table('musos')->where('id', $id_musos)->get();
foreach ($musos as $key) {
    $info = DB::table('members')
        ->where('musos_id', $key->id)
        ->where('deleted_at', '=', null)->get();
    echo $info->count();
}
?>

                                    </span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (Auth::user()->utype == "admin" or Auth::user()->utype == "President" or Auth::user()->utype == "Tresorier") {?>

                                <li class="nav-item">
                                    <a href="{{ route('ajouter-membre')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p> {{__("messages.ajt_m")}}</p>
                                    </a>
                                </li>
                                <?php }?>
                                <li class="nav-item">
                                    <a href="{{ route('lister-membre')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.les_m")}}</p>
                                    </a>
                                </li>
                                <!--
                                <li class="nav-item">
                                    <a href="{{ route('lister-membre')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>Exclure un membre</p>
                                    </a>
                                </li> -->

                            </ul>
                        </li>
                        </br>
                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p style="text-transform:uppercase;">
                                    {{__("messages.cv")}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="{{ route('cotisation-caisse-vert') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.cotisation")}}</p>
                                    </a>
                                </li>

                                <!--
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

                                  -->

                                <li class="nav-item">
                                    <a href="{{ route('depense-cv') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.depense")}}</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('transfert-cv') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.transfert")}}</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p style="text-transform:uppercase;">
                                    {{__("messages.cr")}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="{{ route('cotisation-caisse-rouge') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.contribution")}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('retrait-cr')}}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.sorties")}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('transfert-cr') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.transfert")}}</p>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p style="text-transform:uppercase;">
                                    {{__("messages.cb")}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('partenaires') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.partenaires")}}</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('contribution') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.cotisation")}}</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ route('transfert-cb') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.transfert")}}</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        </br>
                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon 	fas fa-money-check"></i>
                                <p style="text-transform:uppercase;">
                                    {{__("messages.pret")}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pret') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.dpret")}}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('decaissement') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p>{{__("messages.decaissement")}}</p>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <li class="nav-item">

                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p style="text-transform:uppercase;">
                                    {{__("messages.rapport")}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p> {{__("messages.rapport")}} CV</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p> {{__("messages.rapport")}} CR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p> {{__("messages.rapport")}} CB</p>
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
            </br>

            <?php $muso_parametre = DB::table('settings')->where('musos_id', $id_musos)->first();?>
            <section class=" content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>

                                        <?php

$caisseBleue = DB::table('caisses')
    ->select(DB::raw("sum(caisseBleue) as count"))
    ->where('musos_id', $id_musos)
    ->first();
echo $caisseBleue->count;

?>

                                        <sup style="font-size: 20px"><?php if (isset($muso_parametre->curency)) {
    echo $muso_parametre->curency;
}
?>
                                        </sup>
                                    </h3>

                                    <p>{{__("messages.cb")}}</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>
                                        <?php

$caisseVert = DB::table('caisses')
    ->select(DB::raw("sum(caisseVert) as count"))
    ->where('musos_id', $id_musos)
    ->first();
echo $caisseVert->count;

?>

                                        <sup style="font-size: 20px"><?php if (isset($muso_parametre->curency)) {
    echo $muso_parametre->curency;
}
?></sup>
                                    </h3>

                                    <p>{{__("messages.cv")}}</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>

                                        <?php

$caisseRouge = DB::table('caisses')
    ->select(DB::raw("sum(caisseRouge) as count"))
    ->where('musos_id', $id_musos)
    ->first();
echo $caisseRouge->count;

?>
                                        <sup style="font-size: 20px"><?php if (isset($muso_parametre->curency)) {
    echo $muso_parametre->curency;
}
?></sup>
                                    </h3>

                                    <p>{{__("messages.cr")}}</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
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
            <strong>{{__("messages.d_auteurs")}} &copy; 2022 <a href="#">Musomobile</a>.</strong>
            {{__("messages.d_reserve")}}.
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
    <!-- jQuery -->
    <script src="{{ asset('public/js/main.js')}} "></script>



    <!-- Bootstrap 4 -->
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
    <!-- AdminLTE for demo purposes -->
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