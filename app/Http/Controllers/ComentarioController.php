
<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
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
            'id_publicacion' => $publicacion->id_publicacion,
            'id_usuario' => Auth::id(),
            'contenido' => $datos['contenido'],
        ]);

        return redirect()
            ->route('publicaciones.mostrar', $publicacion)
            ->with('success', 'Comentario publicado correctamente.');
    }

    public function eliminar(
        Comentario $comentario
    ): RedirectResponse {
        abort_unless(
            (int) $comentario->id_usuario === (int) Auth::id(),
            403,
            'No puedes eliminar este comentario.'
        );

        $publicacion = $comentario->publicacion;

        $comentario->delete();

        return redirect()
            ->route('publicaciones.mostrar', $publicacion)
            ->with('success', 'Comentario eliminado correctamente.');
    }
}
