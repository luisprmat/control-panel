<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td><i>{{ $user->email }}</i></td>
                    <td>
                        @if($user->trashed())
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <form action="{{ route('users.restore', $user)}}" method="POST" class="form-inline" role="form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link"><i class="fas fa-trash-restore fa-lg fa-fw"></i></button>
                                    </form>
                                </li>
                                <li class="list-inline-item">
                                    <form action="{{ route('users.destroy', $user)}}" method="POST" class="form-inline" role="form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link"><i class="fas fa-times-circle fa-lg fa-fw"></i></button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <form action="{{ route('users.trash', $user)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <a href="{{ route('users.show', $user) }}" class="btn btn-link"><i class="fas fa-eye fa-lg fa-fw"></i></a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-link"><i class="fas fa-edit fa-lg fa-fw"></i></a>
                                <button type="submit" class="btn btn-link"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
