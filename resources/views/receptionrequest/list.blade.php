@extends('template')
@section('content')

<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
     <div class="table-responsive">   
        <input type="hidden" id="email" name="email" value="{{ $email }}">
        <table id="tblServiceRequest" class="table table-bordered border-dark caption-top">
            <caption>Solicitudes pendientes</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Problema</th>
                    <th>Fecha probable de atención</th>
                    <th>Observaciones</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicerequests as $servicerequest)
                    <tr>
                        <td>{{$servicerequest->servicerequest_id}}</td>
                        <td>{{$servicerequest->folio}}</td>
                        <td>{{$servicerequest->daterequest}}</td>
                        <td>{{$servicerequest->username}}</td>
                        <td>{{$servicerequest->description}}</td>
                        <td>
                            <input class="probabledateexecution" onkeypress="return false" type="date" name="fecha" value="{{ $today }}">
                        </td>
                        <td>
                            <textarea class ="comment" name="observaciones" rows="5" placeholder="Indique alguna observacion"></textarea> 
                        </td>  
                        <td>
                            <button type="button" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="left"
                                title="Confirmar de recibido"
                                data-bs-custom-class="color-tooltip"
                                class="btn btnSave">
                                <i class="fa-solid fa-floppy-disk fa-2xl "></i>
                            </button>

                        </td>                      
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $servicerequests->links() !!}
        </div>
    </div>
</div>
<script src="{{ asset('js/receptionrequest.js')}}"></script>
@endsection