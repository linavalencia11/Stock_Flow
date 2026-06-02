<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermisosSeeder extends Seeder
{
    /**
     * Catálogo de permisos según la matriz de funcionalidad StockFlow.
     * Clave: nombre (modulo.funcion). Valor: descripción legible.
     */
    private function catalogoPermisos(): array
    {
        return [
            // Módulo: Acceso
            'acceso.iniciar_sesion' => 'Iniciar sesión en la plataforma',
            'acceso.recuperar_clave' => 'Recuperar contraseña olvidada',
            'acceso.cerrar_sesion' => 'Cerrar sesión',
            'acceso.ver_actualizar_perfil' => 'Ver y actualizar el perfil propio',
            'acceso.cambiar_contraseña' => 'Cambiar la contraseña propia',

            // Módulo: Catálogo
            'catalogo.ver_lista' => 'Ver lista de artículos disponibles',
            'catalogo.buscar_filtrar' => 'Buscar y filtrar artículos',
            'catalogo.ver_detalle' => 'Ver detalle de artículo (foto, estado, ubicación)',

            // Módulo: Préstamos
            'prestamos.solicitar' => 'Solicitar préstamo de un artículo',
            'prestamos.cancelar_solicitud_propia' => 'Cancelar solicitud pendiente propia',
            'prestamos.ver_fecha_limite_devolucion' => 'Ver fecha límite de devolución',
            'prestamos.aprobar_rechazar' => 'Aprobar o rechazar solicitud de préstamo',
            'prestamos.registrar_entrega' => 'Registrar entrega al solicitante',
            'prestamos.registrar_devolucion' => 'Registrar devolución de artículo',
            'prestamos.ver_todos_activos' => 'Ver todos los préstamos activos',

            // Módulo: Gestión de stock
            'stock.agregar_articulo' => 'Agregar artículo al inventario',
            'stock.editar_articulo' => 'Editar información de un artículo',
            'stock.dar_baja_articulo' => 'Dar de baja un artículo',
            'stock.cambiar_estado' => 'Cambiar estado (Disponible, En reparación, Inactivo)',
            'stock.gestionar_categorias' => 'Gestionar categorías',

            // Módulo: Administración
            'administracion.registrar_usuarios' => 'Registrar nuevos usuarios',
            'administracion.editar_usuarios_roles' => 'Editar usuarios y asignar roles',
            'administracion.desactivar_usuarios' => 'Desactivar usuarios',

            // Módulo: Reportes
            'reportes.ver_mis_prestamos' => 'Ver mis préstamos personales',
            'reportes.ver_reporte_general' => 'Ver reporte general de préstamos',
            'reportes.ver_articulos_mas_solicitados' => 'Ver artículos más solicitados',
        ];
    }

    /**
     * Permisos asignados a cada rol según la matriz (sin rol Anónimo).
     */
    private function permisosPorRol(): array
    {
        $acceso = [
            'acceso.iniciar_sesion',
            'acceso.recuperar_clave',
            'acceso.cerrar_sesion',
            'acceso.ver_actualizar_perfil',
            'acceso.cambiar_contraseña',
        ];

        $catalogo = [
            'catalogo.ver_lista',
            'catalogo.buscar_filtrar',
            'catalogo.ver_detalle',
        ];

        return [
            'Solicitante' => array_merge($acceso, $catalogo, [
                'prestamos.solicitar',
                'prestamos.cancelar_solicitud_propia',
                'prestamos.ver_fecha_limite_devolucion',
                'reportes.ver_mis_prestamos',
            ]),
            'Custodio' => array_merge($acceso, $catalogo, [
                'prestamos.ver_fecha_limite_devolucion',
                'prestamos.aprobar_rechazar',
                'prestamos.registrar_entrega',
                'prestamos.registrar_devolucion',
                'prestamos.ver_todos_activos',
                'stock.cambiar_estado',
                'reportes.ver_mis_prestamos',
            ]),
            'Administrador' => array_merge($acceso, $catalogo, [
                'prestamos.ver_todos_activos',
                'stock.agregar_articulo',
                'stock.editar_articulo',
                'stock.dar_baja_articulo',
                'stock.cambiar_estado',
                'stock.gestionar_categorias',
                'administracion.registrar_usuarios',
                'administracion.editar_usuarios_roles',
                'administracion.desactivar_usuarios',
                'reportes.ver_mis_prestamos',
                'reportes.ver_reporte_general',
                'reportes.ver_articulos_mas_solicitados',
            ]),
        ];
    }

    public function run(): void
    {
        foreach ($this->catalogoPermisos() as $nombre => $descripcion) {
            Permiso::query()->updateOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $descripcion],
            );
        }

        $permisosPorId = Permiso::query()->pluck('id', 'nombre');

        foreach ($this->permisosPorRol() as $nombreRol => $nombresPermisos) {
            $rol = Rol::query()->where('nombre', $nombreRol)->first();

            if ($rol === null) {
                $this->command?->warn("Rol «{$nombreRol}» no encontrado; omitiendo asignación de permisos.");

                continue;
            }

            $syncData = [];
            foreach ($nombresPermisos as $nombrePermiso) {
                $permisoId = $permisosPorId[$nombrePermiso] ?? null;
                if ($permisoId === null) {
                    continue;
                }
                $syncData[$permisoId] = ['id' => (string) Str::uuid()];
            }

            $rol->permisos()->sync($syncData);
        }
    }
}
