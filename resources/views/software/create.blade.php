@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">


        <div class="title">
		    <h2>Registro de software</h2>
		</div>

		<form action="{{ route('softwares.store') }}"  method="POST" class="formulario" id="formulario">
				@csrf

			<div>
				<label for="name" class="formulario__label">Software</label>
				<div class="formulario__grupo-input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
					title="Ingrese el nombre del programa, sistema, lenguaje de programación, etc.."
					data-bs-custom-class="color-tooltip">
					<input type="text" maxlength="100" 
					class="formulario__input" 
					name="name" id="name" value="{{ old('name') }}"  required>
				</div>
			</div>

			<div>
				<label for="version" class="formulario__label">Versión</label>
				<div class="formulario__grupo-input"
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
					title="En este espacio puede anotar la versión correspondiente al software"
					data-bs-custom-class="color-tooltip">
					<input type="text" maxlength="50"class="formulario__input" 
					name="version" id="version"  value="{{ old('version') }}">
				</div>
			</div>

			<div>
                <label for="licencetype_id" class="formulario__label">Tipo de licencia</label>
                <div>
                    <select id="licencetype_id" name="licencetype_id" class="formulario__input">
                        @foreach ($licencetypes as $licencetype)
                            <option value="{{$licencetype->licencetype_id}}">{{$licencetype->description}}</option>
                        @endforeach
                    </select>
                </div>
			</div>

			<div>
				<label for="licence" class="formulario__label">Licencia</label>
				<div class="formulario__grupo-input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
					title="En caso de desconocer la licencia, puede poner pendiente por asignar"
					data-bs-custom-class="color-tooltip">
					<input type="text"maxlength="30" 
					class="formulario__input" 
					name="licence" id="licence" value= "{{ old('licence') }}" >
				</div>
			</div>	

			<div>
                <label for="classification_id" class="formulario__label" >Clasificación</label>
                
                    <select id="classification_id" name="classification_id" class="formulario__input">
						@foreach ($classifications as $classification)
					    <option value="{{$classification->classification_id}}">{{$classification->description}}</option>
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
				<p class="formulario__mensaje-exito" id="formulario__mensaje-exito" >Formulario enviado exitosamente!</p>
			</div>
		</form>

@endsection