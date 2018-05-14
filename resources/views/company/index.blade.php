@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Catálogo de Clientes
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Clientes
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/company/create')  }}" class="btn btn-primary">Nuevo Cliente</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
        <thead>
        <tr>
            <td>No.</td>
            <td>Cliente</td>
            <td>Imagen</td>
            <td>Logo blanco</td>
            <td>Correo electrónico</td>
            <td>Acciones</td>
        </tr>
        </thead>

        <tbody>
            @foreach($companies as $company)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$company->name}}</td>
                <td>
                    @if ($company->profile_picture != '' )
                        <img src="{{ url('/').'/storage/uploads/'.$company->profile_picture}}" style="max-width: 250px;" />
                    @endif
                </td>
                <td style="background: #000;">
                    @if ($company->white_picture != '' )
                        <img src="{{ url('/').'/storage/uploads/'.$company->white_picture}}" style="max-width: 250px;" />
                    @endif
                </td>
                <td>{{$company->user->email}}</td>
                <td>
                    <a href="{{url('dashboard/company/edit/'.base64_encode($company->id))}}" class="btn btn-warning">Editar</a>
                    <a href="{{url('dashboard/company/delete/'.base64_encode($company->id))}}" class="btn btn-danger btn-delete" data-name="{{$company->name}}">Borrar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

{{-- JS --}}
@section('JS')
    {{Html::script('js/company/index.js')}}
@endsection