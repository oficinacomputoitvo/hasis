@extends('template')
@section('content')


<div class="vh-100 d-flex justify-content-center" style="width:100%; padding: 10px;">
    <div class="table-responsive"  >   
        <table class="table table-bordered border-dark caption-top">
            <caption>Mantenimiento</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ciclo escolar</th>
                    <th>Año</th>
                    <th>Elaboró</th>
                    <th>Fecha Elaboración</th>
                    <th>Autorizó</th>
                    <th>Fecha autorización</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenances as $maintenance)
                <tr>
                    <td>{{$maintenance->maintenanceschedule_id}}</td>
                    <td>{{$maintenance->schoolcycle}}</td>
                    <td>{{$maintenance->year}}</td>
                    <td>{{$maintenance->whoelaborated}}</td>
                    <td>{{$maintenance->dateofpreparation}}</td>
                    <td>{{$maintenance->whoautorized}}</td>
                    <td>{{$maintenance->dateofapproval}}</td>
                    <td>
                        <form action="{{ route('maintenances.create') }}" 
                            id="frmMaintenance_{{$maintenance->maintenanceschedule_id}}"
                            method="GET" >
                            <input type="hidden" name="maintenanceschedule_id" 
                            value="{{$maintenance->maintenanceschedule_id}}">
                            <a href="#" onclick="submitForm({{$maintenance->maintenanceschedule_id}})">
                                <i class="fa-solid fa-pencil fa-2xl"></i>
                            </a>

                        </form>
                        <hr>
                        <form action="{{ route('maintenances.preview') }}" 
                            id="frmPreview_{{$maintenance->maintenanceschedule_id}}"
                            method="POST" >
                            @csrf
                            <input type="hidden" name="maintenanceschedule_id" 
                            value="{{$maintenance->maintenanceschedule_id}}">

                            <a href="#" onclick="submitFormPreview({{$maintenance->maintenanceschedule_id}})">
                                <i class="fa-regular fa-file-pdf fa-2xl"></i>
                            </a>                            

                        </form>
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $maintenances->links() !!}
        </div>
    </div>
</div>

<script>
    function submitForm($id){
        $("#frmMaintenance_" + $id).submit();
    }
    function submitFormPreview($id){
        $("#frmPreview_" + $id).submit();
    }
</script>
@endsection