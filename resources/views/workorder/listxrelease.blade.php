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
                            <form action="{{ route('workorders.release')}}" 
                            id="frmRelease_{{$executionofservice->executionofservice_id}}"
                            method="POST" > 
                                @csrf
                                <input type="hidden" name="executionofservice_id" value="{{$executionofservice->executionofservice_id}}"> 
                                <input type="hidden" name="servicerequest_id" value="{{$executionofservice->servicerequest_id}}"> 
                                <input type="hidden" name="rol_id" value="{{$rol}}"> 
                                <input type="hidden" name="rating" id="rating" value="5" >
                                <a href="#"  
                                    onclick="currentFormXReleaseId={{$executionofservice->executionofservice_id}}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#divRating"
                                    data-bs-placement="top"
                                    title="Liberar"
                                    data-bs-custom-class="color-tooltip">                                   
                                    <i class="fa-solid fa-file-signature fa-2xl"></i>
                                </a> 
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('workorders.preview')}}" id="frmPreview_{{$executionofservice->executionofservice_id}}"
                            method="GET" > 
                                <input type="hidden" name="executionofservice_id" value="{{$executionofservice->executionofservice_id}}">              
                                <a href="#"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Vista previa"
                                    data-bs-custom-class="color-tooltip"
                                    onclick="submitFormPreview({{$executionofservice->executionofservice_id}})"
                                    > 
                                    <i class="fa-regular fa-file-pdf fa-2xl"></i>
                                </> 
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
    <div class="modal fade" id="divRating" 
        data-bs-backdrop="static" data-bs-keyboard="false" 
        tabindex="-1" aria-labelledby="staticBackdropLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:300px">
            <div class="modal-content" style="align-items: center;">
                <div class="modal-header" style="width:100%;background-color:#1B396A; color:white;">
                    <h1 class="modal-title fs-5" id="labelRating">Valoración</h1>
                </div>
                <hr>
                <div class="modal-body" >
                    <i  data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Malo"
                        data-bs-custom-class="color-tooltip" 
                        class="fa-solid fa-star fa-2xl rating" 
                        style="color: #cccccc; cursor:pointer;">
                    </i>
                    <i  data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Regular"
                        data-bs-custom-class="color-tooltip" 
                        class="fa-solid fa-star fa-2xl rating" 
                        style="color: #cccccc; cursor:pointer;">
                    </i>    
                    <i  data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Bueno"
                        data-bs-custom-class="color-tooltip" 
                        class="fa-solid fa-star fa-2xl rating" 
                        style="color: #cccccc; cursor:pointer;">
                    </i>    
                    <i  data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Muy bueno"
                        data-bs-custom-class="color-tooltip" 
                        class="fa-solid fa-star fa-2xl rating" 
                        style="color: #cccccc; cursor:pointer;">
                    </i>   
                    <i  data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Excelente"
                        data-bs-custom-class="color-tooltip" 
                        class="fa-solid fa-star fa-2xl rating" 
                        style="color: #cccccc; cursor:pointer;">
                    </i>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSend" class="submit">Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentFormXReleaseId = 0;

    $(document).ready(function(){
        
        $(".rating").click(function(){
            const currentIndex = $(this).index();
            $("#rating").val(currentIndex + 1 );
            console.log("index: " +  currentIndex);
            const items = $(".rating");
            let i=0;
            for (let item of items) {
                if (i <= currentIndex ) {
                    console.log("amarillo");
                    $(item).css("color","#ffc107");
                } else {
                    console.log("gris");
                    $(item).css("color","#cccccc");
                }
                i++;
            }
        });
        
        $("#btnSend").click(function(){
            console.log("ID: " + currentFormXReleaseId);
            $("#frmRelease_" + currentFormXReleaseId ).submit();
        });


        

    });

    function submitFormPreview(id){
        $("#frmPreview_" + id ).submit();
    }

</script>
@endsection

