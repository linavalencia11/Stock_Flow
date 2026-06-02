<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Articulo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestamo::with(['articulos', 'solicitante', 'custodio'])->latest();

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('buscar')) {
            $query->whereHas('solicitante', fn ($q) => $q->where('nombre', 'like', '%' . $request->buscar . '%'));
        }

        $prestamos = $query->paginate(10)->withQueryString();
        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $articulos    = Articulo::where('estado', 'disponible')->where('activo', true)->get();
        $solicitantes = Usuario::where('activo', true)->with('rol')->get();
        $custodios    = Usuario::whereHas('rol', fn ($q) => $q->where('nombre', 'Custodio'))
                               ->where('activo', true)->get();

        return view('prestamos.create', compact('articulos', 'solicitantes', 'custodios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'articulo_id'    => 'required|exists:articulos,id',
            'solicitante_id' => 'required|exists:usuarios,id',
            'custodio_id'    => 'required|exists:usuarios,id',
            'fecha_limite'   => 'required|date|after:today',
        ]);

        // Verificar que el artículo sigue disponible
        $articulo = Articulo::findOrFail($request->articulo_id);
        if ($articulo->estado !== 'disponible') {
            return back()->withErrors(['articulo_id' => 'El artículo ya no está disponible.'])->withInput();
        }
        $prestamo = new Prestamo($request->only('articulo_id', 'solicitante_id', 'custodio_id', 'fecha_limite'));
        $prestamo->id = (string) Str::uuid();
        $prestamo->estado = 'pendiente';

        $prestamo->save();

        $ruta = auth()->user()->tienePermiso('prestamos.ver_todos_activos')
            ? 'prestamos.index'
            : 'prestamos.usuario';

        return redirect()->route($ruta)
                         ->with('success', 'Solicitud de préstamo creada exitosamente.');
    }

    public function show(string $id)
    {
        $prestamo = Prestamo::with(['articulos', 'solicitante', 'custodio'])->findOrFail($id);
        return view('prestamos.show', compact('prestamo'));
    }

    public function edit(string $id)
    {
        $prestamo     = Prestamo::with(['articulos', 'solicitante', 'custodio'])->findOrFail($id);
        $custodios    = Usuario::whereHas('rol', fn ($q) => $q->where('nombre', 'Custodio'))
                               ->where('activo', true)->get();
        $estados      = ['pendiente', 'aprobado', 'entregado', 'devuelto', 'rechazado', 'cancelado'];
        $estadosDevolucion = ['bueno', 'deteriorado', 'dañado'];

        return view('prestamos.edit', compact('prestamo', 'custodios', 'estados', 'estadosDevolucion'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado'           => 'required|in:pendiente,aprobado,entregado,devuelto,rechazado,cancelado',
            'custodio_id'      => 'required|exists:usuarios,id',
            'fecha_entrega'    => 'nullable|date',
            'fecha_limite'     => 'nullable|date',
            'fecha_devolucion' => 'nullable|date',
            'estado_devolucion'=> 'nullable|in:bueno,deteriorado,dañado',
        ]);

        $prestamo = Prestamo::with('articulos')->findOrFail($id);

        $prestamo->fill($request->only(
            'estado', 'custodio_id', 'fecha_entrega', 'fecha_limite', 'fecha_devolucion', 'estado_devolucion'
        ));
        $prestamo->save();

        // Sincronizar estado del artículo
        $articulo = $prestamo->articulos;
        if ($articulo) {
            if ($prestamo->estado === 'entregado') {
                $articulo->estado = 'en_prestamo';
                $articulo->save();
            } elseif (in_array($prestamo->estado, ['devuelto', 'rechazado', 'cancelado'])) {
                $articulo->estado = 'disponible';
                $articulo->save();
            }
        }

        return redirect()->route('prestamos.show', $prestamo->id)
                         ->with('success', 'Préstamo actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if (in_array($prestamo->estado, ['entregado'])) {
            return redirect()->route('prestamos.index')
                             ->with('error', 'No se puede eliminar un préstamo en curso (entregado).');
        }

        $prestamo->delete();

        return redirect()->route('prestamos.index')
                         ->with('success', 'Préstamo eliminado exitosamente.');
    }

    public function cancelar(string $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->solicitante_id !== auth()->id()) {
            abort(403);
        }

        if ($prestamo->estado !== 'pendiente') {
            return back()->with('error', 'Solo puedes cancelar solicitudes en estado pendiente.');
        }

        $prestamo->estado = 'cancelado';
        $prestamo->save();

        return redirect()->route('prestamos.usuario')
                         ->with('success', 'Solicitud cancelada exitosamente.');
    }

    public function misPrestamos()
    {

        $prestamos = Prestamo::with(['articulos', 'custodio'])
            ->where('solicitante_id', auth()->id())
            ->latest()
            ->get();


        return view('prestamos.mis-prestamos', compact('prestamos'));
    }
}
