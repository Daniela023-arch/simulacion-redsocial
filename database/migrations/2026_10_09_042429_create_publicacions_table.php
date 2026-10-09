
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear la tabla de publicaciones.
     */
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {

            // Identificador único
            $table->id();

            // Usuario propietario de la publicación
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Pensamiento, nota o texto publicado
            $table->text('contenido');

            // Fecha de creación y actualización
            $table->timestamps();

            // Índice para consultar publicaciones
            // de un usuario por fecha
            $table->index([
                'user_id',
                'created_at'
            ]);
        });
    }

    /**
     * Eliminar la tabla si se revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
