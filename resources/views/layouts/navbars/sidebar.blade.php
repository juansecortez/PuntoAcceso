<div class="sidebar" data-color="brown" data-active-color="danger">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
    <div class="logo">
        <a class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('img/logo-small.png') }}">
            </div>
        </a>
        <a class="simple-text logo-normal">
            {{ __('PUNTOACCESO') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                @if (isset(auth()->user()->picture))
                    <img src="{{ asset(auth()->user()->picture) }}">
                @else
                    <img class="avatar border-gray" src="{{ asset('img/No Profile Picture.png') }}" alt="...">
                @endif
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        {{ auth()->user()->name }}
                    <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse {{ $folderActive == 'profile' ? 'show' : '' }}" id="collapseExample">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'edit-profile' ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __('MP') }}</span>
                                <span class="sidebar-normal">{{ __('Mi Perfil') }}</span>
                            </a>
                        </li>
                        <li>
                            <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOutSidebar" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a onclick="document.getElementById('formLogOutSidebar').submit();">
                                <span class="sidebar-mini-icon">{{ __('CS') }}</span>
                                <span class="sidebar-normal">{{ __('Cerrar sesión') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                @if (Auth::user()->role_id <= 2)
                <a href="{{ route('home') }}">
                    <i class="nc-icon nc-world-2"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
                @endif
                <a href="{{ route('uso_puerta.index') }}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>{{ __('Consulta de asistencias') }}</p>
                </a>
                <a href="{{ route('mapa_checadas') }}">
                    <i class="nc-icon nc-map-big"></i>
                    <p>{{ __('Mapa de asistencias') }}</p>
                </a>
            </li>
            @if (Auth::user()->role_id <= 2)
            <li class="{{ $folderActive == 'laravel-examples' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExamples">
                <i class="nc-icon nc-briefcase-24"></i>
                    <p>
                            {{ __('Módulos') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __('M') }}</span>
                                <span class="sidebar-normal">{{ __(' Mi Perfil ') }}</span>
                            </a>
                        </li>
                    
                        @if (Auth::user()->role_id == 1)
                            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                                <a href="{{ route('page.index', 'user') }}">
                                    <span class="sidebar-mini-icon">{{ __('U') }}</span>
                                    <span class="sidebar-normal">{{ __(' Administración de Usuarios ') }}</span>
                                </a>
                            </li>
                        @endif
                        <li class="{{ $elementActive == 'contratos' ? 'active' : '' }}">
                            <a href="{{ route('page.index', 'contrato') }}">
                                <span class="sidebar-mini-icon">{{ __('C') }}</span>
                                <span class="sidebar-normal">{{ __(' Contratos ') }}</span>
                            </a>
                        </li>
                            <li class="{{ $elementActive == 'empleados' ? 'active' : '' }}">
                                <a href="{{ route('page.index', 'empleado') }}">
                                    <span class="sidebar-mini-icon">{{ __('E') }}</span>
                                    <span class="sidebar-normal">{{ __(' Empledos ') }}</span>
                                </a>
                            </li>
                       
                        
                            <li class="{{ $elementActive == 'puertas' ? 'active' : '' }}">
                                <a href="{{ route('page.index', 'puertas') }}">
                                    <span class="sidebar-mini-icon">{{ __('P') }}</span>
                                    <span class="sidebar-normal">{{ __(' Puertas ') }}</span>
                                </a>
                            </li>
                          
                      
                    </ul>
                </div>
            </li>
            @endif
       </ul>
    </div>
</div>