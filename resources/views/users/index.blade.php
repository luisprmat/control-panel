@extends('layout')

@section('title', "Usuarios")

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ $title }}</h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-dark">Nuevo usuario</a>
        </p>
    </div>

    @includeWhen(isset($states), 'users._filters')

    @if ($users->isNotEmpty())
        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col" class="sort-desc">Nombre</th>
                    <th scope="col">Correo </th>
                    <th scope="col">Fechas</th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @each('users._row', $users, 'user')
                </tbody>
            </table>
            {{ $users->links() }}
            <p class="mb-2">
            Viendo página <strong>{{ $users->currentPage() }}</strong> de <strong>{{ $users->lastPage() }}</strong>
            </p>
        </div>
    @else
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <strong>No hay usuarios en esta lista</strong>
        </div>
    @endif
@endsection
