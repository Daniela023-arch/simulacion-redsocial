
<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function index(): View
    {
        $usuarios = Usuario::withCount('publicaciones')
            ->orderBy('nombre')
            ->paginate(12);

        return view('perfiles.index', compact('usuarios'));
    }

    public function mostrar(Usuario $usuario): View
    {
        $publicaciones = $usuario->publicaciones()
            ->with('usuario')
            ->withCount('comentarios')
            ->latest()
            ->paginate(10);

        $usuario->loadCount([
            'publicaciones',
            'comentarios',
        ]);

        return view('perfiles.mostrar', compact(
            'usuario',
            'publicaciones'
        ));
    }

    public function editar(): View
    {
        $usuario = Auth::user();

        return view('perfiles.editar', compact('usuario'));
    }

    public function actualizar(
        Request $request
    ): RedirectResponse {
        $usuario = Auth::user();

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],
            'nombre_usuario' => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique('usuarios', 'nombre_usuario')
                    ->ignore($usuario->id_usuario, 'id_usuario'),
            ],
            'biografia' => [
                'nullable',
                'string',
                'max:500',
            ],
            'avatar_color' => [
                'required',
                'regex:/^#[0-9a-fA-F]{6}$/',
            ],
        ]);

        $usuario->update($datos);

        return redirect()
            ->route('perfiles.mostrar', $usuario)
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
