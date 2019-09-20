@extends('layout')

@section('title', "Crear usuario")

@section('content')
    @card
        @slot('header', 'Nuevo usuario')

        @include('shared._errors')

        <form action="{{ url('usuarios') }}" method="POST">
            @render('UserFields', ['user' => $user]);

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-outline-primary mr-3 mb-2">Crear usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary mb-2">Regresar al listado de usuarios</a>
            </div>
        </form>
    @endcard
@endsection

