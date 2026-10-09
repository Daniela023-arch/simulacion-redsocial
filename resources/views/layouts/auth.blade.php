
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
        content="PENSARIUM: un espacio para compartir pensamientos, ideas y reflexiones."
    >

    <title>@yield('title', 'PENSARIUM')</title>

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

    <main class="auth-page">

        <section class="auth-visual">

            <a href="{{ route('login') }}" class="auth-brand">
                PENSARIUM<span>.</span>
            </a>

            <div class="auth-hero">
                <span class="auth-eyebrow">
                    Un espacio para tus ideas
                </span>

                <h1>
                    Cada pensamiento merece ser compartido.
                </h1>

                <p>
                    Descubre perspectivas, comparte reflexiones
                    y conecta con personas a través de las palabras.
                </p>
            </div>

            <div class="auth-quote">
                Las grandes conversaciones comienzan
                con una pequeña idea.
            </div>

        </section>

        <section class="auth-form-side">
            @yield('content')
        </section>

    </main>

</body>
</html>
