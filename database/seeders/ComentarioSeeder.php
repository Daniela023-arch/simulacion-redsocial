<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Publicacion;
use App\Models\Comentario;
use Illuminate\Support\Carbon;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::orderBy('id')->get();

        $publicaciones = Publicacion::orderBy('id')->get();

        $comentarios = [
            'Estoy totalmente de acuerdo contigo.',
            'Me gustó mucho esta reflexión.',
            'Nunca lo había pensado de esa manera.',
            'Gracias por compartir esto.',
            'Es una perspectiva muy interesante.',
            'Creo que muchas personas podemos identificarnos.',
            'Me hiciste reflexionar sobre este tema.',
            'Qué buena manera de expresar esa idea.',
            'Definitivamente vale la pena recordarlo.',
            'Me encantaría conocer más sobre tu experiencia.',
            'Estoy pasando por algo parecido.',
            'A veces necesitamos leer algo así.',
            'Es cierto, cada experiencia nos deja un aprendizaje.',
            'Me parece una reflexión muy acertada.',
            'Gracias por abrir esta conversación.',
            'También he aprendido algo parecido.',
            'Qué interesante lo que comentas.',
            'Me identifico bastante con tus palabras.',
            'Creo que es importante hablar de estas cosas.',
            'Excelente pensamiento, gracias por compartirlo.',
        ];

        foreach ($publicaciones as $indice => $publicacion) {

            // Seleccionar usuarios distintos del autor
            $otrosUsuarios = $usuarios
                ->where('id', '!=', $publicacion->user_id)
                ->values();

            for ($i = 0; $i < 2; $i++) {

                $usuario = $otrosUsuarios[
                    ($indice * 2 + $i) % $otrosUsuarios->count()
                ];

                $texto = $comentarios[
                    ($indice * 2 + $i) % count($comentarios)
                ];

                $fecha = Carbon::parse(
                    $publicacion->created_at
                )->addMinutes(($i + 1) * 10);

                $comentario = new Comentario([
                    'contenido' => $texto,
                ]);

                $comentario->usuario()->associate($usuario);

                $comentario->publicacion()->associate(
                    $publicacion
                );

                $comentario->created_at = $fecha;
                $comentario->updated_at = $fecha;

                $comentario->save();
            }
        }
    }
}
