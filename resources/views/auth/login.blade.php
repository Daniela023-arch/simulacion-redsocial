@extends('layouts.auth')

@section('title', 'Iniciar sesión | PENSARIUM')

@section('content')

<div class="auth-card">

    <div class="auth-mobile-brand">
        PENSARIUM
    </div>

    <h2>Bienvenido de nuevo.</h2>

    <p class="auth-subtitle">
        Inicia sesión para descubrir nuevas ideas,
        compartir pensamientos y conectar con otras personas.
    </p>

    @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-content">
                {{ session('success') }}
            </div>

            <button
                type="button"
                class="alert-close"
                data-alert-close
                aria-label="Cerrar mensaje"
            >
                &times;
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <div class="alert-content">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <form
        action="{{ route('login.procesar') }}"
        method="POST"
        data-prevent-double-submit
    >
        @csrf

        <div class="form-group">
            <label
                for="identificador"
                class="form-label"
            >
                Correo electrónico o usuario
            </label>

            <input
                type="text"
                id="identificador"
                name="identificador"
                class="form-control"
                placeholder="Ingresa tu correo o usuario"
                value="{{ old('identificador') }}"
                autocomplete="username"
                maxlength="255"
                required
                autofocus
            >

            @error('identificador')
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
                    placeholder="Ingresa tu contraseña"
                    autocomplete="current-password"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    data-password-toggle="password"
                    aria-label="Mostrar contraseña"
                    aria-pressed="false"
                >
                    <svg
                        class="icon"
                        data-eye
                        viewBox="0 0 24 24"
                    >
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

        <button
            type="submit"
            class="btn btn-primary btn-block"
        >
            Iniciar sesión

            <svg class="icon icon-sm" viewBox="0 0 24 24">
                <path d="M5 12h14"/>
                <path d="m13 6 6 6-6 6"/>
            </svg>
        </button>

    </form>

    <p class="auth-footer">
        ¿Todavía no tienes una cuenta?

        <a href="{{ route('registro') }}">
            Regístrate aquí
        </a>
    </p>

</div>

@endsection
