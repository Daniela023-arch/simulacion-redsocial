<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicacionController extends Controller
{
    public function crear(): View
    {
        return view('publicaciones.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'contenido' => [
                'required',
                'string',
                'min:1',
                'max:5000'
            ],
        ]);

        Publicacion::create([
            'id_usuario' => Auth::id(),
            'contenido' => $datos['contenido'],
        ]);

        return redirect()
            ->route('inicio')
            ->with('success', 'Publicación creada correctamente.');
    }

    public function mostrar(Publicacion $publicacion): View
    {
        $publicacion->load([
            'usuario',
            'comentarios' => function ($query) {
                $query->with('usuario')
                    ->orderBy('created_at')
                    ->orderBy('id_comentario');
            },
        ]);

        return view(
            'publicaciones.mostrar',
            compact('publicacion')
        );
    }

    public function editar(Publicacion $publicacion): View
    {
        abort_unless(
            $publicacion->id_usuario === Auth::id(),
            403,
            'No puedes editar esta publicación.'
        );

        return view(
            'publicaciones.editar',
            compact('publicacion')
        );
    }

    public function actualizar(
        Request $request,
        Publicacion $publicacion
    ): RedirectResponse {
        abort_unless(
            $publicacion->id_usuario === Auth::id(),
            403
        );

        $datos = $request->validate([
            'contenido' => [
                'required',
                'string',
                'min:1',
                'max:5000'
            ],
        ]);

        $publicacion->update($datos);

        return redirect()
            ->route('publicaciones.mostrar', $publicacion)
            ->with('success', 'Publicación actualizada.');
    }

    public function eliminar(
        Publicacion $publicacion
    ): RedirectResponse {
        abort_unless(
            $publicacion->id_usuario === Auth::id(),
            403
        );

        $publicacion->delete();

        return redirect()
            ->route('inicio')
            ->with('success', 'Publicación eliminada.');
    }
}
