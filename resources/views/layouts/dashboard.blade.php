<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Page Title --}}
    <title>
        @yield('pageTitle') - {{ENV('APP_NAME')}}
    </title>

    {{-- Bootstrap --}}
    {{Html::style('vendors/bootstrap/dist/css/bootstrap.min.css')}}
    {{-- Font Awesome --}}
    {{Html::style('vendors/font-awesome/css/font-awesome.min.css')}}
    {{-- NProgress --}}
    {{Html::style('vendors/nprogress/nprogress.css')}}
    {{-- iCheck --}}
    {{Html::style('vendors/iCheck/skins/flat/green.css')}}
    {{-- Bootstrap progressbar --}}
    {{Html::style('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}
    {{-- JQVMap --}}
    {{Html::style('vendors/jqvmap/dist/jqvmap.min.css')}}
    {{-- Bootstrap Daterangepicker --}}
    {{Html::style('vendors/bootstrap-daterangepicker/daterangepicker.css')}}
    {{-- Datatables --}}
    {{Html::style('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}
    {{Html::style('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}
    {{Html::style('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}
    {{Html::style('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}
    {{Html::style('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}
    {{-- Custome theme styles --}}
    {{Html::style('build/css/custom.min.css')}}
    {{Html::style('css/main.css')}}

    {{-- Preloader --}}
    {{Html::script('js/preloader.js')}}


    {{-- Coustume CSS Files --}}
    @section('CSS')
    @show
</head>

<body class="nav-md">

<div class="preloader"></div>

<div class="container body main-wrapper">
    <div class="main_container">
        {{-- Left Column --}}
        @include('layouts.partials.menu-lateral')

        {{-- Top menu --}}
        @include('layouts.partials.menu-top')

        {{-- Content --}}
        <div class="right_col" role="main">
            {{-- Content Title--}}
            <div class="page-title">
                <div class="title_left">
                    <h1>
                        @section('contentTitle')
                        @show
                    </h1>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 pull-right text-right">
                        @section('topButton')
                        @show
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>


            {{-- Main Content --}}
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                @section('innerTitle')
                                @show
                                <small>
                                    @section('innerSmallTitle')
                                    @show
                                </small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <br />

                            @yield('mainContent')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- JQuery --}}
{{Html::script('vendors/jquery/dist/jquery.min.js')}}
{{-- Bootstrap --}}
{{Html::script('vendors/bootstrap/dist/js/bootstrap.min.js')}}
{{-- Fast click --}}
{{Html::script('vendors/fastclick/lib/fastclick.js')}}
{{-- NProgress --}}
{{Html::script('vendors/nprogress/nprogress.js')}}
{{-- Chart JS--}}
{{Html::script('vendors/Chart.js/dist/Chart.min.js')}}
{{-- Gauge --}}
{{Html::script('vendors/gauge.js/dist/gauge.min.js')}}
{{-- Bootstrap Progressbar --}}
{{Html::script('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}
{{-- iCheck --}}
{{Html::script('vendors/iCheck/icheck.min.js')}}
{{-- Skycons --}}
{{Html::script('vendors/skycons/skycons.js')}}
{{-- Flot --}}
{{Html::script('vendors/Flot/jquery.flot.js')}}
{{Html::script('vendors/Flot/jquery.flot.pie.js')}}
{{Html::script('vendors/Flot/jquery.flot.time.js')}}
{{Html::script('vendors/Flot/jquery.flot.stack.js')}}
{{Html::script('vendors/Flot/jquery.flot.resize.js')}}
{{-- Flot plugins --}}
{{Html::script('vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}
{{Html::script('vendors/flot-spline/js/jquery.flot.spline.min.js')}}
{{Html::script('vendors/flot.curvedlines/curvedLines.js')}}
{{-- DateJS --}}
{{Html::script('vendors/DateJS/build/date.js')}}
{{-- JQVMaps --}}
{{Html::script('vendors/jqvmap/dist/jquery.vmap.js')}}
{{Html::script('vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}
{{Html::script('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}
{{-- Bootstrap Daterangepicker --}}
{{Html::script('vendors/moment/min/moment.min.js')}}
{{Html::script('vendors/bootstrap-daterangepicker/daterangepicker.js')}}
{{-- Datatable --}}
{{Html::script('vendors/datatables.net/js/jquery.dataTables.min.js')}}
{{Html::script('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}
{{Html::script('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}
{{Html::script('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}
{{Html::script('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}
{{Html::script('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}
{{Html::script('vendors/datatables.net-buttons/js/buttons.print.min.js')}}
{{Html::script('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}
{{Html::script('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}
{{Html::script('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}
{{Html::script('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}
{{Html::script('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}
{{Html::script('vendors/jszip/dist/jszip.min.js')}}
{{Html::script('vendors/pdfmake/build/pdfmake.min.js')}}
{{Html::script('vendors/pdfmake/build/vfs_fonts.js')}}
{{-- Bootbox --}}
{{Html::script('js/bootbox/bootbox.js')}}
{{-- Custome theme scripts --}}
{{Html::script('build/js/custom.js')}}
{{-- Pastora Library --}}
{{Html::script('js/dashboard/pastora.js')}}

{{-- Coustume CSS Files --}}
@section('JS')
@show
</body>
</html>