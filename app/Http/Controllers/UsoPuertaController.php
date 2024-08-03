<?php
namespace App\Http\Controllers;

use App\Empleado;
use App\Puerta;
use App\Contrato;
use App\UsoPuerta;
use Illuminate\Http\Request;
use App\Exports\UsoPuertaExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;

class UsoPuertaController extends Controller
{
    public function assignPuertaToEmpleado($empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $assignedPuertas = $empleado->puertas; // Obtén los objetos completos de las puertas asignadas
        $availablePuertas = Puerta::whereNotIn('id', $assignedPuertas->pluck('id'))->get();

        return view('empleados.assign_puertas', compact('empleado', 'assignedPuertas', 'availablePuertas'));
    }

    public function assignEmpleadoToPuerta($puertaId)
    {
        $puerta = Puerta::findOrFail($puertaId);
        $assignedEmpleados = $puerta->empleados; // Obtén los objetos completos de los empleados asignados
        $availableEmpleados = Empleado::whereNotIn('id', $assignedEmpleados->pluck('id'))->get();

        return view('puertas.assign_empleados', compact('puerta', 'assignedEmpleados', 'availableEmpleados'));
    }

    public function storePuertaToEmpleado(Request $request, $empleadoId, $puertaId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $empleado->puertas()->attach($puertaId);

        return redirect()->route('empleados.assign_puertas', $empleadoId)->with('success', 'Puerta assigned successfully.');
    }

    public function unassignPuertaToEmpleado(Request $request, $empleadoId, $puertaId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $empleado->puertas()->detach($puertaId);

        return redirect()->route('empleados.assign_puertas', $empleadoId)->with('success', 'Puerta unassigned successfully.');
    }

    public function storeEmpleadoToPuerta(Request $request, $puertaId, $empleadoId)
    {
        $puerta = Puerta::findOrFail($puertaId);
        $puerta->empleados()->attach($empleadoId);

        return redirect()->route('puertas.assign_empleados', $puertaId)->with('success', 'Empleado assigned successfully.');
    }

