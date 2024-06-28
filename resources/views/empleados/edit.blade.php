@extends('layouts.app', [
    'title' => __('Administracion de Empleado'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'employee'
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
                                    <h3 class="mb-0">{{ __('Administracion de Empleado') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('empleado.index') }}" class="btn btn-sm btn-primary">{{ __('Regresar a la lista ') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('empleado.update', $empleado) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <h6 class="heading-small text-muted mb-4">{{ __('Información del Empleado') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('Nombre') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                                        <input type="text" name="Nombre" id="input-nombre" class="form-control{{ $errors->has('Nombre') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre') }}" value="{{ old('Nombre', $empleado->Nombre) }}" required autofocus>
                                        @include('alerts.feedback', ['field' => 'Nombre'])
                                    </div>
                                    <div class="form-group{{ $errors->has('ApellidoP') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-apellidoP">{{ __('Apellido Paterno') }}</label>
                                        <input type="text" name="ApellidoP" id="input-apellidoP" class="form-control{{ $errors->has('ApellidoP') ? ' is-invalid' : '' }}" placeholder="{{ __('Apellido Paterno') }}" value="{{ old('ApellidoP', $empleado->ApellidoP) }}" required>
                                        @include('alerts.feedback', ['field' => 'ApellidoP'])
                                    </div>
                                    <div class="form-group{{ $errors->has('ApellidoM') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-apellidoM">{{ __('Apellido Materno') }}</label>
                                        <input type="text" name="ApellidoM" id="input-apellidoM" class="form-control{{ $errors->has('ApellidoM') ? ' is-invalid' : '' }}" placeholder="{{ __('Apellido Materno') }}" value="{{ old('ApellidoM', $empleado->ApellidoM) }}" required>
                                        @include('alerts.feedback', ['field' => 'ApellidoM'])
                                    </div>
                                    <div class="form-group{{ $errors->has('CURP') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-curp">{{ __('CURP') }}</label>
                                        <input type="text" name="CURP" id="input-curp" class="form-control{{ $errors->has('CURP') ? ' is-invalid' : '' }}" placeholder="{{ __('CURP') }}" value="{{ old('CURP', $empleado->CURP) }}" required>
                                        @include('alerts.feedback', ['field' => 'CURP'])
                                    </div>
                                    <div class="form-group{{ $errors->has('Telefono') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-telefono">{{ __('Teléfono') }}</label>
                                        <input type="text" name="Telefono" id="input-telefono" class="form-control{{ $errors->has('Telefono') ? ' is-invalid' : '' }}" placeholder="{{ __('Teléfono') }}" value="{{ old('Telefono', $empleado->Telefono) }}" required>
                                        @include('alerts.feedback', ['field' => 'Telefono'])
                                    </div>
                                    <div class="form-group{{ $errors->has('Correo') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-correo">{{ __('Correo') }}</label>
                                        <input type="email" name="Correo" id="input-correo" class="form-control{{ $errors->has('Correo') ? ' is-invalid' : '' }}" placeholder="{{ __('Correo') }}" value="{{ old('Correo', $empleado->Correo) }}" required>
                                        @include('alerts.feedback', ['field' => 'Correo'])
                                    </div>
                                    <div class="form-group{{ $errors->has('NoContrato') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-noContrato">{{ __('Número de Contrato') }}</label>
                                        <select name="NoContrato" id="input-noContrato" class="form-control{{ $errors->has('NoContrato') ? ' is-invalid' : '' }}" required>
                                            <option value="">{{ __('Seleccione un contrato') }}</option>
                                            @foreach($contratos as $contrato)
                                                <option value="{{ $contrato->NoContrato }}" {{ $empleado->NoContrato == $contrato->NoContrato ? 'selected' : '' }}>
                                                    {{ $contrato->NoContrato }} - {{ $contrato->NombreContrato }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'NoContrato'])
                                    </div>
                                    <div class="form-group{{ $errors->has('photo') ? ' has-danger' : '' }} d-flex flex-column">
                                        <label class="form-control-label" for="input-photo">{{ __('Profile photo') }}</label>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="{{ $empleado->profilePicture() }}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input{{ $errors->has('photo') ? ' is-invalid' : '' }}" id="input-photo" accept="image/*">
                                                <label class="custom-file-label" for="input-photo">{{ $empleado->photo }}</label>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'photo'])
                                        </div>
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
