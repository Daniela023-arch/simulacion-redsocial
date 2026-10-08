
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| PENSARIUM - RUTAS WEB
|--------------------------------------------------------------------------
*/

// Usuarios que todavía no han iniciado sesión
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'mostrarLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.procesar');

    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])
        ->name('registro');

    Route::post('/registro', [AuthController::class, 'registro'])
        ->name('registro.procesar');
});

// Usuarios autenticados
Route::middleware('auth')->group(function () {

    // Página principal
    Route::get('/', [InicioController::class, 'index'])
        ->name('inicio');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Publicaciones
    Route::post('/publicaciones', [PublicacionController::class, 'store'])
        ->name('publicaciones.store');

    Route::get('/publicaciones/{publicacion}/editar', [PublicacionController::class, 'edit'])
        ->name('publicaciones.edit');

    Route::put('/publicaciones/{publicacion}', [PublicacionController::class, 'update'])
        ->name('publicaciones.update');

    Route::delete('/publicaciones/{publicacion}', [PublicacionController::class, 'destroy'])
        ->name('publicaciones.destroy');

    // Comentarios
    Route::post('/publicaciones/{publicacion}/comentarios', [ComentarioController::class, 'store'])
        ->name('comentarios.store');

    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])
        ->name('comentarios.destroy');

    // Perfiles
    Route::get('/usuarios', [PerfilController::class, 'buscar'])
        ->name('usuarios.buscar');

    Route::get('/perfil/editar', [PerfilController::class, 'edit'])
        ->name('perfil.edit');

    Route::put('/perfil', [PerfilController::class, 'update'])
        ->name('perfil.update');

    Route::put('/perfil/password', [PerfilController::class, 'updatePassword'])
        ->name('perfil.password');

    Route::get('/perfil/{usuario}', [PerfilController::class, 'show'])
        ->name('perfil.show');
});
