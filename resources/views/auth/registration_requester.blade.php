@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">
            <div class="title">
				<h2>Registro de usuario</h2>
			</div>
		<form action="{{ route('register.custom') }}" method="POST" class="formulario" id="formulario">
            @csrf

			<!-- Grupo: Correo Electronico -->
			<div class="formulario__grupo" id="grupo__email">
				<label for="email" class="formulario__label">Email</label>
				<div class="formulario__grupo-input">
					<input type="email" class="formulario__input" name="email" id="email" 
					autocomplete="on"
					placeholder="correo@correo.com" autofocus required>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">El correo solo puede contener letras, numeros, puntos, guiones y guion bajo.</p>
			</div>

			<!-- Grupo: Nombre -->
			<div class="formulario__grupo" id="grupo__name">
				<label for="name" class="formulario__label">Nombre Completo</label>
				<div class="formulario__grupo-input">
					<input type="text" class="formulario__input" 
					autocomplete="on"
					name="name" id="name" placeholder="Nombre Apellidos" 
					maxlength="100" required >
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Solo se permite formato de nombre de personas</p>
			</div>

			<!-- Grupo: Contraseña -->
			
			<div class="formulario__grupo" id="grupo__password">
				<label for="password" class="formulario__label">Contraseña</label>
				<div class="formulario__grupo-input">
					<input type="password" class="formulario__input" name="password" id="password" required>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">La contraseña tiene que ser de 6 a 12 dígitos.</p>
			</div>

			<!-- Grupo: Contraseña 2 -->
			<div class="formulario__grupo" id="grupo__password_confirmacion">
				<label for="password_confirmacion" class="formulario__label">Repetir Contraseña</label>
				<div class="formulario__grupo-input">
					<input type="password" class="formulario__input" name="password_confirmacion" 
					id="password_confirmacion" required>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">Ambas contraseñas deben ser iguales.</p>
			</div>

			<!-- Grupo: Rol -->
			<div>
                <label for="rol_id" class="formulario__label">Rol</label>
                <div class="formulario__grupo-input"></div>
                 <select id="rol_id" name="rol_id" class="formulario__input">
                    <option value="3" selected>Solicitante</option>
               </select>
               </div>

			<!-- Grupo: Boton -->

			<div class="formulario__mensaje" id="formulario__mensaje">
				<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
			</div>

			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<button type="submit" class="submit" >Registrar</button>
				<p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
			</div>
            
		</form>

	<script src="{{ asset('js/formulario.js') }}"></script>

    
@endsection