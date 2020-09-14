<div>
    @includeWhen($view == 'index', 'users._filters')

    <p><a class="btn btn-info" href="#" wire:click="$refresh()">Recargar componente</a></p>
    <h4>URL: {{ $currentUrl }}</h4>

    @if ($users->isNotEmpty())
        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col"><a href="{{ $sortable->url('name') }}" class="link-sortable">Nombre <i class="fas {{ $sortable->classes('name') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col"><a href="{{ $sortable->url('email') }}" class="link-sortable">Correo <i class="fas {{ $sortable->classes('email') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col"><a href="{{ $sortable->url('date') }}" class="link-sortable">Registrado el <i class="fas {{ $sortable->classes('date') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col"><a href="{{ $sortable->url('login') }}" class="link-sortable">Último login <i class="fas {{ $sortable->classes('login') }} fa-xs fa-fw"></i></a></th>
                    <th scope="col" class="text-right">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @include('users._row')
                    @endforeach
                    {{-- @each('users._row', $users, 'user') --}}
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
</div>
