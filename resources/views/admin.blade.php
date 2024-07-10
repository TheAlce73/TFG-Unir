@extends('layouts.app')

@section('content')
@include('LUsuarios')
@include('LPartidaTres')
@include('LPartidaAje')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Listados de:</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p><a href="" data-toggle="modal" data-target="#LUsuarios">{{ __('Usuarios') }}</a></p>
                    <p><a href="" data-toggle="modal" data-target="#LPartidaTres">{{ __('LPartidaTres') }}</a></p>
                    <p></p><a href="" data-toggle="modal" data-target="#LPartidaAje">{{ __('LPartidaAje') }}</a></p>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection