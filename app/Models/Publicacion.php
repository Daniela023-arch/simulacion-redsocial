
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publicacion extends Model
{
    protected $table = 'publicaciones';
    protected $primaryKey = 'id_publicacion';

    protected $fillable = [
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

    public function comentarios(): HasMany
    {
        return $this->hasMany(
            Comentario::class,
            'id_publicacion',
            'id_publicacion'
        );
    }
}
