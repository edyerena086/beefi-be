@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Catálogo de Beespots
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Beespots
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/beefispot/create')  }}" class="btn btn-primary">Nuevo Beefispot</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
        <thead>
        <tr>
            <td>No.</td>
            <td>Nombre</td>
            <td>Descripción</td>
            <td>Acciones</td>
        </tr>
        </thead>

        <tbody>
            @foreach($beefispots as $beefispot)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$beefispot->title}}</td>
                <td>{{$beefispot->description}}</td>
                <td>
                    <a href="{{url('dashboard/beefispot/edit/'.base64_encode($beefispot->id))}}" class="btn btn-warning">Editar</a>
                    <a href="{{url('dashboard/beefispot/delete/'.base64_encode($beefispot->id))}}" class="btn btn-danger btn-delete" data-name="{{$beefispot->title}}">Borrar</a>
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