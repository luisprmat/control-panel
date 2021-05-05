@extends('livewire-layout')

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

    @livewire('users-list', compact(['view']))

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js"></script>
    <script>
        var userTableId = $('#users-table').attr('wire:id');

        var loadCalendars = function () {

            ['from', 'to'].forEach(function(field) {
                $('#' + field).datepicker({
                    uiLibrary: 'bootstrap4',
                    size: 'small',
                    format: 'dd/mm/yyyy',
                    icons: {
                        rightIcon: '<i class="far fa-calendar-alt fa-lg fa-fw"></i>'
                    }
                }).on('change', function () {
                    var usersTable = window.livewire.find(userTableId);

                    if(usersTable.get(field) !== $(this).val()) {
                        usersTable.set(field, $(this).val());
                    }
                });
            })
        };

        loadCalendars();
        $('#btn-filter').hide();

        document.addEventListener('livewire:load', (event) => {
            Livewire.hook('element.updating', () => {
                loadCalendars();
            });
        });
    </script>
@endpush

