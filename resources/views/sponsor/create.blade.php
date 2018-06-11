@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Nuevo Sponsor
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Nuevo Sponsor
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/sponsor')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/sponsor/store', 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Empresa: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('empresa', null, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Imagen
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::file('imagen', ['id' => 'imagen'])}}
        </div>
    </div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Tipo de sponsor
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="tipo" id="" class="form-control">
                <option value="0">Seleccionar</option>
                <option value="1">Por categorias</option>
                <option value="2">Por establecimiento</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="atributos">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Atributos
        </label>

        <div class="col-md-6">
            @foreach($categories->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk as $category)
                        <div class="col-sm-4">
                            <label for="" id="lblCat"><input type="checkbox" name="categoria[]" value="{{$category->id}}">{{$category->name}}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    

    <div class="form-group" id="empresas">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
            Empresas para el sponsor
        </label>

        <div class="col-md-6">
            @foreach($companies->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk as $company)
                        <div class="col-sm-4">
                            <label for="" id="lblCompa"><input type="checkbox" name="compania[]" value="{{$company->id}}">{{$company->name}}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
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