<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Mostrar comentarios de una publicación.
     */
    public function index(Publicacion $publicacion): View
    {
        $publicacion->load('usuario');

        $comentarios = $publicacion->comentarios()
            ->with('usuario')
            ->orderBy('created_at')
            ->orderBy('id')
            ->paginate(15);

        return view('comentarios.index', compact(
            'publicacion',
            'comentarios'
        ));
    }

    /**
     * Guardar comentario.
     */
    public function guardar(
        Request $request,
        Publicacion $publicacion
    ): RedirectResponse {

        $datos = $request->validate([
            'contenido' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        Comentario::create([
            'user_id' => Auth::id(),
            'publicacion_id' => $publicacion->id,
            'contenido' => $datos['contenido'],
        ]);

        return redirect()
            ->route('comentarios.index', $publicacion)
            ->with('success', 'Comentario publicado correctamente.');
    }

    /**
     * Eliminar comentario propio.
     */
    public function eliminar(
        Comentario $comentario
    ): RedirectResponse {

        abort_unless(
            $comentario->user_id === Auth::id(),
            403,
            'No puedes eliminar comentarios de otros usuarios.'
        );

        $publicacion = $comentario->publicacion;

        $comentario->delete();

        return redirect()
            ->route('comentarios.index', $publicacion)
            ->with('success', 'Comentario eliminado correctamente.');
    }
}
