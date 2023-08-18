@extends('template')
@section('content')
@php 
    $status = [1=>'En proceso',2=>'Recibido',3=>'Atendido',4=>'Liberado',5=>'Aprobado',6=>'cancelado'];
@endphp
<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
    <div class="table-responsive"  >   
        <table id="tblList" class="table table-bordered border-dark caption-top">
            <caption>Estado de órdenes de mantenimiento</caption>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha solicitud</th>
                    <th>Solicitante</th>
                    <th>Fecha de realización</th>
                    <th>Actividades</th>
                    <th>Estatus</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($executionOfServices as $executionOfService)
                    <tr>
                        <td>{{$executionOfService->folio}}</td>
                        <td>{{Carbon\Carbon::parse($executionOfService->daterequest)->format('d-m-Y')}}</td>
                        <td>{{$executionOfService->requester}}</td>
                        <td>{{Carbon\Carbon::parse($executionOfService->dateofservice)->format('d-m-Y')}}</td>
                        <td>{{$executionOfService->actions}}</td>
                        <td>{{$status[$executionOfService->status]}}</td>
                        <td>
                            <form action="{{ route('workorders.preview')}}" 
                            id="frm_{{$executionOfService->executionofservice_id}}"
                            method="GET" > 
                                <input type="hidden" name="executionofservice_id" value="{{$executionOfService->executionofservice_id}}">              
                                <a href="#" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Vista previa"
                                    data-bs-custom-class="color-tooltip"
                                    onclick="submitForm({{$executionOfService->executionofservice_id}})"><i class="fa-regular fa-file-pdf fa-2xl"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            {!! $executionOfServices->links() !!}
        </div>
    </div>
</div>

<script>
    function submitForm($id){
        $("#frm_" + $id).submit();
    }

</script>
@endsection

