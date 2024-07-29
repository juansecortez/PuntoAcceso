<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Empleado;
use App\Http\Requests\ContratoRequest;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contrato::class);
    }

    /**
     * Display a listing of the contratos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', Contrato::class);

        $contratos = Contrato::all();
        return view('contratos.index', compact('contratos'));
    }

    /**
     * Show the form for creating a new contrato.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Contrato::class);

        return view('contratos.create');
    }

    /**
     * Store a newly created contrato in storage.
     *
     * @param  \App\Http\Requests\ContratoRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContratoRequest $request)
    {
        $this->authorize('create', Contrato::class);

        $data = $request->all();

        Contrato::create($data);

        return redirect()->route('contrato.index')->withStatus(__('Contrato successfully created.'));
    }

    /**
     * Show the form for editing the specified contrato.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\View\View
     */
    public function edit(Contrato $contrato)
    {
        $this->authorize('update', $contrato);

        return view('contratos.edit', compact('contrato'));
    }

    /**
     * Update the specified contrato in storage.
     *
     * @param  \App\Http\Requests\ContratoRequest  $request
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContratoRequest $request, Contrato $contrato)
    {
        $this->authorize('update', $contrato);
    
        $data = $request->all();
        
        // Guardar el valor anterior del contrato
        $oldNoContrato = $contrato->NoContrato;
        
        // Actualizar el contrato
        $contrato->update($data);
        
        // Si el número de contrato cambió, actualizar los empleados asociados
        if ($oldNoContrato != $data['NoContrato']) {
            Empleado::where('NoContrato', $oldNoContrato)
                    ->update(['NoContrato' => $data['NoContrato']]);
        }
    
        return redirect()->route('contrato.index')->withStatus(__('Contrato successfully updated.'));
    }

    /**
     * Remove the specified contrato from storage.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contrato $contrato)
    {
        $this->authorize('delete', $contrato);

        $contrato->delete();

        return redirect()->route('contrato.index')->withStatus(__('Contrato successfully deleted.'));
    }
}
