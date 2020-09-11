@extends('layout')

@section('title', "Habilidades")

@section('content')
    <h1>{{ $title }}</h1>
    <div class="card mt-3 mb-2">
        <div class="card-body">
            <h4 class="card-title">Se encontraron {{ $skills->count() }} habilidades</h4>
{{--            <a class="btn btn-outline-primary" href="{{ route('users.create') }}" role="button">Nuevo usuario</a>--}}
        </div>
        @if ($skills->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skills as $skill)
                            <tr>
                                <th scope="row">{{ $skill->id }}</th>
                                <td>{{ $skill->name }}</td>
                                <td>
{{--                                    <form action="{{ route('users.destroy', $user)}}" method="POST">--}}
{{--                                        @csrf--}}
{{--                                        @method('delete')--}}
{{--                                        <a href="{{ route('users.show', $user) }}" class="btn btn-link"><i class="fas fa-eye fa-lg fa-fw"></i></a>--}}
{{--                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-link"><i class="fas fa-edit fa-lg fa-fw"></i></a>--}}
{{--                                        <button type="submit" class="btn btn-link"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>--}}
{{--                                    </form>--}}
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
              <strong>No hay habilidades registradas</strong>
            </div>
        @endif
    </div>
@endsection

@section('help-text')
    Aquí se muestra el listado de habilidades existentes y algunas acciones que son posibles de realizar.
@endsection
