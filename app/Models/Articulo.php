<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Prestamo;
use App\Models\Categoria;

class Articulo extends Model
{
    protected $table = 'articulos';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'nombre',
        'foto',
        'estado',
        'ubicacion',
        'categoria_id',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'articulo_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
