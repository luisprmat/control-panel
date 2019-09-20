@extends('layout')

@section('title', "Página no encontrada")

@section('content')
    <h1>Página no encontrada</h1>
    <p>
        <img src="{{ asset('images/error404.png') }}" class="d-block mt-3">
    </p>
    <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Regresar al listado de usuarios</a>
@endsection

@section('help-text')
    Error mostrando la información del usuario.
@endsection
