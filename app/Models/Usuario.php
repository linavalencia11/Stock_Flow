<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Prestamo;
use App\Models\Rol;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nombre', 'email', 'password', 'contacto', 'rol_id'];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = [
        'password' => 'hashed',
        'activo'   => 'boolean',
    ];
    public function getRememberTokenName(): string
    {
        return '';
    }

    public function setRememberToken($value): void
    {
        // la tabla usuarios no tiene columna remember_token
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'solicitante_id');
    }

    /**
     * Comprueba si el rol del usuario incluye el permiso indicado.
     *
     * @param  string  $permisoNombre  Nombre del permiso (ej: 'prestamos.aprobar')
     */
    public function tienePermiso(string $permisoNombre): bool
    {
        if ($this->rol_id === null) {
            return false;
        }

        return $this->rol()
            ->whereHas('permisos', fn ($query) => $query->where('permisos.nombre', $permisoNombre))
            ->exists();
    }
}
