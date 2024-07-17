@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" align="center">Bienvenido {{$nombre}}</div>
                <div class="card-body" align="center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ url('/AjedrezIA') }}">Ajedrez IA<br>
                         <img src="../logos/chessai.png" width="50%" height="50%" >
                    </a>
                    <br>
                    <br>
                    <a href="{{ url('/AjedrezMP') }}">Ajedrez MP<br>
                        <img src="../logos/chessmp.png" width="50%" height="50%" >
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection