@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Nuevo Sponsor
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Nueva Notificación
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/push-notifications/specific')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/push-notifications/send-general', 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Titulo: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('titulo', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
            Mensaje: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::textarea('mensaje', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
            Genero: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="genero" class="form-control col-md-7 col-xs-12">
                <option value="1">Mujeres</option>
                <option value="1">Hombres</option>
            </select>
            {{--{{Form::textarea('mensaje', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}--}}
        </div>
    </div>

    {{--<div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Imagen
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::file('imagen', ['id' => 'imagen'])}}
        </div>
    </div>--}}

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
    {{Html::script('js/push/create.js')}}
@stop