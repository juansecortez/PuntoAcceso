<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrganizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', Organization::class);

        $organizacion = Organization::first();
        return view('organizacion.edit', compact('organizacion'));
    }

    public function update(OrganizationRequest $request)
    {
        $this->authorize('update', Organization::class);

        $data = $request->validated();

        $organizacion = Organization::first();

        if (!$organizacion) {
            $organizacion = new Organization();
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        } else {
            $data['banner'] = $organizacion->banner;
        }

        $organizacion->fill($data);
        $organizacion->save();

        return redirect()->route('organizacion.edit')->withStatus(__('Organización actualizada con éxito.'));
    }
}
