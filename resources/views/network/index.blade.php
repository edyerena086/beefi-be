@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Catálogo de contraseñas
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de contraseñas
@endsection

{{-- Main Content --}}
@section('mainContent')
    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
        <thead>
        <tr>
            <td>No.</td>
            <td>Fecha de Actualización</td>
            <td>Password</td>
            <td>Acciones</td>
        </tr>
        </thead>

        <tbody>
            @foreach($passwords as $password)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$password->updated_at}}</td>
                <td>{{$password->password}}</td>
                <td>
                    <a href="{{url('dashboard/network/edit/'.base64_encode($password->id))}}" class="btn btn-warning">Editar</a>
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