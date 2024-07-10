@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido {{$nombre}}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ url('/AjedrezIA') }}">Ajedrez IA<br></a>
                    <br>
                    <br>
                    <a href="{{ url('/AjedrezMP') }}">Ajedrez MP<br></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection