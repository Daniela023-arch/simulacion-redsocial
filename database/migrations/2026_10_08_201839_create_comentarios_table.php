
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id('id_comentario');

            $table->foreignId('id_publicacion')
                ->constrained(
                    table: 'publicaciones',
                    column: 'id_publicacion'
                )
                ->cascadeOnDelete();

            $table->foreignId('id_usuario')
                ->constrained(
                    table: 'usuarios',
                    column: 'id_usuario'
                )
                ->cascadeOnDelete();

            $table->text('contenido');

            $table->timestamps();

            $table->index([
                'id_publicacion',
                'created_at'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
