@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">

            <div class="title">
				<h2>Registro de Hardware</h2>
			</div>
            
		<form action="{{ route('hardwares.store') }}" method="POST" enctype="multipart/form-data" 
			class="formulario" id="formulario" onsubmit="return validate()">
            @csrf
			<input type="hidden" value="0" name="hardware_id">
			<!-- Grupo: Combo Categoria-->

			<div>
                <label for="category_id" class="formulario_label">Categoria</label>
                <div class="formulario_grupo-input">
					<select id="category_id" 
						data-bs-toggle="tooltip" 
						data-bs-placement="top"
						title="Si no hay algun elemento en la lista. Puede agregarla desde el menú principal."
						data-bs-custom-class="color-tooltip"
						name="category_id" value="{{ old('category_id') }}" 
						class="formulario__input">
						@foreach ($categorys as $category)
							@if( $category->category_id == old('category_id') )
								<option selected value="{{$category->category_id}}">{{$category->description}}</option>
							@else
								<option value="{{$category->category_id}}">{{$category->description}}</option>
							@endif
						@endforeach
					</select>
               
             	</div>
			</div>
			<!-- Grupo: Numero de Inventario -->
			<div>
				<label for="inventorynumber" class="formulario__label">Numero de Inventario</label>
				<div>
					<input type="text" class="formulario__input" 
					name="inventorynumber" id="inventorynumber" placeholder="01" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="El numero de inventario es una serie de letras y numeros. Es un dato asignado por el almacen"
					data-bs-custom-class="color-tooltip"
					required
					maxlength="30" value="{{ old('inventorynumber') }}" >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Número de inventario</p>
			</div>

           <!-- Grupo: Características -->
			<div>
				<label for="features" class="formulario__label">Características</label>
				<div>
					<textarea style="width:80%" 
					name="features" id="features" placeholder="Características"
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Puede anotar el color, el tamaño, la resolución entre otros datos"
					data-bs-custom-class="color-tooltip"
					rows="3"
					maxlength="100">{{ old('features') }}</textarea>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Características</p>
			</div>

            <!-- Grupo: Serie -->
			<div>
				<label for="serial" class="formulario__label">Serie</label>
				<div>
					<input type="text" class="formulario__input" 
					name="serial" id="serial" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="En este espacio puede anotar el numero de serie o el id del producto "
					data-bs-custom-class="color-tooltip"
					placeholder="" 
					maxlength="20" value="{{ old('serial') }}">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Serie</p>
			</div>

            <!-- Grupo: Modelo -->
			<div>
				<label for="model" class="formulario__label">Modelo</label>
				<div>
					<input type="text" class="formulario__input" name="model" id="model"
					placeholder="Ejemplo: Anyware" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Generalmente está compuesto de numeros, letras y guion "
					data-bs-custom-class="color-tooltip"
					maxlength="20" value="{{ old('model') }}">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Modelo</p>
			</div>

            <!-- Grupo: Imagen -->
			<div>
				<label for="image" class="formulario__label">Imagen</label>
				<div>
					<input type="file" class="formulario__input_file"  id="image" accept="image/png, image/jpeg" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Imagen del dispositivo, puede tomar una foto guardarlo en la computadora y luego subirla en este apartado "
					data-bs-custom-class="color-tooltip"
					class="form-control" name="image" 
					onchange="preview(event,'divPreview');">
				  	<div id="divPreview"></div>
                
				</div>
			</div>


            
            <!-- Grupo: Comentario -->
			<div>
				<label for="comments" class="formulario__label">Observaciones</label>
				<div>
					<textarea style="width:80%" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Puede indicar por ejemplo: está rota la pantalla, la bisagra o se calienta el procesador "
					data-bs-custom-class="color-tooltip"
					name="comments" id="comments" 
					placeholder="Comentario" 
					rows="3"
					maxlength="100">{{ old('comments') }}</textarea>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Comentario</p>
			</div>
            

             

             <!-- Grupo: Combo Marca -->
             <div>
                <label for="brand_id" class="formulario_label">Marca</label>
                <div class="formulario_grupo-input"></div>
                <select id="brand_id" name="brand_id" value="{{ old('brand_id') }}" class="formulario__input">
					@foreach ($brands as $brand)
						@if($brand->brand_id==old('brand_id'))
							<option selected value="{{$brand->brand_id}}">{{$brand->description}}</option>
						@else 
							<option value="{{$brand->brand_id}}">{{$brand->description}}</option>
						@endif 
				    @endforeach
 
                </select>
             </div>

			 <!-- area de ubicación -->
			<div>
                <label for="area_id" class="formulario_label">¿En qué área se encuentra?</label>
                <div class="formulario_grupo-input"></div>
                <select id="area_id" name="area_id" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Si no está asignada a ninguna área elija Ninguno"
					data-bs-custom-class="color-tooltip"
					value="{{ old('area_id') }}" class="formulario__input">
					@foreach ($areas as $area)
						@if($area->area_id==old('area_id'))
							<option selected value="{{$area->area_id}}">{{$area->description}}</option>
						@else 
							<option value="{{$area->area_id}}">{{$area->description}}</option>
						@endif 
				    @endforeach

                </select>
            </div>		

			 <!-- Usuario que lo tiene asignado -->
			 <div>
                <label for="email" class="formulario_label">¿Quien lo tiene asignado?</label>
                <div class="formulario_grupo-input"></div>
                <select id="email" name="email" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Si no está asignada a ninguna persona elija pendiente por asignar"
					data-bs-custom-class="color-tooltip"				
					value="{{ old('email') }}" class="formulario__input">
					@foreach ($users as $user)
						@if($user->email==old('email'))	
							<option selected value="{{$user->email}}">{{$user->name}}</option>
						@else 
							<option  value="{{$user->email}}">{{$user->name}}</option>
						@endif 

				    @endforeach
                </select>
            </div>		
			
			
           <!-- Grupo: Combo Estatus-->
            <div>
                <label for="status_id" class="formulario_label">Estatus</label>
                <div class="formulario_grupo-input"></div>
                <select id="status_id" name="status_id" value="{{ old('status_id') }}" class="formulario__input">
					@foreach ($statuses as $status)
						@if($status->status_id==old('status_id'))	
							<option selected value="{{$status->status_id}}">{{$status->description}}</option>
						@else 
							<option  value="{{$status->status_id}}">{{$status->description}}</option>
						@endif
				    @endforeach

                </select>
            </div>

			<!-- Tabla computadora-->
			<!-- Grupo: Ram -->
			<div id="divIdentifier">
				<label for="identifier" id="lblRam" class="formulario__label">Identificador </label>
				<div>
					<input type="text" class="formulario__input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Es un dato asociado al equipo por ejemplo: PC_01, MAC_01, etc."
					data-bs-custom-class="color-tooltip"					
					name="identifier" value="{{ old('identifier') }}" 
					id="identifier" placeholder="PC 01" maxlength="20"  >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Identificador</p>
			</div>			

			<!-- Grupo: Ram -->
			<div id="divRam">
				<label for="ram" id="lblRam" class="formulario__label">Ram</label>
				<div>
					<input type="text" class="formulario__input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Generalmente esta expresada en KB, MB o GB. Ejemplo: 8 GB, 16 BG, 32 GB"
					data-bs-custom-class="color-tooltip"	
					name="ram" value="{{ old('ram') }}" id="ram" placeholder="16 GB"  
					maxlength="50"  >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Ram</p>
			</div>

           <!-- Grupo: Useros -->
			<div id="divUserOs">
				<label for="useros" class="formulario__label">Usuario del sistema operativo</label>
				<div>
					<input type="text" class="formulario__input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Es el usuario del sistema operativo: Por ejemplo: Admin, user_01, guest_01, etc."
					data-bs-custom-class="color-tooltip"					
					name="useros" value="{{ old('useros') }}" 
					id="useros" placeholder="pc_01" maxlength="50" >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Usuario del sistema operativo</p>
			</div>
			<!-- Grupo: harddisk -->
			<div id="divHarddisk">
				<label for="harddisk" class="formulario__label">Almacenamiento</label>
				<div>
					<input type="text" 
					class="formulario__input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Puede anotar marca, tecnología o tipo y capacidad del medio de almacenamiento"
					data-bs-custom-class="color-tooltip"					
					name="harddisk" value="{{ old('harddisk') }}" 
					id="harddisk" placeholder="1 TB" maxlength="100"  >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Almacenamiento</p>
			</div>

			<!-- Grupo: Processor -->
			<div id="divProcessor">
				<label for="processor" class="formulario__label">Procesador</label>
				<div>
					<input type="text" class="formulario__input" 
					data-bs-toggle="tooltip" 
					data-bs-placement="top"
   					title="Puede anotar la marca, generación  y la velocidad del procesador"
					data-bs-custom-class="color-tooltip"					
					name="processor" value="{{ old('processor') }}" id="processor"
					placeholder="Intel Core I9" 
					maxlength="50" >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Procesador</p>
			</div>

			
			@php
				if (old('software'))
					$softwareSelected = old('software'); 
				else
					$softwareSelected = [];
				
			@endphp

			<div id="divSoftware"  class="multiselect">
				
				@foreach ($softwares as $software)
					{{ $checked =" " }}
					@if(in_array($software->software_id, $softwareSelected))	
						{{ $checked =" checked " }}
					@endif
					<label> <input type="checkbox" {{ $checked }} name="software[]" 
						value="{{$software->software_id}}" >  {{ $software->name }} {{ $software->version }} 
					</label> 
				@endforeach

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

            <!-- Grupo: Botón-->

			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<button type="submit" class="submit" >Registrar</button>
				<p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
			</div>

            
		</form>

	<script>
		const MAX_IDS_THE_HARDWARE_WITH_SO = 10;

		function showHardwareWithSO(){
			$("#divIdentifier").show();
			$("#divRam").show();
			$("#divUserOs").show();
			$("#divHarddisk").show();
			$("#divProcessor").show();
			$("#divSoftware").show();
		}

		function hideHardwareWithSO(){
			$("#divIdentifier").hide();
			$("#divRam").hide();
			$("#divUserOs").hide();
			$("#divHarddisk").hide();
			$("#divProcessor").hide();
			$("#divSoftware").hide();
		}

		$(document).ready( function(){       	

			showHide();

			function showHide(){
				
				const category_id = $("#category_id").val();
			
				if (category_id<=MAX_IDS_THE_HARDWARE_WITH_SO){
					showHardwareWithSO();

				} else {
					hideHardwareWithSO();
				}	

			}

			$("#category_id").change(function (){
				showHide();
			});
		});

		function validate(){
			if ($("#category_id").val()==0){
				alert("Es necesario seleccionar una categoria");
				return false;
			} else if ($("#category_id").val()<=MAX_IDS_THE_HARDWARE_WITH_SO){
				//--- validar los otros campos
				return validateHardwareWithSO();
			}
			return true;
		}


		function validateHardwareWithSO(){
			const elementsToValidate= JSON.parse('[ ' + 
				' {"id":"ram","message":"Es necesario indicar la memoria RAM"}, ' + 
				' {"id":"harddisk","message":"Es necesario indicar la capacidad del Disco Duro"}, ' +
				' {"id":"processor","message":"Es necesario indicar la capacidad  del procesador"},' + 
				' {"id":"useros","message":"Es necesario indicar el usuario del sistema operativo"}]');
			elementsToValidate.every(item=>{
				if ($("#" + item.id).val()==""){
					alert ( item.message);
					return false;
				}
			});
			if (softwaresSelected()<1 ){
				alert("Es necesario seleccionar al menos un software");
				return false;
			}

			return true;
		}

		function softwaresSelected(){
			const software =  $('[name="software[]"]'); 
			let itemsSelected = 0;
			for (let index = 0; index < software.length; index ++){
				if (software[index].checked){
					console.log(`index: ${index}, value: ${software[index]} ` );
					itemsSelected ++;
				}
					
			}
            return itemsSelected;
		}
	</script>
		
@endsection