@extends('front.layouts.main')

{{-- Page Title --}}
@section('pageTitle')
    Historia de cupones
@endsection


@section('header-left')
	<a href="{{ url('/client/promotions') }}" class="go-back">
		<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> Regresar
	</a>
@stop

@section('header-center')
	<h2 style="margin-bottom: 20px;">Historial de cupones</h2>
@stop

{{-- Content --}}
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center">
				<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $company->profile_picture }}" alt="">
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@foreach ($cupons as $cupon)
					<div class="row">
						<div class="col-sm-9"></div>
						<div class="col-sm-3 text-right">
							<a href="{{ url('client/promotions/delete/'.$cupon->id) }}" class="btn btn-danger mtk-red-button-two" data-name="{{ $cupon->text }}">Borrar cupón</a>
						</div>
					</div>

					<div class="row bg mtk-margin-bottom mtk-cupon-item-list" data-url="{{ url('/client/promotions/detail/'.$cupon->id) }}" data-id="{{ $cupon->id }}">
						<div class="col-sm-5" data-id="{{ $cupon->id }}">
							<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $company->profile_picture }}" style="max-width: 70%;" alt="">
						</div>

						<div class="col-sm-2 text-center">
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2">
									<div class="mkt-bun-small"></div>	
								</div>
							</div>

							<div class="row">
								<div class="col-xs-4 col-xs-offset-2">
									<div class="mtk-smallest-circle"></div>
								</div>

								<div class="col-xs-4 col-xs-offset-2">
									<div class="mtk-smallest-circle"></div>
								</div>
							</div>
						</div>

						<div class="col-sm-5 text-right" data-id="{{ $cupon->id }}">
							<h4 class="mtk-history-h4">
								Expiración
							</h4>
							<h5 class="mtk-history-h5">{{ $cupon->end_date }}</h5>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@stop

@section('JS')
	{{ Html::script('front/js/promotion/history.js') }}
@stop