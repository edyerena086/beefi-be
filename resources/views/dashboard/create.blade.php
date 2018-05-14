@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Nueva Promoción
@endsection

{{-- CSS --}}
@section('CSS')
    {{Html::style('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css')}}
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Nueva Promoción
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/store', 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Tipo de promoción <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::select('tipoDePromocion', [1 => 'Url', 2 => 'Archivo'], null, ['placeholder' => 'Selecciona', 'class' => 'form-control col-md-7 col-xs-12']) }}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Empresa: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('empresa', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Título de Promoción <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('tituloDePromocion', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
            Descripción de la promoción <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::textarea('descripcion', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Fecha de término <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('fechaDeTermino', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required', 'id' => 'datepicker'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Url
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('url', null, ['class' => 'form-control col-md-7 col-xs-12'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Archivo
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::file('archivo', ['id' => 'archivo'])}}
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

{{-- JS --}}
@section('JS')
    {{Html::script('https://code.jquery.com/ui/1.12.1/jquery-ui.js')}}
    {{Html::script('js/promotion/create.js')}}
@endsection