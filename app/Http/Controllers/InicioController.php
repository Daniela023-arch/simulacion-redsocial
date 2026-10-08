<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function index(): View
    {
        $publicaciones = Publicacion::with([
            'usuario',
        ])
            ->withCount('comentarios')
            ->orderByDesc('created_at')
            ->orderByDesc('id_publicacion')
            ->paginate(10);

        $totalUsuarios = Usuario::count();

        $totalPublicaciones = Publicacion::count();

        return view('inicio.index', compact(
            'publicaciones',
            'totalUsuarios',
            'totalPublicaciones'
        ));
    }
}
