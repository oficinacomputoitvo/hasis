@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">


    <div class="title">
		<h2>Registro de Área</h2>
	</div>
		
	
	    <form action="{{ route('areas.store') }}" method="POST" class="formulario" id="formulario">
        @csrf

			
			<!-- Grupo: Area -->
			<div>
				<label for="name" class="formulario__label">Area</label>
				<div>
					<input type="text" class="formulario__input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Se refierere a los departamentos y oficinas del Instituto por ejemplo cubiculo numero 6, Posta,"
					data-bs-custom-class="color-tooltip"
					name="description" id="description" placeholder="Area" 
					maxlength="100" required >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Nombre de áreas</p>
			</div>

			<!-- Grupo: Parents -->
            <div>
                <label for="combo" class="formulario__label">Pertenece a</label>
                  <div class="fomulario_grupo-input"></div>
				
					<select id="parent" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Se debe seleccionar la administracion al que pertenece el area, cubiculo o departamento del campo anterior "
					data-bs-custom-class="color-tooltip"
					name="parent" class="formulario__input">
						@foreach ($areas as $area)
							<option value="{{$area->area_id}}">{{$area->description}}</option>
						@endforeach
					</select>
            </div>


			@if(Session::has('error'))
				<div class="form-group mb-3 alert alert-danger" role="alert">
					{{ Session::get('error') }}
				</div>
			@endif
			@if(Session::has('success'))
				<div class="alert alert-success" role="alert">
					{{ Session::get('success') }}
				</div>
			@endif
			@if($errors->any())
				@foreach ($errors->all() as $error)
				<div class="form-group mb-3 alert alert-danger" role="alert">
					{{ $error }}
				</div>
				@endforeach
			@endif

			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<button type="submit" class="submit" >Registrar</button>
				<p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
			</div>
            
		</form>


    
@endsection