@extends('layouts.app', [
    'title' => __('Administración de Contratos'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'contrato'
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
                                    <h3 class="mb-0">{{ __('Contratos') }}</h3>
                                    
                                </div>
                                @can('create', App\Contrato::class)
                                    <div class="col-4 text-right">
                                        <a href="{{ route('contrato.create') }}" class="btn btn-sm btn-primary">{{ __('Agregar contrato') }}</a>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            @include('alerts.success')
                            @include('alerts.errors')
                        </div>

                        <div class="table-responsive py-4" id="contracts-table">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Nombre del Contrato') }}</th>
                                        <th scope="col">{{ __('Número de Contrato') }}</th>
                                        <th scope="col">{{ __('Encargado Interno') }}</th>
                                        <th scope="col">{{ __('Encargado Externo') }}</th>
                                        @can('manage-contratos', App\Contrato::class)
                                            <th scope="col"></th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contratos as $contrato)
                                        <tr>
                                            <td>{{ $contrato->NombreContrato }}</td>
                                            <td>{{ $contrato->NoContrato }}</td>
                                            <td>{{ $contrato->EncargadoInterno }}</td>
                                            <td>{{ $contrato->EncargadoExterno }}</td>
                                            <td class="text-right">
                                                @if (auth()->user()->can('update', $contrato) || auth()->user()->can('delete', $contrato))
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="nc-icon nc-bullet-list-67"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            @can('update', $contrato)
                                                                <a class="dropdown-item" href="{{ route('contrato.edit', $contrato) }}">{{ __('Editar') }}</a>
                                                            @endcan
                                                            @can('delete', $contrato)
                                                                <form action="{{ route('contrato.destroy', $contrato) }}" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este contrato?') }}') ? this.parentElement.submit() : ''">
                                                                        {{ __('Eliminar') }}
                                                                    </button>
                                                                </form>
                                                            @endcan
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
