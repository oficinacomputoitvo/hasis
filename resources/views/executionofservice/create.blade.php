@extends('template')
@section('content')

<div class="vh-100 d-flex justify-content-center " style="width:100%; padding: 10px;" >
    <div class="table-responsive"  >   

	   <form action="{{ route('executionofservices.store') }}"  method="POST" id="formulario">
			@csrf
			<input type="hidden" name="executionofservice_id" value="0">
			<div>
				<table class="table caption-top" id="tblServicio" >
				<caption>Orden de trabajo de Mantenimiento</caption>
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Solicitante</th>
                         </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td><input type="radio" checked name="servicerequest_id" value="{{ $service->servicerequest_id}}">{{ $service->folio}} </td>
                                <td>{{  $service->daterequest }}</td>
                                <td>{{  $service->description }}</td>
                                <td>{{  $service->requester }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
			<div class="d-flex">
				{!! $services->links() !!}
			</div>			
			<hr>
  		    <div>
				<strong>Mantenimiento</strong> 
				<div>
				<label>
					<input type="radio" name="internalservice" value="1" checked>   Interno
				</label>
				<label>
					<input type="radio" name="internalservice" value="0">   Externo
				</label>
				</div>
			</div>

            <div>
                <label for="servicetype_id"><strong>Tipo de servicio: </strong></label>
                <div>
                    <select id="servicetype_id" name="servicetype_id" class="formulario__input">
                        @foreach ($servicesType as $serviceType)
                            <option value="{{$serviceType->servicetype_id}}">{{$serviceType->description}}</option>
                        @endforeach
                    </select>
                </div>
			</div>

			<div>
				<label for="assigned"><strong>Asignado a: </strong></label>
				<div>
					<select name="assigned" id="assigned">
						@foreach($users as $user) 
							<option value="{{ $user->email }}">{{ $user->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div>
				<label for="dateofservice" ><strong>Fecha de realización:</strong> </label>
				<div>
					<input type="date" required  onkeypress="return false"
					name="dateofservice" id="dateofservice" >
				</div>
			</div>			
			<div>
				<label for="actions"><strong>Trabajo realizado:</strong></label>
				<div >
					<textarea required	rows="5" style="width:100%"
					name="actions" id="actions"></textarea> 
				</div>
			</div>            
			<div>
				<label for="materialsused"><strong>Material Utilizado:</strong></label>
				<div>
					<textarea required	rows="5" style="width:100%"
					name="materialsused" id="materialsused"></textarea> 
				</div>
			</div>  
			@if($errors->any())
				@foreach ($errors->all() as $error)
				<div class="form-group mb-3 alert alert-danger" role="alert">
					{{ $error }}
				</div>
				@endforeach
			@endif	
			<div>
				<button type="submit" class="submit" >Registrar</button>
			</div>
		</form>
	</div>
</div>
<!-- <script src="{{ asset('js/requestservice.js')}}"></script> -->
@endsection