    public function unassignEmpleadoToPuerta(Request $request, $puertaId, $empleadoId)
    {
        $puerta = Puerta::findOrFail($puertaId);
        $puerta->empleados()->detach($empleadoId);

        return redirect()->route('puertas.assign_empleados', $puertaId)->with('success', 'Empleado unassigned successfully.');
    }
    public function assignAllPuertasToEmpleado($empleadoId)
{
    $empleado = Empleado::findOrFail($empleadoId);
    $allPuertas = Puerta::pluck('id')->toArray();
    $empleado->puertas()->sync($allPuertas);

    return redirect()->route('empleados.assign_puertas', $empleadoId)->with('success', 'All puertas assigned successfully.');
}

public function unassignAllPuertasToEmpleado($empleadoId)
{
    $empleado = Empleado::findOrFail($empleadoId);
    $empleado->puertas()->detach();

    return redirect()->route('empleados.assign_puertas', $empleadoId)->with('success', 'All puertas unassigned successfully.');
}
public function assignAllEmpleadosToPuerta($puertaId)
{
    $puerta = Puerta::findOrFail($puertaId);
    $allEmpleados = Empleado::pluck('id')->toArray();
    $puerta->empleados()->sync($allEmpleados);

    return redirect()->route('puertas.assign_empleados', $puertaId)->with('success', 'All empleados assigned successfully.');
}

public function unassignAllEmpleadosToPuerta($puertaId)
{
    $puerta = Puerta::findOrFail($puertaId);
    $puerta->empleados()->detach();

    return redirect()->route('puertas.assign_empleados', $puertaId)->with('success', 'All empleados unassigned successfully.');
}
public function assignSelectedPuertasToAll(Request $request)
{
    $puertaIds = $request->input('puertas', []);
    $allEmpleados = Empleado::all();

    foreach ($allEmpleados as $empleado) {
        $empleado->puertas()->syncWithoutDetaching($puertaIds);
    }

    return redirect()->route('puertas.index')->with('success', 'Selected puertas assigned to all empleados successfully.');
}

public function index(Request $request)
{
    $contratos = Contrato::all();
    $empleados = Empleado::where('activo', true)->get();

    // Establecer fecha de hoy si no se proporcionan fechas
    $fechaInicio = $request->input('FechaInicio', Carbon::today()->toDateString());
    $fechaFin = $request->input('FechaFin', Carbon::today()->toDateString());

    // Log para depuración
    \Log::info('Fecha Inicio solicitada: ' . $request->input('FechaInicio'));
    \Log::info('Fecha Fin solicitada: ' . $request->input('FechaFin'));
    \Log::info('Fecha Inicio usada: ' . $fechaInicio);
    \Log::info('Fecha Fin usada: ' . $fechaFin);

    $query = UsoPuerta::query();

    // Filtrar por fechas
    $query->where('Fecha', '>=', Carbon::parse($fechaInicio)->startOfDay());
    $query->where('Fecha', '<=', Carbon::parse($fechaFin)->endOfDay());

    // Filtrar por empleados activos
    $query->whereHas('empleado', function ($q) {
        $q->where('activo', true);
    });

    if ($request->filled('Contrato')) {
        $query->whereHas('empleado', function ($q) use ($request) {
            $q->where('NoContrato', $request->Contrato);
        });
    }

    if ($request->filled('Empleado')) {
        $empleadosFiltro = $request->Empleado;
        $query->whereHas('empleado', function ($q) use ($empleadosFiltro) {
            $q->whereIn('id', $empleadosFiltro);
        });
    }

    $query->join('empleados', 'uso_puerta.IdEmpleado', '=', 'empleados.id')
          ->orderBy('empleados.Nombre')
          ->orderBy('uso_puerta.Fecha', 'asc');

    $usoPuertas = $query->select('uso_puerta.*')->paginate(60);

    return view('uso_puerta.index', compact('contratos', 'empleados', 'usoPuertas', 'fechaInicio', 'fechaFin'));
}



public function mapaChecadas(Request $request)
{
    $contratos = Contrato::all();
    $empleados = Empleado::where('activo', true)->get();

    // Establecer fechas de hoy si no se proporcionan
    $fechaInicio = $request->input('FechaInicio', Carbon::today()->toDateString());
    $fechaFin = $request->input('FechaFin', Carbon::today()->toDateString());

    $query = UsoPuerta::query();

    // Filtrar por fechas
    $query->where('Fecha', '>=', Carbon::parse($fechaInicio)->startOfDay());
    $query->where('Fecha', '<=', Carbon::parse($fechaFin)->endOfDay());

    // Filtrar por empleados activos
    $query->whereHas('empleado', function ($q) {
        $q->where('activo', true);
    });

    if ($request->filled('Contrato')) {
        $query->whereHas('empleado', function ($q) use ($request) {
            $q->where('NoContrato', $request->Contrato);
        });
    }

    if ($request->filled('Empleado')) {
        $empleadosFiltro = $request->Empleado;
        $query->whereHas('empleado', function ($q) use ($empleadosFiltro) {
            $q->whereIn('id', $empleadosFiltro);
        });
    }

    $usoPuertas = $query->get();

    return view('uso_puerta.mapa_checadas', compact('contratos', 'empleados', 'usoPuertas', 'fechaInicio', 'fechaFin'));
}




public function export(Request $request)
{
    $fechaInicio = $request->input('FechaInicio');
    $fechaFin = $request->input('FechaFin');
    $contrato = $request->input('Contrato');
    $empleadosFiltro = $request->input('Empleado', []);

    // Log para depuración
    \Log::info('Exportar Excel - Fecha Inicio: ' . $fechaInicio);
    \Log::info('Exportar Excel - Fecha Fin: ' . $fechaFin);
    \Log::info('Exportar Excel - Contrato: ' . $contrato);
    \Log::info('Exportar Excel - Empleados: ' . json_encode($empleadosFiltro));

    return Excel::download(new UsoPuertaExport($fechaInicio, $fechaFin, $contrato, $empleadosFiltro), 'uso_puertas.xlsx');
}
public function exportPdf(Request $request)
{
    $fechaInicio = $request->input('FechaInicio');
    $fechaFin = $request->input('FechaFin');
    $empleadosFiltro = $request->input('Empleado', []);
    $usuario = Auth::user()->name;
    $fechaConsulta = Carbon::now()->toDateTimeString();

    // Log para depuración
    \Log::info('Exportar PDF - Fecha Inicio: ' . $fechaInicio);
    \Log::info('Exportar PDF - Fecha Fin: ' . $fechaFin);
    \Log::info('Exportar PDF - Empleados: ' . json_encode($empleadosFiltro));

    $query = UsoPuerta::query()
        ->join('empleados', 'uso_puerta.IdEmpleado', '=', 'empleados.id')
        ->join('puertas', 'uso_puerta.IdPuerta', '=', 'puertas.id')
        ->whereIn('puertas.Tipo', ['Entrada', 'Salida']);

    if ($fechaInicio) {
        $query->where('Fecha', '>=', Carbon::parse($fechaInicio)->startOfDay());
    }

    if ($fechaFin) {
        $query->where('Fecha', '<=', Carbon::parse($fechaFin)->endOfDay());
    }

    if (!empty($empleadosFiltro)) {
        $query->whereIn('empleados.id', $empleadosFiltro);
    }

    $usoPuertas = $query->select(
        'empleados.Nombre',
        'empleados.ApellidoP',
        'empleados.ApellidoM',
        'puertas.NombrePuerta',
        'puertas.Tipo',
        'uso_puerta.Fecha',
        'uso_puerta.latitude',
        'uso_puerta.longitud',
        'uso_puerta.img'
    )
    ->orderBy('empleados.Nombre')
    ->orderBy('uso_puerta.Fecha', 'asc')
    ->get()
    ->groupBy(function($item) {
        return $item->Nombre . ' ' . $item->ApellidoP . ' ' . $item->ApellidoM;
    });

    $pdf = PDF::loadView('uso_puerta.pdf', compact('usoPuertas', 'fechaInicio', 'fechaFin', 'usuario', 'fechaConsulta'))
        ->setPaper('a4')
        ->setOption('margin-top', '10mm')
        ->setOption('margin-bottom', '10mm')
        ->setOption('margin-left', '10mm')
        ->setOption('margin-right', '10mm');

    $fileName = 'ReportAsistencias_' . Carbon::parse($fechaInicio)->format('Ymd') . '_' . Carbon::parse($fechaFin)->format('Ymd') . '.pdf';
    
    return $pdf->download($fileName);
}



}
