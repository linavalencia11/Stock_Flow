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
    /*
    public function getRememberTokenName(): string
    {
        return '';
    }*/

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'solicitante_id');
    }
}
