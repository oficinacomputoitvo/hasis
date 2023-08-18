@extends('template')
@section('content')

<div class="d-flex text-center align-items-center justify-content-center" >

    @if ( Session::get('rol') == App\Enums\RolEnum::REQUESTER->value && $pendingRequestsXRelease>0 )
        <div class="card">
             <div class="card-header" style="background:#1B396A; color: white">
                <strong>Solicitudes pendientes por liberar</strong>
            </div>            
            <div class="card-body">
                <div>
                    <i class="fas fa-bell fa-lg" style="color: #1B396A;font-size:90px;padding: 30px 0px;"></i>
                    <span class="position-relative translate-middle badge rounded-pill bg-danger" style="font-size:15px;">
                    {{$pendingRequestsXRelease}}
                    </span>
                    <p></p>
                </div>
            </div>
            <div class="card-footer">
                <a href="/workorders/listxrelease" style="color:#1B396A;"><strong>Revisar solicitudes</strong></a>
            </div>
        </div>
    @else
        <h1>Bienvenido @if (Session::has('username')) {{Session::get('username')}} @endif</h1>
    @endif 

</div>

@endsection