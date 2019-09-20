@extends('layout')

@section('title', 'Editar perfil')

@section('content')
    @card
        @slot('header', 'Editar perfil')

        @include('shared._errors')

        <form method="POST" action="{{ url("/editar-perfil/") }}">
            @method('PUT')

            @csrf

            {{-- Nombre --}}
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text"
                       class="form-control" name="name" id="name" aria-describedby="name" placeholder="Pedro Pérez" value="{{ old('name', $user->name) }}">
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email"
                       class="form-control" name="email" id="email" aria-describedby="email" placeholder="example@mail.org" value="{{ old('email', $user->email) }}">
            </div>

            {{-- Bio --}}
            <div class="form-group">
                <label for="bio">Perfil del usuario:</label>
                <textarea class="form-control" name="bio" id="bio">
                   {{ old('bio', $user->profile->bio) }}
                </textarea>
            </div>

            {{-- Profession --}}
            <div class="form-group">
                <label for="profession_id">Profesión:</label>
                <select name="profession_id" id="profession_id" class="custom-select">
                    <option value="">Selecciona una profesión</option>
                    @foreach ($professions as $profession)
                        <option value="{{ $profession->id }}"{{ old('profession_id', $user->profile->profession_id) == $profession->id ? ' selected' : ''}}>
                          {{ $profession->title}}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Twitter --}}
            <div class="form-group">
                <label for="twitter">Twitter:</label>
                <input type="text"
                       class="form-control" name="twitter" id="twitter" aria-describedby="twitter" placeholder="Twitter"
                       value="{{ old('twitter', $user->profile->twitter) }}">
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-outline-primary">Actualizar perfil</button>
            </div>
        </form>
    @endcard
@endsection

@section('help-text')
    Editar el perfil del usuario.
@endsection
