<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publicacion extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     */
    protected $table = 'publicaciones';

    /**
     * Campos asignables.
     */
    protected $fillable = [
        'user_id',
        'contenido',
    ];

    /**
     * Usuario propietario de la publicaciÃ³n.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /**
     * Comentarios de la publicaciÃ³n.
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(
            Comentario::class,
            'publicacion_id'
        );
    }
}
