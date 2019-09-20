@extends('layout')

@section('title', "Editar usuario {$user->id}")

@section('content')
    <h1>Editar usuario</h1>

    @card
        @slot('header', "Editando información del usuario con id: {$user->id}")

        @include('shared._errors')

        <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
            @method('PUT')

            @render('UserFields', compact('user'));

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-outline-primary mr-3 mb-2">Actualizar usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary mb-2">Regresar al listado de usuarios</a>
            </div>
        </form>
    @endcard
@endsection

