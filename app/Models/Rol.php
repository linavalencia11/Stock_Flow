<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Usuario;

class Rol extends Model
{
    protected $table = 'roles';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nombre'];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class);
    }

    /** Permisos asignados a este rol (RBAC). */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'rol_permiso', 'rol_id', 'permiso_id');
    }
}
