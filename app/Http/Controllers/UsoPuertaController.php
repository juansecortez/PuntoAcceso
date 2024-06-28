<?php
namespace App\Http\Controllers;

use App\Empleado;
use App\Puerta;
use App\Contrato;
use App\UsoPuerta;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

    // Define las fechas predeterminadas
    $defaultFechaInicio = Carbon::now()->subDay()->startOfDay()->toDateString();
    $defaultFechaFin = Carbon::now()->subDay()->endOfDay()->toDateString();

    // Usa las fechas de la solicitud o las predeterminadas
    $fechaInicio = $request->input('FechaInicio', $defaultFechaInicio);
    $fechaFin = $request->input('FechaFin', $defaultFechaFin);

    $query = UsoPuerta::query();

    $query->where('Fecha', '>=', Carbon::parse($fechaInicio)->startOfDay());
    $query->where('Fecha', '<=', Carbon::parse($fechaFin)->endOfDay());

    if ($request->filled('Contrato')) {
        $query->whereHas('empleado', function ($q) use ($request) {
            $q->where('NoContrato', $request->Contrato);
        });
    }

    $usoPuertas = $query->paginate(60);

    return view('uso_puerta.index', compact('contratos', 'usoPuertas', 'fechaInicio', 'fechaFin'));
}

public function mapaChecadas(Request $request)
{
    $contratos = Contrato::all();

    $query = UsoPuerta::query();

    if ($request->filled('FechaInicio')) {
        $fechaInicio = Carbon::parse($request->FechaInicio)->startOfDay();
        $query->where('Fecha', '>=', $fechaInicio);
    }

    if ($request->filled('FechaFin')) {
        $fechaFin = Carbon::parse($request->FechaFin)->endOfDay();
        $query->where('Fecha', '<=', $fechaFin);
    }

    if ($request->filled('Contrato')) {
        $query->whereHas('empleado', function ($q) use ($request) {
            $q->where('NoContrato', $request->Contrato);
        });
    }

    $usoPuertas = $query->get();

    return view('uso_puerta.mapa_checadas', compact('contratos', 'usoPuertas'));
}
}
