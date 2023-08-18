@extends('template')
@section('content')

<div class="d-flex align-items-center justify-content-center">
    <div class="card card-block text-center align-middle w-30">
        <div class="card-header" style="background-color: #1B396A; color: white">
            MENSAJE
        </div>
        <div class="card-body">
            @if($data['success'])
            <div class="alert alert-success">
                <h3> {{ $data['message'] }} </h3>
            </div>

            @else
            <div class="alert alert-danger">
                <h3>{{ $data['message'] }} </h3>
            </div>
            @endif
        </div>
        <div class="card-body">
            <button type="button" class="submit" onclick="{{$data['urldestination']}}">OK</button>
        </div>
    </div>
</div>    
@endsection