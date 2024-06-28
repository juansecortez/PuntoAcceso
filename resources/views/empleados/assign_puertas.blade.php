@extends('layouts.app', [
    'title' => __('Asignar Puertas'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'empleado'
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
                                <h3 class="mb-0">{{ __('Asignar Puertas a ') . $empleado->Nombre }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('empleado.index') }}" class="btn btn-sm btn-light">{{ __('Volver a la lista') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-right mb-3">
                            <form method="post" action="{{ route('empleados.assign_all_puertas', $empleado->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">{{ __('Asignar Todas las Puertas') }}</button>
                            </form>
                            <form method="post" action="{{ route('empleados.unassign_all_puertas', $empleado->id) }}" style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Desasignar Todas las Puertas') }}</button>
                            </form>
                        </div>
                        <h5 class="text-muted">{{ __('Puertas Asignadas') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nombre Puerta') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedPuertas as $puerta)
                                        <tr>
                                            <td>{{ $puerta->NombrePuerta }}</td>
                                            <td>
                                                <form method="post" action="{{ route('empleados.unassign_puerta', ['empleado' => $empleado->id, 'puerta' => $puerta->id]) }}" style="display:inline;">
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
                        
                        <h5 class="text-muted">{{ __('Puertas Disponibles') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nombre Puerta') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availablePuertas as $puerta)
                                        <tr>
                                            <td>{{ $puerta->NombrePuerta }}</td>
                                            <td>
                                                <form method="post" action="{{ route('empleados.assign_puerta', ['empleado' => $empleado->id, 'puerta' => $puerta->id]) }}" style="display:inline;">
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
