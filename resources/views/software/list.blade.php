@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">

<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
    <div class="table-responsive"  >   


<table class="table table-sm table-bordered  border-dark caption-top">
    <caption>Listado de software</caption>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Clasificación</th>            
            <th>Tipo de licencia</th>
            <th>Licencia</th>
            <th>Versión</th>            
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($softwares as $software)
            <tr>
                <td>{{$software->software_id}}</td>
                <td>{{$software->name}}</td>
                <td>{{$software->classification}}</td>
                <td>{{$software->licencetype}}</td>
                <td>{{$software->licence}}</td>
                <td>{{$software->version}}</td>
                <td>
                    <a href="{{ route('softwares.edit', $software->software_id)}}">
                    <i class="fa-solid fa-pencil fa-2xl"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex">
    {!! $softwares->links() !!}
</div>
</div>
</div>
@endsection