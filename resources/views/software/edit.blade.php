@extends('template')
@section('content')


<link href="{{ asset('css/registro.css') }}" rel="stylesheet">


        <div class="title">
		    <h2>Edición de software</h2>
		</div>

		<form action="{{ route('softwares.update',$software->software_id) }}"  method="POST" class="formulario" id="formulario">
				@csrf
                @method('PUT')

			<div>
				<label for="name" class="formulario__label">Software</label>
				<div class="formulario__grupo-input">
					<input type="text" maxlength="100" 
					class="formulario__input" value="{{$software->name}}"
					name="name" id="name" required>
				</div>
			</div>

			<div>
				<label for="version" class="formulario__label">Versión</label>
				<div class="formulario__grupo-input">
					<input type="text" maxlength="50"class="formulario__input" value="{{$software->version}}"
					name="version" id="version" >
				</div>
			</div>

			<div>
                <label for="licencetype_id" class="formulario__label">Tipo de licencia</label>
                <div>
                    <select id="licencetype_id" name="licencetype_id" class="formulario__input">
                        @foreach ($licencetypes as $licencetype)
                           @if($licencetype->licencetype_id == $software->licencetype_id )
                                <option selected value="{{$licencetype->licencetype_id}}">{{$licencetype->description}}</option>
                            @else
                               <option value="{{$licencetype->licencetype_id}}">{{$licencetype->description}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
			</div>


			<div>
				<label for="licence" class="formulario__label">Licencia</label>
				<div class="formulario__grupo-input">
					<input type="text"maxlength="20" 
					class="formulario__input" value="{{$software->licence}}"
					name="licence" id="licence" >
				</div>
			</div>	


			<div>
                <label for="classification_id" class="formulario__label" >Clasificación</label>
                <div>
                    <select id="classification_id" name="classification_id" class="formulario__input">
						@foreach ($classifications as $classification)
                            @if($classification->classification_id == $software->classification_id )
					            <option selected value="{{$classification->classification_id}}">{{$classification->description}}</option>
                            @else
                                <option value="{{$classification->classification_id}}">{{$classification->description}}</option>
                            @endif
                        @endforeach
					</select>
                </div>
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
