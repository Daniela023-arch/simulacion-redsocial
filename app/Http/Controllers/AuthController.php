
<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    public function mostrarRegistro(): View
    {
        return view('auth.registro');
    }

    public function registrar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'nombre_usuario' => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                'unique:usuarios,nombre_usuario'
            ],
            'correo' => [
                'required',
                'email',
                'max:150',
                'unique:usuarios,correo'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
            ],
        ]);

        $usuario = Usuario::create([
            'nombre' => $datos['nombre'],
            'nombre_usuario' => $datos['nombre_usuario'],
            'correo' => $datos['correo'],
            'password' => $datos['password'],
            'avatar_color' => '#8e6e53',
        ]);

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()
            ->route('inicio')
            ->with('success', 'Tu cuenta fue creada correctamente.');
    }

    public function iniciarSesion(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'correo' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credenciales, $request->boolean('recordar'))) {
            return back()
                ->withErrors([
                    'correo' => 'El correo o la contraseña son incorrectos.',
                ])
                ->onlyInput('correo');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('inicio'));
    }

    public function cerrarSesion(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
