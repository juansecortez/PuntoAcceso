@extends('layouts.app', [
    'class' => '',
    'folderActive' => '',
    'elementActive' => 'mapa_checadas'
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">{{ __('Mapa de asistencias') }}</h3>
                        </div>
                        <div class="card-body">
                            <form method="get" action="{{ route('mapa_checadas') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="FechaInicio">{{ __('Fecha de Inicio') }}</label>
                                            <input type="date" name="FechaInicio" id="FechaInicio" class="form-control" value="{{ request('FechaInicio') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="FechaFin">{{ __('Fecha de Fin') }}</label>
                                            <input type="date" name="FechaFin" id="FechaFin" class="form-control" value="{{ request('FechaFin') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Contrato">{{ __('Contrato') }}</label>
                                            <select name="Contrato" id="Contrato" class="form-control">
                                                <option value="">{{ __('Seleccione un contrato') }}</option>
                                                @foreach($contratos as $contrato)
                                                    <option value="{{ $contrato->NoContrato }}" {{ request('Contrato') == $contrato->NoContrato ? 'selected' : '' }}>
                                                        {{ $contrato->NoContrato }} - {{ $contrato->NombreContrato }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Empleado">{{ __('Empleado') }}</label>
                                            <select name="Empleado[]" id="Empleado" class="form-control" multiple="multiple">
                                                @foreach($empleados as $empleado)
                                                    <option value="{{ $empleado->id }}" {{ in_array($empleado->id, request('Empleado', [])) ? 'selected' : '' }}>
                                                        {{ $empleado->Nombre . ' ' . $empleado->ApellidoP . ' ' . $empleado->ApellidoM }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Filtrar') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($usoPuertas->count() > 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0">{{ __('Mapa de Checadas') }}</h3>
                            </div>
                            <div class="card-body">
                                <div id="map" style="height: 600px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-warning" role="alert">
                                    {{ __('No se encontraron registros para los filtros seleccionados.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('#Empleado').select2({
                placeholder: "{{ __('Seleccione empleados') }}",
                allowClear: true
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([19.3737, -104.0135], 15);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles © Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            }).addTo(map);

            @foreach($usoPuertas as $usoPuerta)
                L.marker([{{ $usoPuerta->latitude }}, {{ $usoPuerta->longitud }}])
                    .addTo(map)
                    .bindPopup(
                        '<strong>{{ $usoPuerta->empleado->Nombre . " " . $usoPuerta->empleado->ApellidoP . " " . $usoPuerta->empleado->ApellidoM }}</strong><br>' +
                        '{{ $usoPuerta->Fecha }}<br>' +
                        '{{ $usoPuerta->puerta->NombrePuerta }}<br>' +
                        '{{ $usoPuerta->puerta->Tipo }}'
                    );
            @endforeach
        });
    </script>
@endpush
