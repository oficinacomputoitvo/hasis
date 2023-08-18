
@extends('template')
@section('content')

       

<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
    <div class="table-responsive"  >   


<table class="table table-sm table-bordered border-dark caption-top">
<caption>Lista de Hardware</caption>
    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numero de inventario</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Caracteristicas</th>
                        <th>Serie</th>
                        <th>Modelo</th>
                        <th>Imagen</th>
                        <th>Estatus</th>
                        <th>Observaciones</th>
                        <th>Editar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($hardwares as $hardware)
                        <tr>
                            <td>{{$hardware->hardware_id}}</td>
                            <td>{{$hardware->inventorynumber}}</td>
                            <td>{{$hardware->user}}</td>
                            <td>{{$hardware->category}}</td>
                            <td>{{$hardware->brand}}</td>
                            <td>{{$hardware->features}}</td>   
                            <td>{{$hardware->serial}}</td>
                            <td>{{$hardware->model}}</td>
                            <td><img src="/images/hardware/{{$hardware->image}}" width="50px" height="50px" ></td> 
                            <td>{{$hardware->status}}</td>
                            <td>{{$hardware->comments}}</td>                                            
                            <td>                                    
                                <a href="{{ route('hardwares.edit', $hardware->hardware_id)}}"><i class="fa-solid fa-pencil fa-2xl"></i></a>                           
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex">
                {!! $hardwares->links() !!}
            </div>

        </div>
    </div>


@endsection