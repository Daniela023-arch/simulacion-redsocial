<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de inicio de sesión.
     */
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Mostrar formulario de registro.
     */
    public function mostrarRegistro(): View
    {
        return view('auth.registro');
    }

    /**
     * Registrar un nuevo usuario.
     */
    public function registro(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash:ascii',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        try {
            $usuario = User::create([
                'nombre' => $datos['nombre'],
                'username' => $datos['username'],
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']),
            ]);
        } catch (UniqueConstraintViolationException $e) {
            throw ValidationException::withMessages([
                'email' => 'El correo o nombre de usuario ya está registrado.',
            ]);
        }

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()
            ->route('inicio')
            ->with('success', 'Tu cuenta se creó correctamente.');
    }

    /**
     * Iniciar sesión con correo o nombre de usuario.
     */
    public function login(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'identificador' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $identificador = trim($datos['identificador']);

        $campo = filter_var(
            $identificador,
            FILTER_VALIDATE_EMAIL
        ) ? 'email' : 'username';

        $credenciales = [
            $campo => $identificador,
            'password' => $datos['password'],
        ];

        if (!Auth::attempt($credenciales)) {
            throw ValidationException::withMessages([
                'identificador' => 'El usuario, correo o contraseña son incorrectos.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('inicio'));
    }

    /**
     * Cerrar sesión de forma segura.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
