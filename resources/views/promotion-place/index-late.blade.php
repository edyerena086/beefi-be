@extends('layouts.dashboard')

{{-- Page Title --}}
@section('pageTitle')
    Catálogo de Promociones
@endsection

{{-- Content Title --}}
@section('contentTitle')
    Catálogo de Promociones Posterior
@endsection

{{-- Top button --}}
@section('topButton')
    @if($counter < 1)
        <a href="{{ url('dashboard/promotion-place/late/create')  }}" class="btn btn-primary">Nueva Promoción Posterior</a>
    @endif
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
            @foreach($promotions as $promotion)
            <tr>
                <td>{{$centinel++}}</td>
                <td>{{$promotion->company_name}}</td>
                <td><img src="{{ url('/').'/storage/uploads/'.$promotion->promotion}}" style="max-width: 250px;" /></td>
                <td>
                    {{--<a href="{{url('dashboard/spromotionedit/'.base64_encode($promotion->id))}}" class="btn btn-warning">Editar</a>--}}
                    <a href="{{url('dashboard/promotion-place/late/delete/'.base64_encode($promotion->id))}}" class="btn btn-danger btn-delete" data-name="{{$promotion->title}}">Borrar</a>
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