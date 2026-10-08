
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    protected $table = 'comentarios';
    protected $primaryKey = 'id_comentario';

    protected $fillable = [
        'id_publicacion',
        'id_usuario',
        'contenido',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function publicacion(): BelongsTo
    {
        return $this->belongsTo(
            Publicacion::class,
            'id_publicacion',
            'id_publicacion'
        );
    }
}
