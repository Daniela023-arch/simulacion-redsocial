
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'nombre_usuario',
        'correo',
        'password',
        'biografia',
        'avatar_color',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function publicaciones(): HasMany
    {
        return $this->hasMany(
            Publicacion::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(
            Comentario::class,
            'id_usuario',
            'id_usuario'
        );
    }
}
