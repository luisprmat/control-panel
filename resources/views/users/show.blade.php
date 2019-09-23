@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <h1>{{ $user->name }}</h1>
    <div class="card">
        <div class="card-header">
            Detalles
        </div>
        <div class="card-body">
            <h4 class="card-title">ID del usuario: {{ $user->id }}</h4>
            <p class="card-text"><strong>Correo electrónico:</strong> <i>{{ $user->email }}</i> </p>
            <p class="card-text"><strong>Rol:</strong> {{ $user->role }}</p>
            <p class="card-text"><strong>Fecha de registro:</strong> {{ $user->created_at }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Regresar al listado de usuarios</a>
        </div>
    </div>
@endsection
