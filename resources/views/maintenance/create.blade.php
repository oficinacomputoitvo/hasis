@extends('template')
@section('content')

<style>
    .maintenance-data {
        width: 60px;
    }
</style>

<div class="vh-100 d-flex justify-content-center " style="width:100%; padding: 10px;" >
    <div class="table-responsive"  >   

		<form action="{{ route('maintenances.preview') }}" method="POST"
             enctype="multipart/form-data"  id="frmMaintenance" >
             @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="schoolcycle" class="formulario__label">Ciclo escolar:</label>
                    <div class="formulario__grupo-input"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Generalmente se indica por año. Por ejemplo: Enero-Diciembre-2023"
                        data-bs-custom-class="color-tooltip">
                        <input type="text" maxlength="50" 
                        class="formulario__input" 
                        name="schoolcycle" id="schoolcycle" value="{{$schoolcycle}}"  >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="year" class="formulario__label">Año:</label>
                    <div class="formulario__grupo-input"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Año de cuatro digitos: Por ejemplo: 2023"
                        data-bs-custom-class="color-tooltip">
                        <input type="text" maxlength="4" 
                        class="formulario__input" 
                        name="year" id="year" value="{{ $year }}" >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="formulario__grupo-input">
                        <button 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top"
                            title="Crear nuevo documento de matenimiento preventivo"
                            data-bs-custom-class="color-tooltip"                        
                            type="button" class="submit" 
                            name="saveSchedule" id="saveSchedule" >
                            Crear
                        </button>
                       
                    </div>
                </div>
                
			</div>
            <input type="hidden" id="maintenanceschedule_id" name="maintenanceschedule_id" value="{{ $id }}">
            <br>
            <div>
                <table id="tblMaintenance" class="table table-bordered border-dark caption-top" >
                    <caption>Mantenimiento</caption>
                        <thead>
                            <tr>
                                <th style="display:none;"></th></th><th>NO.</th> <th>SERVICIO</th> <th>TIPO</th>  <th>TIEMPO</th> 
                                <th>ENE</th> <th>FEB</th> <th>MAR</th> <th>ABR</th> <th>MAY</th> <th>JUN</th>
                                <th>JUL</th> <th>AGO</th> <th>SEP</th> <th>OCT</th> <th>NOV</th> <th>DIC</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                </table>
                <a href="#" 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"
                    title="Agregar servicios"
                    data-bs-custom-class="color-tooltip"
                    id="addRow" ><i class="fa-solid fa-file-circle-plus fa-2xl"></i></a>
                <hr>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="dateofpreparation" class="formulario__label">Fecha de elaboración:</label>
                    <div class="formulario__grupo-input"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="En formato dia/mes/año: 30/03/2023"
                        data-bs-custom-class="color-tooltip">
                        <input type="date" maxlength="10"  onkeypress="return false"
                        class="formulario__input" 
                        name="dateofpreparation" id="dateofpreparation" value="{{ old('dateofpreparation') }}"  >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="whoelaborated" class="formulario__label">Elaboró:</label>
                    <div class="formulario__grupo-input">
                        <select name="whoelaborated" id="whoelaborated" 
                            value="{{ old('whoelaborated') }}"  class="formulario__input"  >
                            @foreach ($users as $user)
                                <option value="{{$user->email}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
			</div>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="dateofapproval" class="formulario__label">Fecha de aprobación:</label>
                    <div class="formulario__grupo-input"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="En formato dia/mes/año: 30/03/2023"
                        data-bs-custom-class="color-tooltip">
                        <input type="date" maxlength="10" onkeypress="return false"
                        class="formulario__input" 
                        name="dateofapproval" id="dateofapproval" value="{{ old('dateofapproval') }}"  >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="whoautorized" class="formulario__label">Aprobó:</label>
                    <div class="formulario__grupo-input"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Nombre de la persona que autorizó el documento"
                        data-bs-custom-class="color-tooltip">
                        <input type="text" maxlength="50" 
                        class="formulario__input" 
                        name="whoautorized" id="whoautorized" value="{{ old('whoautorized') }}" >
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <button type="submit" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"
                        title="Vista previa del documento"
                        data-bs-custom-class="color-tooltip"
                        id="btnPreview" 
                        class="submit" >Vista previa 
                    </button> 

                </div>
			</div>
            
		</form>
    </div>
</div>

	<script>

        $(document).ready(function(){

            $("#dateofpreparation").val(currentDate());
            $("#addRow").hide();
            if ($("#schoolcycle").val().trim().length>0){
                $("#saveSchedule").click();
            }

        });
        

	</script>
    <script src="{{ asset('js/maintenance.js')}}"></script>
@endsection