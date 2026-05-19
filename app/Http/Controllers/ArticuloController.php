<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        $query = Articulo::with('categoria');

        $query->when($request->filled('categoria_id'), function ($q) use ($request) {
            return $q->where('categoria_id', $request->categoria_id);
        });


        $articulos = $query->latest()->paginate(10)->withQueryString();


        return view('articulos.index', compact('articulos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('articulos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'estado' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $articulo = new Articulo($request->only('nombre', 'estado', 'ubicacion', 'categoria_id'));

        if ($request->hasFile('foto')) {
            $articulo->foto = $request->file('foto')->store('articulos', 'public');
        }
        $articulo->id = (string) Str::uuid();

        $articulo->save();

        return redirect()->route('articulos.index')
                         ->with('success', 'Artículo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $articulo = Articulo::with('categoria')->findOrFail($id);
        return view('articulos.show', compact('articulo'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articulo = Articulo::with('categoria')->findOrFail($id);
        $categorias = Categoria::all();
        return view('articulos.edit', compact('articulo', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'estado' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $articulo = Articulo::findOrFail($id);
        $articulo->fill($request->only('nombre', 'estado', 'ubicacion', 'categoria_id'));

        if ($request->hasFile('foto')) {
            $articulo->foto = $request->file('foto')->store('articulos', 'public');
        }

        $articulo->save();

        return redirect()->route('articulos.index')
                         ->with('success', 'Artículo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $articulo = Articulo::findOrFail($id);

        // Validar que no tenga préstamos activos
        if ($articulo->prestamos()->where('estado', '!=', 'devuelto')->exists()) {
            return redirect()->route('articulos.index')
                             ->with('error', 'No se puede eliminar un artículo con préstamos activos.');
        }

        $articulo->delete();

        return redirect()->route('articulos.index')
                         ->with('success', 'Artículo eliminado exitosamente.');
    }
}
