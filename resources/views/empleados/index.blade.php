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
@endsection
