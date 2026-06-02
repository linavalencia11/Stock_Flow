<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Articulo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    // Solicitante, Custodio, Administrador
    public function misPrestamos()
    {
        $rol   = auth()->user()->rol->nombre;
        $query = Prestamo::with(['articulos', 'solicitante', 'custodio'])->latest();

        if ($rol === 'Solicitante') {
            $query->where('solicitante_id', auth()->id());
        } elseif ($rol === 'Custodio') {
            $query->where('custodio_id', auth()->id());
        }
        // Administrador ve todos

        $prestamos = $query->get();

        $resumen = [
            'total'     => $prestamos->count(),
            'activos'   => $prestamos->whereIn('estado', ['pendiente', 'aprobado', 'entregado'])->count(),
            'devueltos' => $prestamos->where('estado', 'devuelto')->count(),
            'cancelados'=> $prestamos->whereIn('estado', ['rechazado', 'cancelado'])->count(),
        ];

        return view('reportes.mis-prestamos', compact('prestamos', 'rol', 'resumen'));
    }

    // Solo Administrador
    public function reporteGeneral()
    {
        $porEstado = Prestamo::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $totalPrestamos = Prestamo::count();

        $prestamosRecientes = Prestamo::with(['articulos', 'solicitante', 'custodio'])
            ->latest()
            ->take(10)
            ->get();

        $porMes = Prestamo::selectRaw("strftime('%m/%Y', created_at) as mes, count(*) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupByRaw("strftime('%m/%Y', created_at)")
            ->orderByRaw("strftime('%Y-%m', created_at)")
            ->pluck('total', 'mes');

        return view('reportes.general', compact('totalPrestamos', 'porEstado', 'prestamosRecientes', 'porMes'));
    }

    // Solo Administrador
    public function articulosSolicitados()
    {
        $articulos = Articulo::withCount('prestamos')
            ->with('categoria')
            ->orderByDesc('prestamos_count')
            ->paginate(15)->withQueryString();

        return view('reportes.articulos-solicitados', compact('articulos'));
    }
}
