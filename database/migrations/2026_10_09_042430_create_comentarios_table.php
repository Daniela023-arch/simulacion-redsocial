
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear la tabla de comentarios.
     */
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {

            // Identificador único del comentario
            $table->id();

            // Usuario que escribió el comentario
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Publicación a la que pertenece
            $table->foreignId('publicacion_id')
                ->constrained('publicaciones')
                ->cascadeOnDelete();

            // Contenido del comentario
            $table->text('contenido');

            // Fechas de creación y modificación
            $table->timestamps();

            // Optimiza la consulta de comentarios
            // pertenecientes a una publicación
            $table->index([
                'publicacion_id',
                'created_at'
            ]);
        });
    }

    /**
     * Eliminar tabla al revertir.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
