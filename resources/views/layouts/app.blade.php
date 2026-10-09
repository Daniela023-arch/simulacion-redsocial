
<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="PENSARIUM, un espacio para compartir pensamientos e ideas."
    >

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PENSARIUM')</title>

    {{-- Aplicar tema antes de mostrar la página --}}
    <script>
        try {
            const savedTheme = localStorage.getItem('pensarium-theme');

            const theme = savedTheme === 'light' || savedTheme === 'dark'
                ? savedTheme
                : (window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light');

            document.documentElement.setAttribute('data-theme', theme);
        } catch (error) {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div class="app-shell">

        {{-- Menú lateral --}}
        <aside class="app-sidebar" id="sidebar">

            {{-- Logo --}}
            <a href="{{ route('inicio') }}" class="sidebar-brand">

                <span class="sidebar-brand-mark">
                    P
                </span>

                <span>PENSARIUM.</span>

            </a>

            {{-- Navegación --}}
            <nav class="sidebar-nav" aria-label="Navegación principal">

                <a
                    href="{{ route('inicio') }}"
                    class="sidebar-link {{ request()->routeIs('inicio') ? 'active' : '' }}"
                    @if(request()->routeIs('inicio')) aria-current="page" @endif
                >
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="m3 10 9-7 9 7"/>
                        <path d="M5 9v12h14V9"/>
                        <path d="M9 21v-7h6v7"/>
                    </svg>

                    <span>Inicio</span>
                </a>

                <a
                    href="{{ route('publicaciones.crear') }}"
                    class="sidebar-link {{ request()->routeIs('publicaciones.crear') ? 'active' : '' }}"
                    @if(request()->routeIs('publicaciones.crear')) aria-current="page" @endif
                >
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                        <rect x="3" y="3" width="18" height="18" rx="3"/>
                    </svg>

                    <span>Crear publicación</span>
                </a>

                <a
                    href="{{ route('perfiles.mostrar', auth()->user()) }}"
                    class="sidebar-link {{ request()->routeIs('perfiles.mostrar') && request()->route('usuario')?->is(auth()->user()) ? 'active' : '' }}"
                >
                    <svg class="icon" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>

                    <span>Mi perfil</span>
                </a>

            </nav>

            {{-- Parte inferior del sidebar --}}
            <div class="sidebar-bottom">

                <button
                    type="button"
                    class="sidebar-link"
                    data-theme-toggle
                    aria-label="Cambiar tema"
                    aria-pressed="false"
                >
                    <svg
                        class="icon"
                        data-icon-moon
                        viewBox="0 0 24 24"
                    >
                        <path d="M20.9 13A9 9 0 0 1 11 3.1 9 9 0 1 0 20.9 13Z"/>
                    </svg>

                    <svg
                        class="icon"
                        data-icon-sun
                        viewBox="0 0 24 24"
                        hidden
                    >
                        <circle cx="12" cy="12" r="4"/>
                        <path d="M12 2v2"/>
                        <path d="M12 20v2"/>
                        <path d="m4.93 4.93 1.42 1.42"/>
                        <path d="m17.65 17.65 1.42 1.42"/>
                        <path d="M2 12h2"/>
                        <path d="M20 12h2"/>
                        <path d="m6.35 17.65-1.42 1.42"/>
                        <path d="m19.07 4.93-1.42 1.42"/>
                    </svg>

                    <span>Cambiar tema</span>
                </button>

                <a
                    href="{{ route('perfiles.mostrar', auth()->user()) }}"
                    class="sidebar-user"
                >
                    <span class="avatar avatar-sm">
                        {{ mb_strtoupper(mb_substr(auth()->user()->nombre, 0, 1)) }}
                    </span>

                    <span class="sidebar-user-info">

                        <span class="sidebar-user-name">
                            {{ auth()->user()->nombre }}
                        </span>

                        <span class="sidebar-user-handle">
                            {{ '@' . auth()->user()->username }}
                        </span>

                    </span>
                </a>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="sidebar-link"
                        style="width: 100%;"
                    >
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <path d="m16 17 5-5-5-5"/>
                            <path d="M21 12H9"/>
                        </svg>

                        <span>Cerrar sesión</span>
                    </button>
                </form>

            </div>

        </aside>

        {{-- Fondo del menú en celulares --}}
        <div
            class="sidebar-overlay"
            data-sidebar-overlay
            aria-hidden="true"
        ></div>

        {{-- Contenido principal --}}
        <div class="app-main">

            {{-- Encabezado --}}
            <header class="app-header">

                <div style="display: flex; align-items: center; gap: 15px;">

                    <button
                        type="button"
                        class="mobile-menu-button btn-icon"
                        data-sidebar-toggle
                        aria-label="Abrir menú"
                        aria-controls="sidebar"
                        aria-expanded="false"
                    >
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M4 7h16"/>
                            <path d="M4 12h16"/>
                            <path d="M4 17h16"/>
                        </svg>
                    </button>

                    <div>

                        <h1 class="header-title">
                            @yield('page-title', 'PENSARIUM')
                        </h1>

                        <p class="header-subtitle">
                            @yield('page-subtitle', 'Un espacio para tus ideas.')
                        </p>

                    </div>

                </div>

                <div class="header-actions">

                    <button
                        type="button"
                        class="btn-icon"
                        data-theme-toggle
                        aria-label="Cambiar tema"
                        aria-pressed="false"
                        title="Cambiar tema"
                    >
                        <svg
                            class="icon"
                            data-icon-moon
                            viewBox="0 0 24 24"
                        >
                            <path d="M20.9 13A9 9 0 0 1 11 3.1 9 9 0 1 0 20.9 13Z"/>
                        </svg>

                        <svg
                            class="icon"
                            data-icon-sun
                            viewBox="0 0 24 24"
                            hidden
                        >
                            <circle cx="12" cy="12" r="4"/>
                            <path d="M12 2v2"/>
                            <path d="M12 20v2"/>
                            <path d="m4.93 4.93 1.42 1.42"/>
                            <path d="m17.65 17.65 1.42 1.42"/>
                            <path d="M2 12h2"/>
                            <path d="M20 12h2"/>
                            <path d="m6.35 17.65-1.42 1.42"/>
                            <path d="m19.07 4.93-1.42 1.42"/>
                        </svg>
                    </button>

                    <a
                        href="{{ route('perfiles.mostrar', auth()->user()) }}"
                        class="avatar avatar-sm"
                        title="Mi perfil"
                        aria-label="Ir a mi perfil"
                    >
                        {{ mb_strtoupper(mb_substr(auth()->user()->nombre, 0, 1)) }}
                    </a>

                </div>

            </header>

            {{-- Área de contenido --}}
            <main class="app-content">

                {{-- Mensajes de éxito --}}
                @if(session('success'))

                    <div class="alert alert-success" role="status">

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

                {{-- Mensajes de error --}}
                @if(session('error'))

                    <div class="alert alert-error" role="alert">

                        <div class="alert-content">
                            {{ session('error') }}
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

                {{-- Errores generales --}}
                @if($errors->has('general'))

                    <div class="alert alert-error" role="alert">

                        <div class="alert-content">
                            {{ $errors->first('general') }}
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

                @yield('content')

            </main>

        </div>

    </div>

</body>
</html>
