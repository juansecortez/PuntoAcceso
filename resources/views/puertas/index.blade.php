@extends('layouts.app', [
    'title' => __('Administración de Puertas'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'puerta'
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Administración de Puertas') }}</h3>
                                </div>
                                @can('create', App\Puerta::class)
                                    <div class="col-4 text-right">
                                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#assignModal">
                                            <i class="fa fa-star fa-spin"></i> {{ __('Asignar Puertas') }}
                                        </button>
                                        <a href="{{ route('puertas.create') }}" class="btn btn-sm btn-primary"> {{ __('Agregar Puerta') }}</a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            @include('alerts.success')
                            @include('alerts.errors')
                        </div>
                        <div class="table-responsive py-4" id="puertas-table">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Nombre Puerta') }}</th>
                                        <th scope="col">{{ __('Latitud') }}</th>
                                        <th scope="col">{{ __('Longitud') }}</th>
                                        <th scope="col">{{ __('Tipo') }}</th>
                                       
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($puertas as $puerta)
                                        <tr>
                                            <td>{{ $puerta->NombrePuerta }}</td>
                                            <td>{{ $puerta->latitude }}</td>
                                            <td>{{ $puerta->longitud }}</td>
                                            <td>{{ $puerta->Tipo }}</td>
                                            
                                            <td class="text-right">
                                                @can('manage-empleados', App\Empleado::class)
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="nc-icon nc-bullet-list-67"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{ route('puertas.edit', $puerta->id) }}">{{ __('Editar') }}</a>
                                                            <form action="{{ route('puertas.destroy', $puerta->id) }}" method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta puerta?') }}')">{{ __('Eliminar') }}</button>
                                                            </form>
                                                            <a class="dropdown-item" href="{{ route('puertas.assign_empleados', $puerta->id) }}">{{ __('Asignar Empleados') }}</a>
                                                        </div>
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('puertas.assign_selected_to_all') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModalLabel">{{ __('Asignar Puertas a los Empleados') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="select-all">{{ __('Seleccionar Todas') }}</label>
                            <input type="checkbox" id="select-all">
                        </div>
                        @foreach ($puertas as $puerta)
                            <div class="form-group">
                                <input type="checkbox" name="puertas[]" value="{{ $puerta->id }}" class="puerta-checkbox">
                                <label>{{ $puerta->NombrePuerta }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Asignar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('.puerta-checkbox');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
@endpush
