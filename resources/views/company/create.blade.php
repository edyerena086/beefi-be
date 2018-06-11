@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Nuevo Cliente
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Nuevo Cliente
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/company')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/company/store', 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Nombre: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('nombre', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Logo
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::file('logo', ['id' => 'logo'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Logo Blanco
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::file('logoBlanco', ['id' => 'logoBlanco'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Correo electrónico: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('correoElectronico', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Password: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::password('password', ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Confirmación de password: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::password('password_confirmation', ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <h3>
        Atributos
    </h3>

    @foreach($categories->chunk(6) as $chunk)
        <div class="form-group">
            @foreach($chunk as $category)
                <div class="col-md-2">
                    <label for=""><input type="checkbox" name="categoria[]" value="{{$category->id}}">{{$category->name}}</label>
                </div>
            @endforeach
        </div>
    @endforeach

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
    {{Html::script('js/company/create.js')}}
@stop