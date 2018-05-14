@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Catálogo de Promociones
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Promociones
@endsection

{{-- Top button --}}
@section('topButton')
    <a href="{{ url('dashboard/create')  }}" class="btn btn-primary">Nueva Promoción</a>
@endsection

{{-- Main Content --}}
@section('mainContent')
    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
        <thead>
        <tr>
            <td>No.</td>
            <td>Nombre</td>
            <td>Descripción</td>
            <td>Fecha de termino</td>
            <td>ID de Promoción</td>
            <td>Acciones</td>
        </tr>
        </thead>

        <tbody>
            @foreach($promotions as $promotion)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$promotion->name}}</td>
                <td>{{$promotion->description}}</td>
                <td>{{$promotion->end_date}}</td>
                <td>{{$promotion->extarnal_id}}</td>
                <td>
                    <a href="{{url('dashboard/edit/'.base64_encode($promotion->id))}}" class="btn btn-warning">Editar</a>
                    <a href="{{url('dashboard/delete/'.base64_encode($promotion->id))}}" class="btn btn-danger btn-delete" data-name="{{$promotion->name}}">Borrar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

{{-- JS --}}
@section('JS')
    {{Html::script('js/promotion/home.js')}}
@endsection