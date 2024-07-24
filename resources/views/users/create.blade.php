@extends('layouts.app', [
    'title' => __('Administración de Usuarios'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'user'
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
                                    <h3 class="mb-0">{{ __('Administración de Usuarios') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Regresar a la lista') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('user.store') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf

                                <h6 class="heading-small text-muted mb-4">{{ __('Información del Usuario') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre') }}" value="{{ old('name') }}" required autofocus>

                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Correo Electrónico') }}</label>
                                        <input type="email" name="email" id="input-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Correo Electrónico') }}" value="{{ old('email') }}" required>

                                        @include('alerts.feedback', ['field' => 'email'])
                                    </div>
                                    <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-role">{{ __('Rol') }}</label>
                                        <select name="role_id" id="input-role" class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Rol') }}" required>
                                            <option value="">-</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $role->id == old('role_id') ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                        @include('alerts.feedback', ['field' => 'role_id'])
                                    </div>
                                    <div class="form-group{{ $errors->has('photo') ? ' has-danger' : '' }} d-flex flex-column">
                                        <label class="form-control-label" for="input-name">{{ __('Foto de Perfil') }}</label>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="{{ request()->picture ? request()->picture : asset('img/No Profile Picture.png') }}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input{{ $errors->has('photo') ? ' is-invalid' : '' }}" id="input-picture" accept="image/*">
                                                <label class="custom-file-label" for="input-picture">{{ request()->picture ? request()->picture : 'Seleccionar foto de perfil' }}</label>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'photo'])
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-password">{{ __('Contraseña') }}</label>
                                        <input type="password" name="password" id="input-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Contraseña') }}" value="" required>

                                        @include('alerts.feedback', ['field' => 'password'])
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmar Contraseña') }}</label>
                                        <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirmar Contraseña') }}" value="" required>
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
