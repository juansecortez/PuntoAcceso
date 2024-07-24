@extends('layouts.app', [
    'title' => __('Perfil de Usuario'),
    'navClass' => 'bg-default',
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'profile'
])

@section('content')
    <div class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('password_status'))
            <div class="alert alert-success" role="alert">
                {{ session('password_status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-4" class="card h-10">
                <div class="card card-user">
                    <div class="image">
                        <img src="{{ asset('img/bg/damir-bosnjak.jpg') }}" alt="...">
                    </div>
                    <div class="card-body">
                        <div class="author">
                            <a href="#">
                                @if(isset(auth()->user()->picture))
                                    <img class="avatar border-gray" src="{{ asset(auth()->user()->picture) }}" alt="...">
                                @else
                                    <img class="avatar border-gray" src="{{ asset('img/No Profile Picture.png') }}" alt="...">
                                @endif

                                <h5 class="title">{{ __(auth()->user()->name)}}</h5>
                            </a>
                            <p class="description">
                               @ {{ __(auth()->user()->name)}}
                            </p>
                        </div>
                        <p class="description text-center">
                            {{ __('Soy usuario tipo') }}
                            <br>  {{ __(auth()->user()->role->name) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 text-center" id="profile-tour">
                @include('alerts.error_self_update', ['key' => 'not_allow_profile'])
                <form class="form-horizontal col-md-12 mx-auto" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Editar perfil') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Nombre') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Nombre" value="{{ auth()->user()->name }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Correo Electrónico') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" value="{{ auth()->user()->email }}" required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail img-circle img-raised">
                                    <img src="{{ auth()->user()->picture ? auth()->user()->picture : asset('img/No Profile Picture.png') }}" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail img-circle img-raised"></div>
                                <div>
                                    <span class="btn btn-raised btn-round btn-default btn-file">
                                        <span class="fileinput-new">{{ __('Agregar Foto') }}</span>
                                        <span class="fileinput-exists">{{ __('Cambiar') }}</span>
                                        <input type="file" name="photo" /></span>
                                    <br />
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>{{ __('Eliminar') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Guardar cambios') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal col-md-12 mx-auto" action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Cambiar Contraseña') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Contraseña Anterior') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="password" name="old_password" class="form-control" placeholder="Contraseña Anterior" required>
                                    </div>
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Nueva Contraseña') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Nueva Contraseña" required>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Confirmar Nueva Contraseña') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Nueva Contraseña" required>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Guardar cambios') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
