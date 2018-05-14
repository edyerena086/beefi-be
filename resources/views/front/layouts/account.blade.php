<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Page Title --}}
    <title>
       @yield('pageTitle') - {{ ENV('APP_NAME') }}
    </title>

    {{-- CSS --}}
    {{Html::style('front/bootstrap/css/bootstrap.min.css')}}
    {{Html::style('front/css/main.css')}}

    {{-- Coustume CSS Files --}}
    @section('CSS')
    @show

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="bg">
    {{-- Body content --}}
    @section('content')
    @show


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    {{ Html::script('front/bootstrap/js/bootstrap.min.js') }}
    {{-- Bootbox --}}
    {{Html::script('js/bootbox/bootbox.js')}}
    {{ Html::script('https://code.jquery.com/ui/1.12.1/jquery-ui.js') }}
    {{-- Pastora Library --}}
    {{Html::script('js/dashboard/pastora.js')}}

    {{-- Coustume JS Files --}}
    @section('JS')
    @show
</body>
</html>