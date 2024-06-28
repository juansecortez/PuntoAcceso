@extends('layouts.app', [
    'title' => __('Asignar Empleados'),
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
                    <div class="card-header bg-primary text-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Asignar Empleados a ') . $puerta->NombrePuerta }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('puertas.index') }}" class="btn btn-sm btn-light">{{ __('Volver a la lista') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-right mb-3">
                            <form method="post" action="{{ route('puertas.assign_all_empleados', $puerta->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">{{ __('Asignar Todos los Empleados') }}</button>
                            </form>
                            <form method="post" action="{{ route('puertas.unassign_all_empleados', $puerta->id) }}" style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Desasignar Todos los Empleados') }}</button>
                            </form>
                        </div>
                        <h5 class="text-muted">{{ __('Empleados Asignados') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedEmpleados as $empleado)
                                        <tr>
                                            <td>{{ $empleado->Nombre }}</td>
                                            <td>
                                                <form method="post" action="{{ route('puertas.unassign_empleado', ['puerta' => $puerta->id, 'empleado' => $empleado->id]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <h5 class="text-muted">{{ __('Empleados Disponibles') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableEmpleados as $empleado)
                                        <tr>
                                            <td>{{ $empleado->Nombre }}</td>
                                            <td>
                                                <form method="post" action="{{ route('puertas.assign_empleado', ['puerta' => $puerta->id, 'empleado' => $empleado->id]) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">{{ __('Agregar') }}</button>
                                                </form>
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
</div>
@endsection
