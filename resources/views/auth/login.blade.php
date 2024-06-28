@extends('layouts.app', [
    'class' => 'login-page',
    'backgroundImagePath' => 'img/bg/fabio-mangione.png',
    'folderActive' => '',
    'elementActive' => ''
])

@section('content')
    <div class="content">
        @if (session('status'))
            <div class="alert alert-warning" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container" style="margin-top: 0px">
            <div class="header-body text-center mb-7">
                 <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-9">
                       

                       
                    </div>
                 
                </div>
            </div>
        </div>
        <div class="container" style="padding-bottom: 150px;">    
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card card-login">
                        <div class="card-header ">
                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Inicio de sesión') }}</h3>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Correo') }}" type="email" name="email" value="{{ old('email') ?? 'admin@paper.com' }}" required autofocus>
                                
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Contraseña') }}" type="password" value="secret" required>
                                
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                     <label class="form-check-label">
                                        <input class="form-check-input" name="remember" type="checkbox" value="" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="form-check-sign"></span>
                                        {{ __('Recuerdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" id="login">
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Entrar') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <a href="{{ route('password.request') }}" class="btn btn-link">
                    {{ __('Olvide la contraseña') }}
                </a>
               
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush