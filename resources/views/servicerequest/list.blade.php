@extends('template')
@section('content')

@php
    $STATUS_IN_PROCESS = 1;   
    $statusList = ["%"=>"Todos","1"=>"En proceso","2"=>"Recibido","3"=>"Atendido","4"=>"Liberado","5"=>"Aprobado","6"=>"Cancelado"] ;
@endphp

<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
    <div class="table-responsive"  >   
        <form id="frmServiceRequest"  method ="GET" >
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-1"><label for="status">Estatus: </label> </div>
                <div class="col-sm-12 col-md-2">
                    <select id="status" name="status" >
                        @php 
                            $selectAlls = $status=="%"?" selected ": "";
                            $selectInProcess = $status==1?" selected ": "";
                            $selectReceived = $status==2?" selected ": "";
                            $selectAttended = $status==3?" selected ": ""; 
                            $selectReleased = $status==4?" selected ": "";
                            $selectApproved = $status==5?" selected ": "";
                            $selectCanceled = $status==6?" selected ": "";
                        @endphp
                        <option value="%" {{ $selectAlls }} >Todos</option>
                        <option value="1" {{ $selectInProcess }} >En proceso</option>
                        <option value="2" {{ $selectReceived }}>Recibido</option>
                        <option value="3" {{ $selectAttended }}>Atendido</option>
                        <option value="4" {{ $selectReleased }}>Liberado</option>
                        <option value="5" {{ $selectApproved }}>Aprobado</option>
                        <option value="6" {{ $selectCanceled }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-2"> <label for="initialdate" >Periodo de: </label> </div>
                <div class="col-sm-12 col-md-2">
                    <input type="date" required
                      name="initialdate" id="initialdate" value="{{ $initialdate }}" >
                </div>
                <div class="col-sm-12 col-md-1"> <label for="finaldate">Hasta: </label> </div>
                <div class="col-sm-12 col-md-2">
                    <input type="date" required
                    value="{{ old('finaldate') }}"
                    name="finaldate" id="finaldate" >
                </div>
                <div class="col-sm-12 col-md-2">
                    <button type="submit" 
                        class="submit" 
                        id="btnShow" 
                        name="btnShow" >Aplicar filtro
                    </button>      
                </div>      
            </div> 
          
        </form>

        @if(Session::has('error'))
            <div class="form-group mb-3 alert alert-danger" role="alert">
            {{ Session::get('error') }}
            </div>
        @endif

        <table id="tblList" class="table table-bordered border-dark caption-top">
            <caption>Resultado</caption>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Descripcion</th>
                    <th>Estatus {{$status}}</th>
                    @if ( $status == $STATUS_IN_PROCESS)
                        <th>Acción</th>
                    @endif
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicerequests as $servicerequest)
                    <tr>
                        <td>{{$servicerequest->folio}}</td>
                        <td>{{$servicerequest->daterequest}}</td>
                        <td>{{$servicerequest->description}}</td>
                        <td>{{ $statusList[$servicerequest->status] }}</td>
                        
                        @if ( $status == $STATUS_IN_PROCESS )
                            <td>
                                <form id="frmCancel_{{$servicerequest->servicerequest_id}}" action="{{ route('servicerequests.cancel') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="servicerequest_id" value="{{$servicerequest->servicerequest_id}}">
                                    <input type="hidden" name="folio" value="{{$servicerequest->folio}}">
                                </form>
                                <a 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Cancelar"
                                    data-bs-custom-class="color-tooltip"
                                    href="#" onclick="submitForm({{$servicerequest->servicerequest_id}})">
                                    <i class="fa-solid fa-ban fa-2xl"></i>
                                </a>
                                <hr>
                                <a 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Editar"
                                    data-bs-custom-class="color-tooltip"
                                    href="{{ route('servicerequests.edit',$servicerequest->servicerequest_id ) }}" >
                                    <i class="fa-solid fa-pencil fa-2xl"></i>
                                </a>
                                
                            </td>
                        @endif
                        <td>
                            <a 
                                data-bs-toggle="tooltip" 
                                    data-bs-placement="top"
                                    title="Vista previa"
                                    data-bs-custom-class="color-tooltip"
                                href="{{ route('servicerequests.preview',$servicerequest->servicerequest_id ) }}"  >
                                <i class="fa-regular fa-file-pdf fa-2xl"></i>
                            </a> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
 
        <div>
            {!! $servicerequests->links() !!}
        </div>

    </div>
</div>

<script>

    function submitForm($id){
        $("#frmCancel_"+$id).submit();
    }

    $(document).ready(function(){
        const date = new Date();
        const year = date.getFullYear();


        if ($("#initialdate").val()=="")
            $("#initialdate").val(`${year}-01-01`);
        
        if ($("#finaldate").val()=="")
            $("#finaldate").val(currentDate());
            
        $("#status").change(function (){
            $("#frmServiceRequest").attr('action', "/servicerequests");
            $("#frmServiceRequest").submit();
            
        });

        $("#frmServiceRequest").submit( function () {
            $("#tblList > tbody").html("");
        });
            

    });
</script>
@endsection

