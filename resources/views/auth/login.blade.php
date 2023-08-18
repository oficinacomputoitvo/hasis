@extends('template')
@section('content')


<link href="{{ asset('css/registro.css') }}" rel="stylesheet">

<div class="d-flex align-items-left justify-content-center" >
     <div class="card  transparent-container"  >
            <div class="card-header text-center align-items-center justify-content-center" style="background:#1B396A; color: white">
                <strong>Iniciar Sesión</strong>
            </div>   
            <form method="POST" action="{{ route('login.custom') }}" > 
            @csrf
                <div class="card-body"  >
                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="email" class="form-label" >Email</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
                            <input 
                                class="form-control border border-primary"
                                type="email" placeholder="Email" id="email" 
                                autocomplete="on"
                                name="email" required
                                autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="password" >Contraseña</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
                            <input 
                                class="form-control border border-primary"
                                type="password" placeholder="Password" id="password" 
                                name="password" required>
                        </div>
                    </div>
                    <div class="row">
                        @if(Session::has('error'))
                            <div class="form-group mb-3 alert alert-danger" role="alert">
                                        {{ Session::get('error') }}
                            </div>
                        @endif
                        
                        <div class="form-group mb-3" style="align-text:left">
                            <a href="{{ route('registerrequests') }}">Registrarme</a>
                        </div>  
                    </div>                   
                </div>
                <div class="card-footer text-center align-items-center justify-content-center" >

                    <button type="submit" class="submit" >Acceder</button>
                </div>
            </form>
        </div>
</div>

@endsection
    