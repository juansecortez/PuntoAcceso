<?php
namespace App\Http\Controllers;

use App\Empleado;
use App\Http\Requests\EmpleadoRequest; // Asegúrate de crear esta request
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Contrato; 
use Carbon\Carbon;
use App\Imports\EmpleadosImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Empleado::class);
    }

    /**
     * Display a listing of the empleados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', Empleado::class);

        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new empleado.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Empleado::class);
    
        $contratos = Contrato::all();
        return view('empleados.create', compact('contratos'));
    }
    

      /**
     * Store a newly created empleado in storage.
     *
     * @param  \App\Http\Requests\EmpleadoRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmpleadoRequest $request)
    {
        $this->authorize('create', Empleado::class);
    
        $data = $request->all();
    
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        } else {
            $data['photo'] = null;
        }
    
        // Si el campo 'activo' no está en la solicitud, asigna true por defecto
        $data['activo'] = $request->input('activo', true);
        $data['fecha_baja'] = $data['activo'] ? null : Carbon::today()->toDateString();
    
        Empleado::create($data);
    
        return redirect()->route('empleado.index')->withStatus(__('Empleado successfully created.'));
    }

    
   
    /**
     * Show the form for editing the specified empleado.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\View\View
     */
    public function edit(Empleado $empleado)
    {
        $this->authorize('update', $empleado);
    
        $contratos = Contrato::all();
        return view('empleados.edit', compact('empleado', 'contratos'));
    }
    
    /**
     * Update the specified empleado in storage.
     *
     * @param  \App\Http\Requests\EmpleadoRequest  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmpleadoRequest $request, Empleado $empleado)
    {
        $this->authorize('update', $empleado);
    
        $data = $request->all();
    
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        } else {
            $data['photo'] = $empleado->photo;
        }
    
        // Actualiza el estado del empleado
        $data['activo'] = $request->input('activo', $empleado->activo);
        $data['fecha_baja'] = $data['activo'] ? null : Carbon::today()->toDateString();
    
        $empleado->update($data);
    
        return redirect()->route('empleado.index')->withStatus(__('Empleado successfully updated.'));
    }
    

    /**
     * Remove the specified empleado from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Empleado $empleado)
    {
        $this->authorize('delete', $empleado);

        $empleado->delete();

        return redirect()->route('empleado.index')->withStatus(__('Empleado successfully deleted.'));
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx'
        ]);

        try {
            Excel::import(new EmpleadosImport, $request->file('excelFile'));
            return redirect()->route('empleado.index')->withStatus(__('Empleados importados con éxito.'));
        } catch (\Exception $e) {
            return redirect()->route('empleado.index')->withErrors(__('Error al importar empleados: ' . $e->getMessage()));
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download(public_path('templates/empleados_template.xlsx'), 'empleados_template.xlsx', $headers);
    }
    

    public function toggleActive(Request $request, Empleado $empleado): JsonResponse
{
    $this->authorize('update', $empleado);

    try {
        $isActive = $request->input('activo', false);

        $empleado->activo = $isActive;
        $empleado->fecha_baja = $isActive ? null : Carbon::today()->toDateString();
        $empleado->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}