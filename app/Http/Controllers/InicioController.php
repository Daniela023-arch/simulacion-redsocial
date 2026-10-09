<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publicacion;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    /**
     * Mostrar pantalla principal de Pensarium.
     */
    public function index(): View
    {
        // Usuario que inició sesión
        $usuario = Auth::user();

        // Obtener publicaciones de todos los usuarios
        // incluyendo información del autor
        // y cantidad de comentarios
        $publicaciones = Publicacion::with('usuario')
            ->withCount('comentarios')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10);

        // Obtener otros usuarios para el sidebar
        $usuarios = User::where('id', '!=', $usuario->id)
            ->orderBy('nombre')
            ->limit(8)
            ->get();

        // Total de publicaciones del usuario
        $misPublicaciones = Publicacion::where(
            'user_id',
            $usuario->id
        )->count();

        // Total de publicaciones de la plataforma
        $totalPublicaciones = Publicacion::count();

        // Total de usuarios registrados
        $totalUsuarios = User::count();

        return view('inicio.index', compact(
            'usuario',
            'publicaciones',
            'usuarios',
            'misPublicaciones',
            'totalPublicaciones',
            'totalUsuarios'
        ));
    }
}
