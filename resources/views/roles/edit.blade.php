@extends('layouts.app', [
    'title' => __('Role Management'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'role'
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
                                    <h3 class="mb-0">{{ __('Role Management') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('role.index') }}" class="btn btn-sm btn-primary">{{ __('Regresar a la lista ') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('role.update', $role) }}" autocomplete="off">
                                @csrf
                                @method('put')

                                <h6 class="heading-small text-muted mb-4">{{ __('Role information') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $role->name) }}" required autofocus>

                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                                        <textarea name="description" id="input-description" cols="30" rows="10" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" required>{{ old('description', $role->description) }}</textarea>

                                        @include('alerts.feedback', ['field' => 'description'])
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