<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('rol');

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('email', 'like', '%' . $request->buscar . '%');
            });
        }
        if ($request->filled('rol_id')) {
            $query->where('rol_id', $request->rol_id);
        }
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $usuarios = $query->paginate(10)->withQueryString();
        $roles    = Rol::all();
        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id'       => 'required|string|max:255|unique:usuarios,id',
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'contacto' => 'nullable|string|max:255',
            'rol_id'   => 'required|exists:roles,id',
        ]);

        Usuario::create($request->only('id', 'nombre', 'email', 'password', 'contacto', 'rol_id'));

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(string $id)
    {
        $usuario = Usuario::with('rol')->findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles   = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'contacto' => 'nullable|string|max:255',
            'rol_id'   => 'required|exists:roles,id',
            'activo'   => 'boolean',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->fill($request->only('nombre', 'email', 'contacto', 'rol_id'));
        $usuario->activo = $request->boolean('activo');

        if ($request->filled('password')) {
            $usuario->password = $request->password;
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        if ($usuario->prestamos()->whereNotIn('estado', ['devuelto', 'rechazado', 'cancelado'])->exists()) {
            return redirect()->route('usuarios.index')
                             ->with('error', 'No se puede eliminar un usuario con préstamos activos.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario eliminado exitosamente.');
    }
}
