@extends('layouts.app', [
    'title' => __('Editar Puerta'),
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
                                    <h3 class="mb-0">{{ __('Editar Puerta') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('puertas.index') }}" class="btn btn-sm btn-primary">{{ __('Regresar a la lista') }}</a>
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
                                        <label class="form-control-label" for="input-latitude">{{ __('Latitud') }}</label>
                                        <div class="input-group">
                                            <input type="text" name="latitude" id="input-latitude" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Latitud') }}" value="{{ old('latitude', $puerta->latitude) }}" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mapModal">
                                                    <i class="nc-icon nc-pin-3"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @include('alerts.feedback', ['field' => 'latitude'])
                                    </div>
                                    <div class="form-group{{ $errors->has('longitud') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-longitud">{{ __('Longitud') }}</label>
                                        <div class="input-group">
                                            <input type="text" name="longitud" id="input-longitud" class="form-control{{ $errors->has('longitud') ? ' is-invalid' : '' }}" placeholder="{{ __('Longitud') }}" value="{{ old('longitud', $puerta->longitud) }}" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mapModal">
                                                    <i class="nc-icon nc-pin-3"></i>
                                                </button>
                                            </div>
                                        </div>
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

    <!-- Map Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">{{ __('Mapa') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map;
        var marker;

        $('#mapModal').on('shown.bs.modal', function () {
            if (!map) {
                map = L.map('map').setView([19.36840142540269, -104.10091443763574], 13); // Inicializa en Minatitlán, Colima, México

                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 17,
                    attribution: '© Esri'
                }).addTo(map);

                map.on('click', function (e) {
                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }
                    document.getElementById('input-latitude').value = e.latlng.lat;
                    document.getElementById('input-longitud').value = e.latlng.lng;
                });
            } else {
                setTimeout(function() {
                    map.invalidateSize();
                }, 100);
            }
        });
    </script>
@endpush
