@extends('layout')

@section('title', "Home")

@section('content')
    <div class="jumbotron">
        <h1 class="display-3">Bienvenidos a Curso - Styde</h1>
        <p class="lead">
            En este curso estoy aprendiendo a hacer un módulo de usuarios con el Framework
            <a href="https://laravel.com">Laravel</a> en su versión 5.8 y nuevos conocimientos tanto de <i>Back-end</i> como de
            <i>Front-end</i> developer.
        </p>
        <hr class="my-2">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="{{ url('usuarios') }}" role="button">Ver lista de usuarios</a>
        </p>
    </div>
@endsection
