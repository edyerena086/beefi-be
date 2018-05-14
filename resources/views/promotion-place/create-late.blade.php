@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Nueva Promoción Tardía
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Nueva Promoción Tardía
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/promotion-place/late')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/promotion-place/late/store', 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Empresa: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('empresa', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    {{--<div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
            Descripción: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::textarea('descripcion', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>--}}

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Imagen
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::file('imagen', ['id' => 'imagen'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Url: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('url', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
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
    {{Html::script('js/sponsor/create.js')}}
@stop