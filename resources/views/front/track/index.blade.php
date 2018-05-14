@extends('front.layouts.account')

{{-- Page Title --}}
@section('pageTitle')
    Track de visitantes
@endsection



{{-- Content --}}
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 text-center" style="font-size: 19px; color: #fff;">
				<div class="row" style="margin-top: 25px; margin-bottom: 30px;">
					<div class="col-sm-12 text-center">
						<img src="http://metodika.com.mx/beeplot/admin/public/storage/uploads/{{ $company->white_picture }}" alt="" style="max-width: 100%;">
					</div>
				</div>

				<b id="total">{{ $stats['total'] }}</b><br/>Gente conectada a Bee-Fi
				<ul id="track" data-name="{{ $company->name }}" data-url="{{ url('client/track') }}" style="list-style: none;">
					<li>
						<b id="woman">{{ $stats['woman'] }}</b> Mujeres
					</li>

					<li>
						<b id="man">{{ $stats['man'] }}</b> Hombres
					</li>
				</ul>
			</div>
		</div>
	</div>
@stop

@section('JS')
	{{ Html::script('front/js/track/index.js') }}
@stop