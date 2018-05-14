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

    {{-- CSS --}}
    {{Html::style('vendors/bootstrap/dist/css/bootstrap.min.css')}}
    {{Html::style('vendors/font-awesome/css/font-awesome.min.css')}}
    {{Html::style('vendors/nprogress/nprogress.css')}}
    {{Html::style('vendors/animate.css/animate.min.css')}}
    {{Html::style('build/css/custom.min.css')}}

    {{-- Coustume CSS Files --}}
    @section('CSS')
    @show
</head>

<body class="login">
    <div>
        <div class="login_wrapper">
            {{-- Body content --}}
            @section('content')
            @show
        </div>
    </div>

    {{-- Coustume JS Files --}}
    @section('JS')
    @show
</body>
</html>