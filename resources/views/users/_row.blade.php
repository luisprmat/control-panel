<tr>
    <td rowspan="2">{{ $user->id }}</td>
    <th scope="row">
        {{ $user->name }}
        @if ($user->active)
            <span class="text-success"><i class="fas fa-circle fa-xs"></i></span>
        @else
            <span class="text-danger"><i class="fas fa-circle fa-xs"></i></span>
        @endif
    <span class="note">{{ $user->team->name}}</span>
    </th>
    <td>{{ $user->email }}</td>
    <td>
        <span class="note">Registro: {{ $user->created_at->format('d/m/Y') }}</span>
        <span class="note">Último login: {{ $user->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-right">
        @if ($user->trashed())
            <ul class="list-inline">
                <li class="list-inline-item">
                    <form action="{{ route('users.restore', $user) }}" method="POST" class="form-inline" role="form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="fas fa-trash-restore fa-lg fa-fw"></i></button>
                    </form>
                </li>
                <li class="list-inline-item">
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="form-inline" role="form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle fa-lg fa-fw"></i></button>
                    </form>
                </li>
            </ul>
        @else
            <form action="{{ route('users.trash', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye fa-lg fa-fw"></i></a>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit fa-lg fa-fw"></i></a>
                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>
            </form>
        @endif
    </td>
</tr>
<tr class="skills">
    <td colspan="1">
        <span class="note">{{ $user->profile->profession->title }}</span>
    </td>
    <td colspan="4"><span class="note">{{ $user->skills->implode('name', ', ') ?: 'Sin habilidades :(' }}</span></td>
</tr>
