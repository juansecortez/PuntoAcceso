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
                <div class="col-xl-12 order-xl-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Administración de Contratos') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('contrato.index') }}" class="btn btn-sm btn-primary">{{ __('Regresar a la lista') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('contrato.update', $contrato) }}" autocomplete="off">
                                @csrf
                                @method('put')

                                <h6 class="heading-small text-muted mb-4">{{ __('Información del Contrato') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('NombreContrato') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nombreContrato">{{ __('Nombre del Contrato') }}</label>
                                        <input type="text" name="NombreContrato" id="input-nombreContrato" class="form-control{{ $errors->has('NombreContrato') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre del Contrato') }}" value="{{ old('NombreContrato', $contrato->NombreContrato) }}" required autofocus>
                                        @include('alerts.feedback', ['field' => 'NombreContrato'])
                                    </div>
                                    <div class="form-group{{ $errors->has('NoContrato') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-noContrato">{{ __('Número de Contrato') }}</label>
                                        <input type="text" name="NoContrato" id="input-noContrato" class="form-control{{ $errors->has('NoContrato') ? ' is-invalid' : '' }}" placeholder="{{ __('Número de Contrato') }}" value="{{ old('NoContrato', $contrato->NoContrato) }}" required>
                                        @include('alerts.feedback', ['field' => 'NoContrato'])
                                    </div>
                                    <div class="form-group{{ $errors->has('EncargadoInterno') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-encargadoInterno">{{ __('Encargado Interno') }}</label>
                                        <input type="text" name="EncargadoInterno" id="input-encargadoInterno" class="form-control{{ $errors->has('EncargadoInterno') ? ' is-invalid' : '' }}" placeholder="{{ __('Encargado Interno') }}" value="{{ old('EncargadoInterno', $contrato->EncargadoInterno) }}" required>
                                        @include('alerts.feedback', ['field' => 'EncargadoInterno'])
                                    </div>
                                    <div class="form-group{{ $errors->has('EncargadoExterno') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-encargadoExterno">{{ __('Encargado Externo') }}</label>
                                        <input type="text" name="EncargadoExterno" id="input-encargadoExterno" class="form-control{{ $errors->has('EncargadoExterno') ? ' is-invalid' : '' }}" placeholder="{{ __('Encargado Externo') }}" value="{{ old('EncargadoExterno', $contrato->EncargadoExterno) }}" required>
                                        @include('alerts.feedback', ['field' => 'EncargadoExterno'])
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Guardar') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
