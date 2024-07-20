@extends('layouts.app', [
    'title' => __('Administración de Organización'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'organizacion'
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
                                    <h3 class="mb-0">{{ __('Administración de Organización') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('organizacion.update') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <h6 class="heading-small text-muted mb-4">{{ __('Información de la Organización') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre') }}" value="{{ old('name', $organizacion->name ?? '') }}" required autofocus>
                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>
                                    <div class="form-group{{ $errors->has('banner') ? ' has-danger' : '' }} d-flex flex-column">
                                        <label class="form-control-label" for="input-banner">{{ __('Banner') }}</label>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="{{ isset($organizacion->banner) ? asset('storage/' . $organizacion->banner) : asset('img/no-image.png') }}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div class="custom-file">
                                                <input type="file" name="banner" class="custom-file-input{{ $errors->has('banner') ? ' is-invalid' : '' }}" id="input-banner" accept="image/*">
                                                <label class="custom-file-label" for="input-banner">{{ isset($organizacion->banner) ? $organizacion->banner : 'Seleccione una imagen' }}</label>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'banner'])
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
