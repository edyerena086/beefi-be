@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Notiicaciones Push
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Notificaciones Push
@endsection

{{-- Top button --}}
@section('topButton')
    @if($counter < 1)
        <a href="{{ url('dashboard/push-notifications/create')  }}" class="btn btn-primary">Nueva notificación</a>
    @endif
@endsection

{{-- Main Content --}}
@section('mainContent')
    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
        <thead>
        <tr>
            <td>No.</td>
            <td>Título</td>
            <td>Mensaje</td>
            <td>Tipo</td>
            <td>Acciones</td>
        </tr>
        </thead>

        <tbody>
            @foreach($pushes as $push)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$push->title}}</td>
                <td>{{ $push->message }}</td>
                <td>@if ($push->status == 1) Enviado @else No enviado @endif</td>
                <td>
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