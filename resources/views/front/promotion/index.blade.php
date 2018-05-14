@extends('front.layouts.account')

{{-- Page Title --}}
@section('pageTitle')
    Dashboard
@endsection

{{-- Content --}}
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="row" style="margin-top: 25px;">
					<div class="col-sm-12 text-center">
						<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $company->profile_picture }}" alt="" style="max-width: 100%;">
					</div>
				</div>

				<ul style="margin-top: 50px;">
					<li class="text-center">
						<a href="{{ url('client/promotions/create') }}" class="btn btn-success mtk-green-button-two">Crear Cupón</a>
					</li>

					<li class="text-center">
						<a href="{{ url('client/promotions/history') }}" class="btn btn-success mtk-green-button-two">Historial de cupones</a>
					</li>

					<li class="text-center">
						<a href="{{ url('client/track/'.Auth::user()->id) }}" class="btn btn-success mtk-green-button-two">Track de visitantes</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
@stop