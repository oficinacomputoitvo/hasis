@extends('template')
@section('content')

<link href="{{ asset('css/registro.css') }}" rel="stylesheet">


<div class="d-flex align-items-left justify-content-center" >
    <div class="card  transparent-container"  >
            <div class="card-header text-center align-items-center justify-content-center" style="background:#1B396A; color: white">
                <strong>Modificar Solicitud de Mantenimiento Correctivo</strong>
            </div> 
			<form action="{{ route('servicerequests.update',$servicerequest->servicerequest_id) }}" 
			method="POST">
			@method('PUT')
			@csrf
			<div class="card-body"  >
                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="folio" class="form-label" >Folio</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
                            <input 
                                class="form-control border border-primary"
                                type="text" placeholder="Folio" 
								id="folio" 
                                name="folio" readonly required
								value ="{{ $servicerequest->folio }}"
                                autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="email" >Solicitante</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
							<select id="email" name="email" class="form-control border border-primary" >
								@foreach ($users as $user)
									<option value="{{$user->email}}">{{$user->name}}</option>
								@endforeach
							</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="hardware" >Equipos a los que se les dará matenimiento</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
                            
							<div id="divHardware" style="width:100%"
							class="multiselect form-control border border-primary" >
								@foreach ($hardwares as $hardware)
                                    @php $checked=" "; @endphp
									@if(in_array($hardware->hardware_id, $hardwaresPreselected))	
                                    @php $checked=" checked "; @endphp
									@endif
									<label> <input type="checkbox" {{ $checked }} name="hardware[]" 
										value="{{$hardware->hardware_id}}" >  {{ $hardware->features }}  
									</label> 
								@endforeach

							</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="daterequest" >Fecha de elaboración</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
							<input type="date" required onkeypress="return false"
								class="form-control border border-primary"
								name="daterequest" id="daterequest" 
								value="{{ $servicerequest->daterequest->format('Y-m-d') }}"  />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-3">
                            <label for="description" >
								Descripción del servicio solicitado o falla que presenta
							</label>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-3">
							<textarea required	rows="5" style="width:100%"
							class="form-control border border-primary"
							name="description" id="description">{{ $servicerequest->description}}</textarea> 
                        </div>
                    </div>
					
                    <div class="row">
                        @if(Session::has('error'))
                            <div class="form-group mb-3 alert alert-danger" role="alert">
                                        {{ Session::get('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="form-group mb-3 alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                            @endforeach
                        @endif	
                    </div>                   
                </div>

                <div class="card-footer text-center align-items-center justify-content-center" >

                    <button type="submit" class="submit" >Enviar</button>
                </div>

			</form>

	</div>
</div>
@endsection