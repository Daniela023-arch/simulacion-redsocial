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
| Sistema de publicación de pensamientos y comentarios.
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', function () {
    return redirect()->route(
        auth()->check() ? 'inicio' : 'login'
    );
})->name('principal');

/*
|--------------------------------------------------------------------------
| RUTAS PARA INVITADOS
|--------------------------------------------------------------------------
| Solo usuarios que no han iniciado sesión.
|--------------------------------------------------------------------------
*/

Route::middleware('invitado')->group(function () {

    // Inicio de sesión
    Route::get('/login', [
        AuthController::class,
        'mostrarLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ])->name('login.procesar');

    // Registro
    Route::get('/registro', [
        AuthController::class,
        'mostrarRegistro'
    ])->name('registro');

    Route::post('/registro', [
        AuthController::class,
        'registro'
    ])->name('registro.guardar');

});

/*
|--------------------------------------------------------------------------
| RUTAS PARA USUARIOS AUTENTICADOS
|--------------------------------------------------------------------------
*/

Route::middleware('autenticado')->group(function () {

    // Cerrar sesión
    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | INICIO
    |--------------------------------------------------------------------------
    */

    Route::get('/inicio', [
        InicioController::class,
        'index'
    ])->name('inicio');

    /*
    |--------------------------------------------------------------------------
    | PUBLICACIONES
    |--------------------------------------------------------------------------
    */

    // Formulario de nueva publicación
    Route::get('/publicaciones/crear', [
        PublicacionController::class,
        'crear'
    ])->name('publicaciones.crear');

    // Guardar publicación
    Route::post('/publicaciones', [
        PublicacionController::class,
        'guardar'
    ])->name('publicaciones.guardar');

    // Formulario de edición
    Route::get('/publicaciones/{publicacion}/editar', [
        PublicacionController::class,
        'editar'
    ])->name('publicaciones.editar');

    // Actualizar publicación
    Route::put('/publicaciones/{publicacion}', [
        PublicacionController::class,
        'actualizar'
    ])->name('publicaciones.actualizar');

    // Eliminar publicación
    Route::delete('/publicaciones/{publicacion}', [
        PublicacionController::class,
        'eliminar'
    ])->name('publicaciones.eliminar');

    /*
    |--------------------------------------------------------------------------
    | COMENTARIOS
    |--------------------------------------------------------------------------
    */

    // Ver comentarios de una publicación
    Route::get('/publicaciones/{publicacion}/comentarios', [
        ComentarioController::class,
        'index'
    ])->name('comentarios.index');

    // Guardar comentario
    Route::post('/publicaciones/{publicacion}/comentarios', [
        ComentarioController::class,
        'guardar'
    ])->name('comentarios.guardar');

    // Eliminar comentario
    Route::delete('/comentarios/{comentario}', [
        ComentarioController::class,
        'eliminar'
    ])->name('comentarios.eliminar');

    /*
    |--------------------------------------------------------------------------
    | PERFILES
    |--------------------------------------------------------------------------
    */

    // Ver perfil de cualquier usuario
    Route::get('/perfiles/{usuario}', [
        PerfilController::class,
        'mostrar'
    ])->name('perfiles.mostrar');

});
