@extends('front.layouts.account')

@section('pageTitle')
	Inicio de sesión
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">

				<h2 class="text-center">
					<img src="{{ url('/') }}/front/img/logo-white.svg" class="text-center mtk-logo" alt="">
					Administrador
				</h2>

				@if ($errors->has('email') || $errors->has('password') || Session::has('loginError'))
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        Combinación de correo electrónico y cntraseña incorrecto.
                    </div>
                @endif

				{{ Form::open(['url' => 'client']) }}
					<div class="form-group mtk-form-group">
						<input type="email" placeholder="Correo electrónico" name="correoElectronico" class="form-control mtk-input">
					</div>

					<div class="form-group mtk-form-group">
						<input type="password" placeholder="Contraseña" name="password" class="form-control mtk-input">
					</div>

					<div class="form-group text-center">
						<button class="btn btn-success mtk-green-button" type="submit">Iniciar sesión</button>
					</div>

					<div class="form-group text-center" style="margin-bottom: 50px; margin-top: 30px;">
						<a href="{{ url('/client/password') }}" style="color: #fff">¿Haz olvidado tu contraseña?</a>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop