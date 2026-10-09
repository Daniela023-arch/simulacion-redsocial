
@extends('layouts.auth')

@section('title', 'Crear cuenta | PENSARIUM')

@section('content')

<div class="auth-card">

    <div class="auth-mobile-brand">
        PENSARIUM
    </div>

    <h2>Comienza a compartir.</h2>

    <p class="auth-subtitle">
        Crea tu cuenta y forma parte de una comunidad
        donde cada pensamiento tiene su espacio.
    </p>

    @if($errors->any())
        <div class="alert alert-error">
            <div class="alert-content">
                Revisa los campos marcados e intenta nuevamente.
            </div>
        </div>
    @endif

    <form
        action="{{ route('registro.guardar') }}"
        method="POST"
        data-prevent-double-submit
    >
        @csrf

        <div class="form-group">
            <label
                for="nombre"
                class="form-label"
            >
                Nombre completo
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                class="form-control"
                placeholder="Ej. Mariana García"
                value="{{ old('nombre') }}"
                maxlength="100"
                autocomplete="name"
                required
            >

            @error('nombre')
                <p class="form-error">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="form-group">
            <label
                for="username"
                class="form-label"
            >
                Nombre de usuario
            </label>

            <input
                type="text"
                id="username"
                name="username"
                class="form-control"
                placeholder="Ej. mariana"
                value="{{ old('username') }}"
                minlength="3"
                maxlength="50"
                autocomplete="username"
                required
            >

            <span class="form-help">
                Usa letras, números, guiones o guiones bajos.
            </span>

            @error('username')
                <p class="form-error">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="form-group">
            <label
                for="email"
                class="form-label"
            >
                Correo electrónico
            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                placeholder="nombre@correo.com"
                value="{{ old('email') }}"
                maxlength="255"
                autocomplete="email"
                required
            >

            @error('email')
                <p class="form-error">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="form-group">
            <label
                for="password"
                class="form-label"
            >
                Contraseña
            </label>

            <div class="input-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Mínimo 8 caracteres"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    data-password-toggle="password"
                    aria-label="Mostrar contraseña"
                    aria-pressed="false"
                >
                    <svg class="icon" data-eye viewBox="0 0 24 24">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>

                    <svg
                        class="icon"
                        data-eye-off
                        viewBox="0 0 24 24"
                        hidden
                    >
                        <path d="m3 3 18 18"/>
                        <path d="M10.6 5.1A11 11 0 0 1 12 5c6.5 0 10 7 10 7a16 16 0 0 1-3.1 3.9"/>
                        <path d="M6.2 6.2C3.5 8.1 2 12 2 12s3.5 7 10 7c1.4 0 2.7-.3 3.8-.8"/>
                    </svg>
                </button>
            </div>

            @error('password')
                <p class="form-error">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="form-group">
            <label
                for="password_confirmation"
                class="form-label"
            >
                Confirmar contraseña
            </label>

            <div class="input-wrapper">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Repite tu contraseña"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    data-password-toggle="password_confirmation"
                    aria-label="Mostrar contraseña"
                    aria-pressed="false"
                >
                    <svg class="icon" data-eye viewBox="0 0 24 24">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>

                    <svg
                        class="icon"
                        data-eye-off
                        viewBox="0 0 24 24"
                        hidden
                    >
                        <path d="m3 3 18 18"/>
                        <path d="M10.6 5.1A11 11 0 0 1 12 5c6.5 0 10 7 10 7a16 16 0 0 1-3.1 3.9"/>
                        <path d="M6.2 6.2C3.5 8.1 2 12 2 12s3.5 7 10 7 10-7-3.5-7-10-7Z"/>
                    </svg>
                </button>
            </div>
        </div>

        <button
            type="submit"
            class="btn btn-primary btn-block"
        >
            Crear mi cuenta

            <svg class="icon icon-sm" viewBox="0 0 24 24">
                <path d="M5 12h14"/>
                <path d="m13 6 6 6-6 6"/>
            </svg>
        </button>

    </form>

    <p class="auth-footer">
        ¿Ya tienes una cuenta?

        <a href="{{ route('login') }}">
            Inicia sesión
        </a>
    </p>

</div>

@endsection
