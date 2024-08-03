<?php
namespace App\Http\Controllers;

use App\Contrato;
use App\Empleado;
use App\Puerta;
use App\UsoPuerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $years = UsoPuerta::selectRaw('YEAR(Fecha) as year')->distinct()->pluck('year');
        $year = $request->input('year', $years->first() ?? date('Y')); // Usa el primer año disponible o el año actual como default
    
        $contratosCount = Contrato::count();

        // Contar solo los empleados activos
        $empleadosCount = Empleado::where('activo', true)->count();
        
        $puertasEntradaCount = Puerta::where('Tipo', 'Entrada')->count();
        $puertasSalidaCount = Puerta::where('Tipo', 'Salida')->count();
    
        $usoEntrada = UsoPuerta::select(
            DB::raw('MONTH(Fecha) as mes'),
            DB::raw('COUNT(*) as conteo')
        )
        ->join('puertas', 'uso_puerta.IdPuerta', '=', 'puertas.id')
        ->join('empleados', 'uso_puerta.IdEmpleado', '=', 'empleados.id')
        ->where('empleados.activo', true) // Filtrar por empleados activos
        ->where('puertas.Tipo', 'Entrada')
        ->whereYear('Fecha', $year)
        ->groupBy(DB::raw('MONTH(Fecha)'))
        ->pluck('conteo', 'mes');
    
        $usoSalida = UsoPuerta::select(
            DB::raw('MONTH(Fecha) as mes'),
            DB::raw('COUNT(*) as conteo')
        )
        ->join('puertas', 'uso_puerta.IdPuerta', '=', 'puertas.id')
        ->join('empleados', 'uso_puerta.IdEmpleado', '=', 'empleados.id')
        ->where('empleados.activo', true) // Filtrar por empleados activos
        ->where('puertas.Tipo', 'Salida')
        ->whereYear('Fecha', $year)
        ->groupBy(DB::raw('MONTH(Fecha)'))
        ->pluck('conteo', 'mes');
    
        // Calcular empleados por contrato (solo empleados activos)
        $empleadosPorContrato = Empleado::select('NoContrato', DB::raw('COUNT(*) as conteo'))
            ->where('activo', true)
            ->groupBy('NoContrato')
            ->pluck('conteo', 'NoContrato');
    
        // Calcular uso de puertas por contrato (solo empleados activos)
        $usoPuertasPorContrato = UsoPuerta::select('empleados.NoContrato', DB::raw('COUNT(*) as conteo'))
            ->join('empleados', 'uso_puerta.IdEmpleado', '=', 'empleados.id')
            ->where('empleados.activo', true) // Filtrar por empleados activos
            ->whereYear('uso_puerta.Fecha', $year)
            ->groupBy('empleados.NoContrato')
            ->pluck('conteo', 'empleados.NoContrato');
    
        // Convertir números de meses a nombres de meses
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
    
        $usoEntrada = $usoEntrada->mapWithKeys(function ($value, $key) use ($meses) {
            return [$meses[$key] => $value];
        });
    
        $usoSalida = $usoSalida->mapWithKeys(function ($value, $key) use ($meses) {
            return [$meses[$key] => $value];
        });
    
        return view('dashboard.index', compact(
            'contratosCount', 'empleadosCount', 'puertasEntradaCount', 'puertasSalidaCount',
            'usoEntrada', 'usoSalida', 'empleadosPorContrato', 'usoPuertasPorContrato', 'year', 'years'
        ));
    }
}
