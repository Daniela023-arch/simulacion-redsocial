
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');

            $table->string('nombre', 100);

            $table->string('nombre_usuario', 50)->unique();

            $table->string('correo', 150)->unique();

            $table->string('password');

            $table->text('biografia')->nullable();

            $table->string('avatar_color', 7)
                ->default('#8e6e53');

            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
