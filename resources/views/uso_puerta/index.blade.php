@extends('layouts.app', [
    'class' => '',
    'folderActive' => '',
    'elementActive' => 'uso_puerta'
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">{{ __('Filtro de Uso de Puertas') }}</h3>
                        </div>
                        <div class="card-body">
                            <form method="get" action="{{ route('uso_puerta.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="FechaInicio">{{ __('Fecha de Inicio') }}</label>
                                            <input type="date" name="FechaInicio" id="FechaInicio" class="form-control" value="{{ request('FechaInicio', $fechaInicio) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="FechaFin">{{ __('Fecha de Fin') }}</label>
                                            <input type="date" name="FechaFin" id="FechaFin" class="form-control" value="{{ request('FechaFin', $fechaFin) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Filtrar') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($usoPuertas) && $usoPuertas->count() > 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0">{{ __('Uso de Puertas') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Nombre') }}</th>
                                                <th>{{ __('Contrato') }}</th>
                                                <th>{{ __('Puerta') }}</th>
                                                <th>{{ __('Tipo') }}</th>
                                                <th>{{ __('Fecha y Hora') }}</th>
                                                <th>{{ __('Mapa') }}</th>
                                                <th>{{ __('Imagen') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usoPuertas as $usoPuerta)
                                                <tr>
                                                    <td>{{ $usoPuerta->empleado->Nombre . ' ' . $usoPuerta->empleado->ApellidoP . ' ' . $usoPuerta->empleado->ApellidoM }}</td>
                                                    <td>{{ $usoPuerta->empleado->NoContrato }}</td>
                                                    <td>{{ $usoPuerta->puerta->NombrePuerta }}</td>
                                                    <td>{{ $usoPuerta->puerta->Tipo }}</td>
                                                    <td>{{ $usoPuerta->Fecha }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mapModal" onclick="showMap({{ $usoPuerta->latitude }}, {{ $usoPuerta->longitud }})">
                                                            {{ __('Ver Mapa') }}
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#imageModal" onclick="showImage('{{ asset('https://pactral.com/PuntoAcceso/public/' . $usoPuerta->img) }}')">
                                                            {{ __('Ver Foto') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination-wrapper">
                                        {{ $usoPuertas->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
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

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">{{ __('Foto') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modal-image" src="" class="img-fluid" alt="Foto">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        function showMap(latitude, longitude) {
            $('#mapModal').on('shown.bs.modal', function () {
                var map = L.map('map').setView([latitude, longitude], 13);

                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '© Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                }).addTo(map);

                L.marker([latitude, longitude]).addTo(map);
            }).modal('show');
        }

        function showImage(imageUrl) {
            document.getElementById('modal-image').src = imageUrl;
            $('#imageModal').modal('show');
        }
    </script>
@endpush