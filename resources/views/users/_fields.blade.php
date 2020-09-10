@csrf

<div class="form-row">
    {{-- Nombre --}}
    <div class="form-group col-md-6">
        <label for="first_name">Nombres:</label>
        <input type="text" class="form-control" name="first_name" id="first_name"
            aria-describedby="first_name" placeholder="Pedro" value="{{ old('first_name', $user->first_name) }}">
    </div>

    {{-- Apellido --}}
    <div class="form-group col-md-6">
        <label for="last_name">Apellidos:</label>
        <input type="text" class="form-control" name="last_name" id="last_name"
            aria-describedby="last_name" placeholder="Pérez" value="{{ old('last_name', $user->last_name) }}">
    </div>
</div>

<div class="form-row">
    {{-- Email --}}
    <div class="form-group col-md-7">
        <label for="email">Correo electrónico:</label>
        <input type="email" class="form-control" name="email" id="email"
            aria-describedby="email" placeholder="example@mail.org" value="{{ old('email', $user->email) }}">
    </div>

    {{-- Constraseña --}}
    <div class="form-group col-md-5">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" name="password" id="password"
            aria-describedby="password" placeholder="Mínimo 8 caracteres">
    </div>
</div>

{{-- Bio --}}
<div class="form-group">
    <label for="bio">Perfil del usuario:</label>
    <textarea class="form-control" name="bio" id="bio">{{ old('bio', $user->profile->bio) }}</textarea>
</div>
<div class="form-row">
    {{-- Profession --}}
    <div class="form-group col-md-6">
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
    <div class="form-group col-md-6">
        <label for="twitter">Twitter:</label>
        <input type="text"
        class="form-control" name="twitter" id="twitter" aria-describedby="twitter" placeholder="Twitter"
        value="{{ old('twitter', $user->profile->twitter) }}">
    </div>
</div>

{{-- Habilidades --}}
<h5>Habilidades</h5>

@foreach ($skills as $skill)
    <div class="custom-control custom-checkbox custom-control-inline">
        <input name = "skills[{{ $skill->id }}]"
            class="custom-control-input"
            type="checkbox"
            id="skill_{{ $skill->id }}"
            value="{{ $skill->id }}"
            {{ $errors->any() ? old("skills.{$skill->id}") : ( $user->skills->contains($skill) ? 'checked' : '' )}}>
        <label class="custom-control-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
    </div>
@endforeach

{{-- Rol --}}
<h5 class="mt-3">Rol</h5>
@foreach (trans('users.roles') as $role => $name)
    <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input"
            type="radio"
            name="role"
            id="role_{{ $role }}"
            value="{{ $role }}"
            {{ old('role', $user->role) == $role ? 'checked' : '' }}>
        <label class="custom-control-label" for="role_{{ $role }}">{{ $name }}</label>
    </div>
@endforeach

{{-- Estado --}}
<h5 class="mt-3">Estado</h5>
@foreach (trans('users.states') as $state => $text)
    <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input"
            type="radio"
            name="state"
            id="state_{{ $state }}"
            value="{{ $state }}"
            {{ old('role', $user->state) == $state ? 'checked' : '' }}>
        <label class="custom-control-label" for="state_{{ $state }}">{{ $text }}</label>
    </div>
@endforeach
