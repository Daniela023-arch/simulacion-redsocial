<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     */
    protected $table = 'comentarios';

    /**
     * Campos asignables.
     */
    protected $fillable = [
        'user_id',
        'publicacion_id',
        'contenido',
    ];

    /**
     * Usuario que escribió el comentario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /**
     * Publicación a la que pertenece.
     */
    public function publicacion(): BelongsTo
    {
        return $this->belongsTo(
            Publicacion::class,
            'publicacion_id'
        );
    }
}
