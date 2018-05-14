@extends('front.layouts.main')

{{-- Page Title --}}
@section('pageTitle')
    Detall de cupón
@endsection

@section('header-left')
	<a href="{{ url('/client/promotions/history') }}" class="go-back">
		<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> Regresar
	</a>
@stop

@section('header-center')
	<h2 style="margin-bottom: 20px;">Detalle de cupón</h2>
@stop

{{-- Content --}}
@section('content')
	<div class="container-fluid">
		{{--<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<a href="{{url('/client/promotions/history')}}">Regresar</a>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-12 text-center">
				<h3 class="mtk-h3">
					Detalle de Cupón
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
						<p class="text-right cupon-end-date-title">
							Expiración
						</p>
						<p class="text-right cupon-end-date">
							{{ $cupon->end_date }}
						</p>
					</div>
				</div>

				<div class="row mtk-form-group">
					<div class="col-sm-4">
						@if($cupon->icon != "")
							<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $cupon->icon }}" class="max-image" alt="">
						@endif
					</div>

					<div class="col-sm-4">
						<img src="{{ url('/') }}/front/img/logo-yellow.svg" alt="">
					</div>

					<div class="col-sm-4 text-center">
						{!! QrCode::size(150)->generate($cupon->url); !!}
					</div>
				</div>

				<div class="row mtk-form-group">
					<div class="col-sm-12">
						<p class="cupon-text">
							{{ $cupon->text }}
						</p>
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
								@if ($cupon->bwallet == 1)
									<a href="" class="btn btn-warning mtk-yellow-button-two">Agregar e BWallet</a>
								@endif
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
						<input type="number" value="{{ $cupon->total_cupons }}" name="numeroDeCupones" class="form-control">
					</div>
				</div>

				<div class="row mtk-line-small">
					<div class="col-sm-8 text-center black-text">
						Genero
					</div>

					<div class="col-sm-4">
						<input type="number" value="{{ $cupon->gender }}" name="numeroDeMesas" class="form-control">
					</div>
				</div>

				<div class="row mtk-line-small">
					<div class="col-sm-8 text-center black-text">
						Número de mesa
					</div>

					<div class="col-sm-4">
						<input type="number" value="{{ $cupon->total_tables }}" name="numeroDeMesas" class="form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('JS')
	{{ Html::script('front/js/promotion/create.js') }}
@stop