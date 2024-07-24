@extends('layouts.app', [
    'title' => __('Administración de usuarios'),
    'class' => '',
    'folderActive' => 'laravel-examples',
    'elementActive' => 'user'
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
                                    <h3 class="mb-0">{{ __('Usuarios') }}</h3>
                                    <p class="text-sm mb-0">
                                        {{ __('') }}
                                    </p>
                                </div>
                                @can('create', App\User::class)
                                    <div class="col-4 text-right">
                                        <a href="{{ route('user.create') }}" class="btn btn-sm  btn-primary">{{ __('Agregar Usuario') }}</a>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            @include('alerts.success')
                            @include('alerts.errors')
                        </div>

                        <div class="table-responsive py-4" id="users-table">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Foto</th>
                                        <th scope="col">{{ __('Nombre') }}</th>
                                        <th scope="col">{{ __('Correo') }}</th>
                                        <th scope="col">{{ __('Rol') }}</th>
                                        <th scope="col">{{ __('Fecha de creación') }}</th>
                                        @can('manage-users', App\User::class)
                                            <th scope="col"></th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <span class="avatar avatar-sm rounded-circle">
                                                    <img class="avatar border-gray" src=" https://pactral.com/PuntoAcceso/public{{ $user->profilePicture() }}" alt="...">
                                                </span>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                            </td>
                                            <td>{{ $user->role->name }}</td>
                                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            @can('manage-users', App\User::class)
                                                <td class="text-right">
                                                    @if (auth()->user()->can('update', $user) || auth()->user()->can('delete', $user))
                                                        <div class="dropdown">
                                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="nc-icon nc-bullet-list-67"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                                @if ($user->id != auth()->id())
                                                                    @can('update', $user)
                                                                        <a class="dropdown-item" href="{{ route('user.edit', $user) }}">{{ __('Edit') }}</a>
                                                                    @endcan
                                                                    @can('delete', $user)
                                                                        <form action="{{ route('user.destroy', $user) }}" method="POST">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                                                {{ __('Delete') }}
                                                                            </button>
                                                                        </form>
                                                                    @endcan
                                                                @else
                                                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Edit') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endcan
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