<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'users';

    /**
     * Campos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'nombre',
        'username',
        'email',
        'password',
    ];

    /**
     * Campos ocultos al serializar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión de atributos.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Publicaciones realizadas por el usuario.
     */
    public function publicaciones(): HasMany
    {
        return $this->hasMany(
            Publicacion::class,
            'user_id'
        );
    }

    /**
     * Comentarios realizados por el usuario.
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(
            Comentario::class,
            'user_id'
        );
    }
}
