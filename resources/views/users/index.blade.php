@extends('layout')

@section('title', "Usuarios")

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">
            {{ trans("users.title.{$view}") }}
        </h1>
        <p>
            @if ($view == 'index')
                <a href="{{ route('users.trashed') }}" class="btn btn-outline-dark">Ver papelera</a>
                <a href="{{ route('users.create') }}" class="btn btn-dark">Nuevo usuario</a>
            @elseif($view == 'trash')
                <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Regresar al listado de usuarios</a>
            @endif
        </p>
    </div>

    @includeWhen($view == 'index', 'users._filters')

    @if ($users->isNotEmpty())
        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col"><a href="{{ $sortable->url('name') }}" class="link-sortable">Nombre <i class="fas {{ $sortable->classes('name') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col"><a href="{{ $sortable->url('email') }}" class="link-sortable">Correo <i class="fas {{ $sortable->classes('email') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col"><a href="{{ $sortable->url('date') }}" class="link-sortable">Fecha registro <i class="fas {{ $sortable->classes('date') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col" class="text-right">Acciones</th>
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

