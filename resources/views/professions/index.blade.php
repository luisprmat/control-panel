@extends('layout')

@section('title', "Profesiones")

@section('content')
    <h1>{{ $title }}</h1>
    <div class="card mt-3 mb-2">
        <div class="card-body">
            <h4 class="card-title">Se encontraron {{ $professions->count() }} profesiones</h4>
{{--            <a class="btn btn-outline-primary" href="{{ route('users.create') }}" role="button">Nuevo usuario</a>--}}
        </div>
        @if ($professions->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Título</th>
                            <th scope="col">Perfiles asociados</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($professions as $profession)
                            <tr>
                                <th scope="row">{{ $profession->id }}</th>
                                <td>{{ $profession->title }}</td>
                                <th> {{ $profession->profiles_count }}</th>
                                <td>
                                    @if($profession->profiles_count == 0)
                                        <form action="{{ url("profesiones/{$profession->id}") }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>No hay profesiones registradas</strong>
            </div>
        @endif
    </div>
@endsection

@section('help-text')
    Aquí se muestra el listado de profesiones existentes y algunas acciones que son posibles de realizar.
@endsection
