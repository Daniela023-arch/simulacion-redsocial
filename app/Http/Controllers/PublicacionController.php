<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PublicacionController extends Controller
{
    /**
     * Mostrar formulario para crear publicación.
     */
    public function crear(): View
    {
        return view('publicaciones.crear');
    }

    /**
     * Guardar una nueva publicación.
     */
    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'contenido' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        Publicacion::create([
            'user_id' => Auth::id(),
            'contenido' => $datos['contenido'],
        ]);

        return redirect()
            ->route('inicio')
            ->with('success', 'Tu publicación se compartió correctamente.');
    }

    /**
     * Mostrar formulario para editar una publicación.
     */
    public function editar(Publicacion $publicacion): View
    {
        $this->verificarPropietario($publicacion);

        return view('publicaciones.editar', compact(
            'publicacion'
        ));
    }

    /**
     * Actualizar una publicación existente.
     */
    public function actualizar(
        Request $request,
        Publicacion $publicacion
    ): RedirectResponse {

        $this->verificarPropietario($publicacion);

        $datos = $request->validate([
            'contenido' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        $publicacion->update([
            'contenido' => $datos['contenido'],
        ]);

        return redirect()
            ->route('inicio')
            ->with('success', 'Publicación actualizada correctamente.');
    }

    /**
     * Eliminar una publicación.
     */
    public function eliminar(
        Publicacion $publicacion
    ): RedirectResponse {

        $this->verificarPropietario($publicacion);

        $publicacion->delete();

        return redirect()
            ->route('inicio')
            ->with('success', 'Publicación eliminada correctamente.');
    }

    /**
     * Verificar que la publicación pertenezca
     * al usuario autenticado.
     */
    private function verificarPropietario(
        Publicacion $publicacion
    ): void {

        abort_unless(
            $publicacion->user_id === Auth::id(),
            403,
            'No tienes permiso para modificar esta publicación.'
        );
    }
}
