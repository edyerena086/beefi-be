@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Editar Password
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Editar Password
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/network')  }}" class="btn btn-primary">Regresar</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    {{Form::open(['url' => 'dashboard/network/update/'.base64_encode($password->id), 'files' => true, 'class' => 'form-horizontal form-label-left'])}}

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Password: <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {{Form::text('password', $password->password, ['class' => 'form-control col-md-7 col-xs-12', 'required' => 'required'])}}
        </div>
    </div>

    {{-- Buttons --}}
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </div>

    {{Form::close()}}
@endsection

@section('JS')
    {{Html::script('js/network/create.js')}}
@stop