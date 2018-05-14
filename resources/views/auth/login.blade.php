@extends('layouts.auth')

{{-- Page Title --}}
@section('pageTitle')
    Inicio de sesión
@endsection

{{-- Content --}}
@section('content')
    <div class="animate form login_form">
        <section class="login_content">
            {!!Form::open(['url' => 'account/login'])!!}
                <h1>Inicio de sesión</h1>

                @if ($errors->has('email') || $errors->has('password') || Session::has('loginError'))
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        Combinación de correo electrónico y cntraseña incorrecto.
                    </div>
                @endif

                <div>
                    <input type="text" name="email" class="form-control" placeholder="Correo electrónico" required="" />
                </div>

                <div>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required="" />
                </div>

                <div>
                    <button class="btn btn-default submit" type="submit">Iniciar sesión</button>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">
                        {!! Html::link('auth/password-recovery', 'Recuperar contraseña', ['class' => 'to_register']) !!}
                    </p>
                </div>
            {!!Form::close()!!}
        </section>
    </div>
@endsection