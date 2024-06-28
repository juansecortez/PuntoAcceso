<?php
namespace App\Http\Controllers;

use App\Puerta;
use Illuminate\Http\Request;

class PuertaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Puerta::class);
        $puertas = Puerta::all();
        return view('puertas.index', compact('puertas'));
    }

    public function create()
    {
        $this->authorize('create', Puerta::class);
        return view('puertas.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Puerta::class);
    
        $request->validate([
            'NombrePuerta' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitud' => 'required|numeric',
            'Tipo' => 'required|string|max:255',
        ]);
    
        Puerta::create($request->all());
    
        return redirect()->route('puertas.index')->with('success', 'Puerta created successfully.');
    }
    

    public function edit(Puerta $puerta)
    {
        $this->authorize('update', $puerta);
        return view('puertas.edit', compact('puerta'));
    }

    public function update(Request $request, Puerta $puerta)
    {
        $this->authorize('update', $puerta);

        $request->validate([
            'NombrePuerta' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitud' => 'required|numeric',
            'Tipo' => 'required|string|max:255',
        ]);

        $puerta->update($request->all());

        return redirect()->route('puertas.index')->with('success', 'Puerta updated successfully.');
    }

    public function destroy(Puerta $puerta)
    {
        $this->authorize('delete', $puerta);
        $puerta->delete();

        return redirect()->route('puertas.index')->with('success', 'Puerta deleted successfully.');
    }
}
