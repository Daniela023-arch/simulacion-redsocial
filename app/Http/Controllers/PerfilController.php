<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil de un usuario.
     */
    public function mostrar(User $usuario): View
    {
        // Publicaciones del usuario
        $publicaciones = $usuario->publicaciones()
            ->withCount('comentarios')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10);

        // Cantidad total de publicaciones
        $totalPublicaciones = $usuario->publicaciones()
            ->count();

        // Cantidad total de comentarios realizados
        $totalComentarios = $usuario->comentarios()
            ->count();

        // Identificar si es el perfil propio
        $esMiPerfil = Auth::id() === $usuario->id;

        return view('perfiles.mostrar', compact(
            'usuario',
            'publicaciones',
            'totalPublicaciones',
            'totalComentarios',
            'esMiPerfil'
        ));
    }
}