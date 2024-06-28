@extends('layouts.app', [
    'title' => __('Edit Puerta'),
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
                                    <h3 class="mb-0">{{ __('Edit Puerta') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('puertas.index') }}" class="btn btn-sm btn-primary">{{ __('Regresar a la lista ') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('puertas.update', $puerta->id) }}" autocomplete="off">
                                @csrf
                                @method('put')
                                <h6 class="heading-small text-muted mb-4">{{ __('Información de la puerta') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('NombrePuerta') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-NombrePuerta">{{ __('Nombre Puerta') }}</label>
                                        <input type="text" name="NombrePuerta" id="input-NombrePuerta" class="form-control{{ $errors->has('NombrePuerta') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre Puerta') }}" value="{{ old('NombrePuerta', $puerta->NombrePuerta) }}" required autofocus>
                                        @include('alerts.feedback', ['field' => 'NombrePuerta'])
                                    </div>
                                    <div class="form-group{{ $errors->has('latitude') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-latitude">{{ __('Latitude') }}</label>
                                        <input type="text" name="latitude" id="input-latitude" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Latitude') }}" value="{{ old('latitude', $puerta->latitude) }}" required>
                                        @include('alerts.feedback', ['field' => 'latitude'])
                                    </div>
                                    <div class="form-group{{ $errors->has('longitud') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-longitud">{{ __('Longitud') }}</label>
                                        <input type="text" name="longitud" id="input-longitud" class="form-control{{ $errors->has('longitud') ? ' is-invalid' : '' }}" placeholder="{{ __('Longitud') }}" value="{{ old('longitud', $puerta->longitud) }}" required>
                                        @include('alerts.feedback', ['field' => 'longitud'])
                                    </div>
                                    <div class="form-group{{ $errors->has('Tipo') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-Tipo">{{ __('Tipo') }}</label>
                                        <select name="Tipo" id="input-Tipo" class="form-control{{ $errors->has('Tipo') ? ' is-invalid' : '' }}" required>
                                            <option value="Entrada" {{ old('Tipo', $puerta->Tipo) == 'Entrada' ? 'selected' : '' }}>Entrada</option>
                                            <option value="Salida" {{ old('Tipo', $puerta->Tipo) == 'Salida' ? 'selected' : '' }}>Salida</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'Tipo'])
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __(' Guardar') }}</button>
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
