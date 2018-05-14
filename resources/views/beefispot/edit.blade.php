@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Editar Beefispot
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Ediat Beefispot
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/beefispot')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/beefispot/update/'.base64_encode($beefispot->id), 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Título: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('titulo', $beefispot->title, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
            Descripción: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::textarea('descripcion', $beefispot->description, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
            Descripción: <span class="required">*</span>
        </label>
        <div id="map" style="height: 300px;" class="col-md-6 col-sm-6 col-xs-12">
            
        </div>
    </div>

    {{-- Buttons --}}
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success">Guardar</button>
            <button class="btn btn-warning" type="reset">Borrar</button>
        </div>
    </div>

    {{Form::close()}}
@endsection

@section('JS')
    <script>
        var lat = {{ $beefispot->lat }};
        var lng = {{ $beefispot->lng }};
    </script>

	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBck4M_9pXmACTkhXBrHg999fvnqbg4xEY&callback=initMap">
    </script>

    {{ Html::script('js/beefispot/edit.js') }}
@stop