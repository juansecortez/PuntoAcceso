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
                        <h3 class="mb-0">{{ __('Consulta de asistencias') }}</h3>
                    </div>
                    <div class="card-body">
                        <form id="mainForm" method="get" action="{{ route('uso_puerta.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="FechaInicio">{{ __('Fecha de Inicio') }}</label>
                                        <input type="date" name="FechaInicio" id="FechaInicio" class="form-control" value="{{ old('FechaInicio', $fechaInicio) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="FechaFin">{{ __('Fecha de Fin') }}</label>
                                        <input type="date" name="FechaFin" id="FechaFin" class="form-control" value="{{ old('FechaFin', $fechaFin) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Contrato">{{ __('Contrato') }}</label>
                                        <select name="Contrato" id="Contrato" class="form-control">
                                            <option value="">{{ __('Seleccione un contrato') }}</option>
                                            @foreach($contratos as $contrato)
                                                <option value="{{ $contrato->NoContrato }}" {{ old('Contrato', request('Contrato')) == $contrato->NoContrato ? 'selected' : '' }}>
                                                    {{ $contrato->NoContrato }}
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
                                                <option value="{{ $empleado->id }}" {{ in_array($empleado->id, old('Empleado', request('Empleado', []))) ? 'selected' : '' }}>
                                                    {{ $empleado->Nombre . ' ' . $empleado->ApellidoP . ' ' . $empleado->ApellidoM }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Filtrar') }}</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" onclick="exportData('excel')" class="btn btn-success w-100 mt-2">
                                        <i class="fa fa-file-excel-o"></i> {{ __('Exportar a Excel') }}
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" onclick="exportData('pdf')" class="btn btn-danger w-100 mt-2">
                                        <i class="fa fa-file-pdf-o"></i> {{ __('Exportar a PDF') }}
                                    </button>
                                </div>
                            </div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        // Configuración para Select2
        $('#Empleado').select2({
            placeholder: "{{ __('Seleccione empleados') }}",
            allowClear: true
        });

        window.exportData = function(type) {
            var form = document.getElementById('mainForm');
            if (type === 'excel') {
                form.action = '{{ route('uso_puerta.export') }}';
            } else if (type === 'pdf') {
                form.action = '{{ route('uso_puerta.exportPdf') }}';
            }
            form.submit();
        }

        window.showMap = function(latitude, longitude) {
            $('#mapModal').on('shown.bs.modal', function () {
                var map = L.map('map').setView([latitude, longitude], 13);
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '© Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                }).addTo(map);
                L.marker([latitude, longitude]).addTo(map);
            }).modal('show');
        }

        window.showImage = function(imageUrl) {
            document.getElementById('modal-image').src = imageUrl;
            $('#imageModal').modal('show');
        }
    });
</script>
@endpush
@endsection
