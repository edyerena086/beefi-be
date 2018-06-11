@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Catálogo de Sponsor
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Sponsor
@endsection

{{-- Top button --}}
@section('topButton')
        <a href="{{ url('dashboard/sponsor/create')  }}" class="btn btn-primary">Nuevo Sponsor</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
        <thead>
        <tr>
            <td>No.</td>
            <td>Empresa</td>
            <td>Imagen</td>
            <td>Acciones</td>
        </tr>
        </thead>

        <tbody>
            @foreach($sponsors as $sponsor)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$sponsor->company_name}}</td>
                <td><img src="{{ url('/').'/storage/uploads/'.$sponsor->sponsor_ad}}" style="max-width: 250px;" /></td>
                <td>
                    {{--<a href="{{url('dashboard/sponsor/edit/'.base64_encode($sponsor->id))}}" class="btn btn-warning">Editar</a>--}}
                    <a href="{{url('dashboard/sponsor/delete/'.base64_encode($sponsor->id))}}" class="btn btn-danger btn-delete" data-name="{{$sponsor->title}}">Borrar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

{{-- JS --}}
@section('JS')
    {{Html::script('js/beefispot/index.js')}}
@endsection