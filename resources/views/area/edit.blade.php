@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">


            <div class="title">
				<h2>Edición de Área</h2>
			</div>
		<form action="{{ route('areas.update',$area->area_id) }}" method="POST" class="formulario" id="formulario">
            @csrf
			@method('PUT')
			<input type="hidden" id="area_id" name="area_id" value="{{ $area->area_id }}"/>
			<!-- Grupo: Area -->
			<div>
				<label for="name" class="formulario__label">Area</label>
				<div>
					<input type="text" class="formulario__input" name="description" id="description" placeholder="Area" 
					maxlength="100" required  value = "{{ $area->description }}">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Nombre de áreas</p>
			</div>

			<!-- Grupo: Parents -->
            <div>
                <label for="combo" class="formulario__label">Pertenece a</label>
                  <div class="fomulario_grupo-input"></div>
				
						<select id="parent" name="parent" class="formulario__input">
							@foreach ($areas as $arealist)
								@if($arealist->area_id == $area->parent )
									<option selected value="{{$arealist->area_id}}">{{$arealist->description}}</option>
								@else 
									<option value="{{$arealist->area_id}}">{{$arealist->description}}</option>
								@endif
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
				<button type="submit" class="submit" >Actualizar</button>
				<p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
			</div>
            
		</form>


    
@endsection