@extends('template')
@section('content')

<div class="d-flex text-center align-items-center justify-content-center" >

  
    @if ( Session::get('rol') != App\Enums\RolEnum::REQUESTER->value)
        <div class="card" style="max-width: 18rem;">
            <div class="card-header" style="background:#1B396A; color: white">Bienvenido <br>
                <strong>
                    @if(Session::has('username'))
                    {{ Session::get('username') }} 				
                    @endif
                    
                </strong>
            </div>
        
            <div class="card-body">
                <div>
                    <i class="fas fa-bell fa-lg" style="color: #1B396A;font-size:90px;padding: 30px 0px;"></i>
                    <span class="position-relative translate-middle badge rounded-pill bg-danger" style="font-size:15px;">
                    {{$totalRequestPending}}
                    </span>
                    
                    <p></p>
                </div>
            Hay solicitudes pendientes
            </div>
            <div class="card-footer">
                <a href="/receptionrequests" style="color:#1B396A;"><strong>Revisar solicitudes</strong></a>
            </div>
        </div>
    @else
        @if(Session::has('username'))
            <h3>Bienvenido {{ Session::get('username') }} </h3>		
        @endif
    @endif 

</div>

@endsection