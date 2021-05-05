<form action="{{ url('usuarios') }}" method="GET">
    <div class="row row-filters">
        <div class="col-md-6">
            @foreach (trans('users.filters.states') as $value => $text)
                <div class="custom-control custom-radio custom-control-inline">
                    <input wire:model="state" class="custom-control-input" type="radio" name="state"
                        id="state_{{ $value }}" value="{{ $value }}"
                        {{ $value == $state ? 'checked' : '' }}>
                    <label class="custom-control-label" for="state_{{ $value }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-inline form-search">
                <input wire:model.debounce.500ms="search" type="search" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Buscar...">
                &nbsp;
                <div class="btn-group">
                    <select wire:model="role" name="role" id="role" class="custom-select custom-select-sm">
                        @foreach (trans('users.filters.roles') as $value => $text)
                            <option value="{{ $value }}"{{ $role == $value ? ' selected' : ''}}>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
                &nbsp;
                <div class="btn-group drop-skills">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Habilidades
                    </button>
                    <div class="drop-menu skills-list">
                        @foreach ($skillsList as $skill)
                            <div class="form-group form-check">
                                <input wire:model="skills"
                                       name="skills[]"
                                       type="checkbox"
                                       class="form-check-input"
                                       id="skill_{{ $skill->id }}"
                                       value="{{ $skill->id }}"
                                       {{ in_array($skill->id, $skills) ? 'checked' : '' }}>
                                <label class="form-check-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-right">
            <div class="form-inline form-dates">
                <label for="from" class="form-label-sm">Fecha</label>&nbsp;
                <div class="input-group">
                    <input wire:model="from" type="text" class="form-control form-control-sm" name="from" id="from" placeholder="Desde" value="{{ $from }}">
                    {{-- <div class="input-group-append">
                        <button type="button" class="btn btn-secondary btn-sm"><i class="far fa-calendar-alt fa-lg fa-fw"></i></button>
                    </div> --}}
                </div>
                <div class="input-group">
                    <input wire:model="to" type="text" class="form-control form-control-sm" name="to" id="to" placeholder="Hasta" value="{{ $to }}">
                    {{-- <div class="input-group-append">
                        <button type="button" class="btn btn-secondary btn-sm"><i class="far fa-calendar-alt fa-lg fa-fw"></i></button>
                    </div> --}}
                </div>
                &nbsp;
                <button type="submit" class="btn btn-sm btn-primary" id="btn-filter">Filtrar</button>
            </div>
        </div>
    </div>
</form>
