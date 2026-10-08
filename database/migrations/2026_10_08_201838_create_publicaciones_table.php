
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id('id_publicacion');

            $table->foreignId('id_usuario')
                ->constrained(
                    table: 'usuarios',
                    column: 'id_usuario'
                )
                ->cascadeOnDelete();

            $table->text('contenido');

            $table->timestamps();

            $table->index([
                'created_at',
                'id_publicacion'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
