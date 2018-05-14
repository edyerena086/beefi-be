@extends('front.layouts.main')

{{-- Page Title --}}
@section('pageTitle')
    Nuevo cupón
@endsection

@section('header-left')
	<a href="{{ url('/client/promotions') }}" class="go-back">
		<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> Regresar
	</a>
@stop

@section('header-center')
	<h2 style="margin-bottom: 20px;">Crear cupón</h2>
@stop

@section('header-right')
	<div class="row">
		<div class="col-sm-12 text-right">
			<a href="" class="lnkSubmit go-back"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Enviar!</a>
		</div>
	</div>
@stop

{{-- Content --}}
@section('content')
	<div class="container-fluid">
		{{ Form::open(['url' => 'client/promotions/']) }}
		{{--<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<a href="{{url('/client/promotions')}}">Regresar</a>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-12 text-center">
				<h3 class="mtk-h3">
					Crear cupón
				</h3>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-12 text-right">
				<a href="" class="lnkSubmit">Enviar!</a>
			</div>
		</div>--}}

		<div class="row mtk-form-group">
			<div class="col-md-12 text-center">
				<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $company->profile_picture }}" alt="" style="max-width: 50%;">
			</div>
		</div>


		
		<div class="row">
			<div class="col-md-6 col-md-offset-3 bg">
				<div class="row mtk-form-group mtk-line-jump">
					<div class="col-sm-5 text-center">
						<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $company->profile_picture }}" class="max-image" alt="">
					</div>
					
					<div class="col-sm-2">
						<div class="mkt-bun"></div>

						<div class="row">
							<div class="col-xs-4">
								<div class="mtk-small-circle"></div>
							</div>

							<div class="col-xs-4 col-xs-offset-4">
								<div class="mtk-small-circle"></div>
							</div>
						</div>
					</div>

					<div class="col-sm-4 col-sm-offset-1">
						<input type="text" name="fechaDeExpiracion" id="datepicker" placeholder="Fecha de expiración" class="form-control mtk-input">
					</div>
				</div>

				<div class="row mtk-form-group">
					<div class="col-sm-4 text-center">
						<label for="" style="color: #EDAD23; font-size: 1.5rem;">Icono</label>
						{{ Form::file('icono', ['class' => 'form-control mtk-input', 'id' => 'icono']) }}
					</div>

					<div class="col-sm-4">
						<img src="{{ url('/') }}/front/img/logo-yellow.svg" alt="">
					</div>

					<div class="col-sm-4 text-center">
						{!! QrCode::size(150)->generate(Request::url()); !!}
						<input type="text" name="url" placeholder="Url de recurso" class="form-control mtk-input">
					</div>
				</div>

				<div class="row mtk-form-group">
					<div class="col-sm-12">
						{{ Form::textarea('textoDePromocion', null, ['class' => 'form-control mtk-input-textarea', 'placeholder' => "Texto de la promoción"]) }}
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12 text-center">
						<ul class="mtk-list">
							<li>
								<a href="" class="btn btn-warning mtk-yellow-button-two">Obtener beneficio</a>
							</li>

							<li>
								<a href="" class="btn btn-warning mtk-yellow-button-two">No gracias</a>
							</li>

							<li>
								<span class="btn-bwallet-wrapper"></span>
								<a href="" class="add-bwallet" data-state="false">+</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="row mtk-line-jump">
			<div class="col-md-6 col-md-offset-3">
				<div class="row mtk-line-small">
					<div class="col-sm-8 text-center black-text">
						Número de cupones
					</div>

					<div class="col-sm-4">
						<input type="number" name="numeroDeCupones" class="form-control">
					</div>
				</div>

				<div class="row mtk-line-small">
					<div class="col-sm-8 text-center black-text">
						Genero
					</div>

					<div class="col-sm-4">
						<select name="genero" id="" class="form-control">
							<option value="1">Femenino</option>
							<option value="2">Masculino</option>
							<option value="3">Ambos</option>
						</select>
					</div>
				</div>

				<div class="row mtk-line-small">
					<div class="col-sm-8 text-center black-text">
						Número de mesa
					</div>

					<div class="col-sm-4">
						<input type="number" name="numeroDeMesas" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 text-center">
						<button class="btn btn-primary" type="submit">Guardar</button>
					</div>
				</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>
@stop

@section('JS')
	{{ Html::script('front/js/promotion/create.js') }}
@stop