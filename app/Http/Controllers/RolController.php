<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $query = Rol::withCount('usuarios');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $roles = $query->with('permisos')->paginate(10)->withQueryString();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $todosLosPermisos = Permiso::all();
        return view('roles.create', compact('todosLosPermisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permisos,id',
        ]);

        $rol = new Rol($request->only('nombre'));
        $rol->id = (string) Str::uuid();
        $rol->save();

        $rol->permisos()->sync($request->input('permisos', []));

        return redirect()->route('roles.index')
                         ->with('success', 'Rol creado exitosamente.');
    }

    public function show(string $id)
    {
        $rol = Rol::with('usuarios' , 'permisos')->findOrFail($id);
        return view('roles.show', compact('rol'));
    }

    public function edit(string $id)
    {

        $rol = Rol::findOrFail($id);
        $todosLosPermisos = Permiso::all();

        return view('roles.edit', compact('rol', 'todosLosPermisos'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $id,
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permisos,id',
        ]);

        $rol = Rol::findOrFail($id);
        $rol->update($request->only('nombre'));
        $rol->permisos()->sync($request->input('permisos', []));

        return redirect()->route('roles.index')
                         ->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $rol = Rol::findOrFail($id);

        if ($rol->usuarios()->exists()) {
            return redirect()->route('roles.index')
                             ->with('error', 'No se puede eliminar un rol que tiene usuarios asignados.');
        }

        $rol->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'Rol eliminado exitosamente.');
    }
}
