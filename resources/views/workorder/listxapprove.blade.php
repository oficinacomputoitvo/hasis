@extends('template')
@section('content')
@php 
    $status = [1=>'En proceso',2=>'Recibido',3=>'Atendido',4=>'Liberado',5=>'Aprobado',6=>'cancelado'];
@endphp
<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
    <div class="table-responsive"  >   
        <table id="tblList" class="table table-bordered border-dark caption-top">
            <caption>Orden de mantenimento</caption>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha solicitud</th>
                    <th>Solicitante</th>
                    <th>Equipo</th>
                    <th>Fecha de realización</th>
                    <th>Actividades</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($executionofservices as $executionofservice)
                    <tr>
                        <td>{{$executionofservice->folio}}</td>
                        <td>{{Carbon\Carbon::parse($executionofservice->daterequest)->format('d-m-Y')}}</td>
                        <td>{{$executionofservice->requester}}</td>
                        <td>{{$executionofservice->hardware}}</td>
                        <td>{{Carbon\Carbon::parse($executionofservice->dateofservice)->format('d-m-Y')}}</td>
                        <td>{{$executionofservice->actions}}</td>
                        <td>{{$status[$executionofservice->status]}}</td>

                        <td>
                            <form action="{{ route('workorders.approve')}}" id="frmApprove_{{$executionofservice->executionofservice_id}}"
                            method="POST" > 
                                @csrf
                                <input type="hidden" name="executionofservice_id" value="{{$executionofservice->executionofservice_id}}"> 
                                <input type="hidden" name="servicerequest_id" value="{{$executionofservice->servicerequest_id}}"> 
                                <input type="hidden" name="rol_id" value="{{$rol}}"> 

                                <a href="#" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Aprobar"
                                    data-bs-custom-class="color-tooltip"
                                    onclick="submitFormApprove({{$executionofservice->executionofservice_id}})"
                                    > 
                                    <i class="fa-regular fa-circle-check fa-2xl"></i>
                                </a> 
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('workorders.preview')}}"  id="frmPreview_{{$executionofservice->executionofservice_id}}"
                            method="GET" > 
                                <input type="hidden" name="executionofservice_id" value="{{$executionofservice->executionofservice_id}}">              
                                <a href="#" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Vista previa"
                                    onclick="submitFormPreview({{$executionofservice->executionofservice_id}})"
                                    data-bs-custom-class="color-tooltip"
                                    > 
                                    <i class="fa-regular fa-file-pdf fa-2xl"></i>
                                </a> 
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            {!! $executionofservices->links() !!}
        </div>
    </div>
</div>

<script>
    function submitFormPreview(id){
        $("#frmPreview_" + id ).submit();
    }
    function submitFormApprove(id){
        $("#frmApprove_" + id ).submit();
    }
</script>
@endsection

