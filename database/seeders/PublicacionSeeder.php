<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Publicacion;
use Illuminate\Support\Carbon;

class PublicacionSeeder extends Seeder
{
    public function run(): void
    {
        $publicaciones = [
            ['daniela', 'A veces los pequeños avances son los que terminan construyendo nuestros sueños.'],
            ['mariana', 'Hoy aprendí que descansar también es una forma de ser productivo.'],
            ['carlos', 'La programación me ha enseñado que siempre existe más de una forma de resolver un problema.'],
            ['sofia', 'No todos los días tienen que ser extraordinarios. Algunos simplemente necesitan ser tranquilos.'],
            ['alejandro', 'Terminé un libro que me hizo cuestionar muchas cosas sobre la vida y nuestras decisiones.'],
            ['valeria', 'Hay conversaciones que pueden cambiar por completo nuestra manera de ver el mundo.'],
            ['diego', 'El mejor momento para empezar algo fue ayer. El segundo mejor momento es hoy.'],
            ['camila', 'Me gusta pensar que cada persona que conocemos tiene una historia que vale la pena escuchar.'],
            ['sebastian', 'Hoy finalmente resolví un error de código que llevaba horas intentando solucionar.'],
            ['lucia', 'La creatividad aparece cuando nos permitimos experimentar sin miedo a equivocarnos.'],
            ['daniela', 'Estoy desarrollando una aplicación web y cada día descubro algo nuevo sobre Laravel.'],
            ['mariana', 'A veces una taza de café y una buena canción son suficientes para mejorar el día.'],
            ['carlos', 'Aprender algo nuevo puede ser frustrante, pero también increíblemente satisfactorio.'],
            ['sofia', 'La universidad no solamente nos enseña conocimientos. También nos enseña paciencia y perseverancia.'],
            ['alejandro', '¿Qué libro recomendarían a alguien que quiere comenzar a leer ciencia ficción?'],
            ['valeria', 'No tenemos que tener toda nuestra vida resuelta para disfrutar el presente.'],
            ['diego', 'Hoy salí a caminar sin audífonos y descubrí lo mucho que necesitaba desconectarme.'],
            ['camila', 'Las mejores ideas suelen aparecer cuando dejamos de buscarlas desesperadamente.'],
            ['sebastian', 'Estoy aprendiendo sobre bases de datos y cada vez entiendo mejor la importancia de organizarlas correctamente.'],
            ['lucia', 'Una fotografía puede guardar un recuerdo que las palabras no siempre logran explicar.'],
            ['daniela', 'Me encanta la idea de tener un espacio donde podamos compartir nuestros pensamientos libremente.'],
            ['mariana', 'Recordatorio del día: compararte con otras personas no siempre refleja tu propio progreso.'],
            ['carlos', 'Hoy descubrí una herramienta que me ayudará muchísimo con mis proyectos de programación.'],
            ['sofia', 'Hay días en los que necesitamos escuchar más y hablar menos.'],
            ['valeria', 'Las personas cambian, las ideas evolucionan y eso también forma parte de crecer.'],
        ];

        foreach ($publicaciones as $indice => $datos) {
            $usuario = User::where('username', $datos[0])->firstOrFail();

            $fecha = Carbon::now()->subHours(
                count($publicaciones) - $indice
            );

            $publicacion = new Publicacion([
                'contenido' => $datos[1],
            ]);

            $publicacion->usuario()->associate($usuario);
            $publicacion->created_at = $fecha;
            $publicacion->updated_at = $fecha;
            $publicacion->save();
        }
    }
}
