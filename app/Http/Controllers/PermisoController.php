<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;

class PermisoController extends Controller
{
    public function index(Request $request)
    {
        $query = Permiso::query();

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $permisos = $query->paginate(10)->withQueryString();
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permisos,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Permiso::create($request->only('nombre', 'descripcion'));

        return redirect()->route('permisos.index')
                         ->with('success', 'Permiso creado exitosamente.');
    }

    public function show(string $id)
    {
        $permiso = Permiso::with('roles')->findOrFail($id);
        return view('permisos.show', compact('permiso'));
    }

    public function edit(string $id)
    {
        $permiso = Permiso::findOrFail($id);
        return view('permisos.edit', compact('permiso'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permisos,nombre,' . $id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $permiso = Permiso::findOrFail($id);
        $permiso->update($request->only('nombre', 'descripcion'));

        return redirect()->route('permisos.index')
                         ->with('success', 'Permiso actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $permiso = Permiso::findOrFail($id);

        if ($permiso->roles()->count() > 0) {
            return redirect()->route('permisos.index')
                             ->with('error', 'No se puede eliminar el permiso porque está asignado a uno o más roles.');
        }

        $permiso->delete();

        return redirect()->route('permisos.index')
                         ->with('success', 'Permiso eliminado exitosamente.');
    }
}
