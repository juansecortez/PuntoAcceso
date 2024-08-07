@extends('layouts.app', [
    'title' => __('Administración de Empleados'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'empleado'
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Empleados') }}</h3>
                                </div>
                                @can('create', App\Empleado::class)
                                    <div class="col-4 text-right">
                                        <a href="{{ route('empleado.create') }}" class="btn btn-sm btn-primary">{{ __('Agregar empleado') }}</a>
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#importModal">{{ __('Importar empleados') }}</button>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            @include('alerts.success')
                            @include('alerts.errors')
                        </div>

                        <div class="table-responsive py-4" id="employees-table">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Foto</th>
                                        <th scope="col">{{ __('Nombre') }}</th>
                                        <th scope="col">{{ __('Apellido Paterno') }}</th>
                                        <th scope="col">{{ __('Apellido Materno') }}</th>
                                        <th scope="col">{{ __('Correo') }}</th>
                                        <th scope="col">{{ __('CURP') }}</th>
                                        <th scope="col">{{ __('Teléfono') }}</th>
                                        <th scope="col">{{ __('Número de Contrato') }}</th>
                                        <th scope="col">{{ __('Activo') }}</th>
                                        @can('manage-empleados', App\Empleado::class)
                                            <th scope="col"></th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empleados as $empleado)
                                        <tr>
                                            <td>
                                                <span class="avatar avatar-sm rounded-circle">
                                                    <img class="avatar border-gray" src="https://pactral.com/PuntoAcceso/public{{ $empleado->profilePicture() }}" alt="...">
                                                </span>
                                            </td>
                                            <td>{{ $empleado->Nombre }}</td>
                                            <td>{{ $empleado->ApellidoP }}</td>
                                            <td>{{ $empleado->ApellidoM }}</td>
                                            <td>
                                                <a href="mailto:{{ $empleado->Correo }}">{{ $empleado->Correo }}</a>
                                            </td>
                                            <td>{{ $empleado->CURP }}</td>
                                            <td>{{ $empleado->Telefono }}</td>
                                            <td>{{ $empleado->NoContrato }}</td>
                                            <td>
                                                <input type="checkbox" data-toggle="toggle" data-size="sm" class="activo-toggle" data-id="{{ $empleado->id }}" {{ $empleado->activo ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-right">
                                                @if (auth()->user()->can('update', $empleado) || auth()->user()->can('delete', $empleado) || auth()->user()->can('assign', $empleado))
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="nc-icon nc-bullet-list-67"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            @can('update', $empleado)
                                                                <a class="dropdown-item" href="{{ route('empleado.edit', $empleado) }}">{{ __('Editar') }}</a>
                                                            @endcan
                                                            @can('delete', $empleado)
                                                                <form action="{{ route('empleado.destroy', $empleado) }}" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este empleado?') }}') ? this.parentElement.submit() : ''">
                                                                        {{ __('Eliminar') }}
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                            <a class="dropdown-item" href="{{ route('empleados.assign_puertas', $empleado->id) }}">{{ __('Asignar Puertas') }}</a>
                                                        </div>
                                                    </div>
                                                @endif
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

    <!-- Modal para la importación de empleados -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">{{ __('Importar empleados') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Cerrar') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('empleado.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excelFile">{{ __('Selecciona el archivo Excel') }}</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excelFile" name="excelFile" required>
                                <label class="custom-file-label" for="excelFile">{{ __('Elige archivo') }}</label>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <a href="{{ route('empleado.template') }}" class="btn btn-sm btn-primary">{{ __('Descargar plantilla') }}</a>
                        </div>
                        <div class="form-group">
                            <p>{{ __('Instrucciones para importar empleados:') }}</p>
                            <ul>
                                <li>{{ __('Descargue la plantilla de Excel.') }}</li>
                                <li>{{ __('Complete la plantilla con la información de los empleados.') }}</li>
                                <li>{{ __('Asegúrese de no modificar los encabezados de las columnas.') }}</li>
                                <li>{{ __('Guarde el archivo Excel una vez completado.') }}</li>
                                <li>{{ __('Seleccione el archivo Excel y haga clic en Importar.') }}</li>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Importar') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar el nombre del archivo seleccionado
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("excelFile").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName;
        });

        // Manejar cambios en el switch de activo/inactivo
        document.querySelectorAll('.activo-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var empleadoId = this.dataset.id;
                var isActive = this.checked;

                fetch(`/empleado/${empleadoId}/toggle-active`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ activo: isActive })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Error al actualizar el estado del empleado.');
                        this.checked = !isActive; // Revertir el cambio si hubo un error
                    }
                })
                .catch(() => {
                    alert('Error al actualizar el estado del empleado.');
                    this.checked = !isActive; // Revertir el cambio si hubo un error
                });
            });
        });
    </script>
@endsection
