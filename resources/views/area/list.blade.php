@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">

<div class="title">
    <h2>Lista de areas</h2>
</div>
    
<table class="table table-bordered  border-dark table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Area</th>
            <th>Depende de </th>
            <th>Acción </th>
        </tr>
    </thead>
    <tbody>
        @foreach($areas as $area)
            <tr>
                <td>{{$area->area_id}}</td>
                <td>{{$area->description}}</td>
                <td>{{$area->parent}}</td>
                <td><a href="{{ route('areas.edit', $area->area_id)}}"><i class="fa-solid fa-pencil fa-2xl"></i></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex">
    {!! $areas->links() !!}
</div>

@endsection