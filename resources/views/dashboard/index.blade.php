@extends('layouts.app',[
    'class' => '',
    'folderActive' => '',
    'elementActive' => 'dashboard'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-paper text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Contratos</p>
                                    <p class="card-title">{{ $contratosCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> 
                            <a href="#" onclick="location.reload();">Actualizar ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-single-02 text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Empleados</p>
                                    <p class="card-title">{{ $empleadosCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> 
                            <a href="#" onclick="location.reload();">Actualizar ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-vector text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Puertas de Entrada</p>
                                    <p class="card-title">{{ $puertasEntradaCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> 
                            <a href="#" onclick="location.reload();">Actualizar ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-vector text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Puertas de Salida</p>
                                    <p class="card-title">{{ $puertasSalidaCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> 
                            <a href="#" onclick="location.reload();">Actualizar ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <form method="get" action="{{ route('home') }}" style="display: inline-block;">
                    <div class="form-group" style="display: flex; align-items: center;">
                        <label for="year" style="margin-right: 10px;">{{ __('Año') }}</label>
                        <select name="year" id="year" class="form-control" style="width: auto;">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;">{{ __('Filtrar') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Uso de Puertas de Entrada por Mes ({{ $year }})</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="usoEntradaChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Uso de Puertas de Salida por Mes ({{ $year }})</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="usoSalidaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Empleados por Contrato</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="empleadosContratoChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Uso de Puertas por Contrato</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="usoPuertasContratoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctxEntrada = document.getElementById('usoEntradaChart').getContext('2d');
        var usoEntradaChart = new Chart(ctxEntrada, {
            type: 'bar',
            data: {
                labels: @json(array_keys($usoEntrada->toArray())),
                datasets: [{
                    label: 'Uso de Puertas de Entrada',
                    data: @json(array_values($usoEntrada->toArray())),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => value
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxSalida = document.getElementById('usoSalidaChart').getContext('2d');
        var usoSalidaChart = new Chart(ctxSalida, {
            type: 'bar',
            data: {
                labels: @json(array_keys($usoSalida->toArray())),
                datasets: [{
                    label: 'Uso de Puertas de Salida',
                    data: @json(array_values($usoSalida->toArray())),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => value
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxEmpleadosContrato = document.getElementById('empleadosContratoChart').getContext('2d');
        var empleadosContratoChart = new Chart(ctxEmpleadosContrato, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($empleadosPorContrato->toArray())),
                datasets: [{
                    label: 'Empleados por Contrato',
                    data: @json(array_values($empleadosPorContrato->toArray())),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        formatter: (value, context) => value
                    }
                }
            }
        });

        var ctxUsoPuertasContrato = document.getElementById('usoPuertasContratoChart').getContext('2d');
        var usoPuertasContratoChart = new Chart(ctxUsoPuertasContrato, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($usoPuertasPorContrato->toArray())),
                datasets: [{
                    label: 'Uso de Puertas por Contrato',
                    data: @json(array_values($usoPuertasPorContrato->toArray())),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        formatter: (value, context) => value
                    }
                }
            }
        });
    });
</script>
@endpush
