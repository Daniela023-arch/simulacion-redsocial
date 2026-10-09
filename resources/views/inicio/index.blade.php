
@extends('layouts.app')

@section('title', 'Inicio | PENSARIUM')
@section('page-title', 'Inicio')
@section('page-subtitle', 'Descubre lo que está pensando la comunidad.')

@section('content')

<div class="feed-layout">

    <section class="feed-main">

        {{-- Encabezado --}}
        <div class="page-heading">
            <h1>Un espacio para tus ideas.</h1>
            <p>
                Comparte tus pensamientos y descubre
                nuevas perspectivas.
            </p>
        </div>

        {{-- Crear publicación --}}
        <div class="card composer-card">

            <div class="composer-top">

                <span class="avatar">
                    {{ mb_strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                </span>

                <a
                    href="{{ route('publicaciones.crear') }}"
                    class="composer-placeholder"
                >
                    ¿Qué estás pensando, {{ explode(' ', $usuario->nombre)[0] }}?
                </a>

            </div>

            <div class="composer-divider"></div>

            <div class="composer-bottom">

                <span class="composer-hint">
                    Tus palabras pueden iniciar una conversación.
                </span>

                <a
                    href="{{ route('publicaciones.crear') }}"
                    class="btn btn-primary btn-sm"
                >
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                    </svg>

                    Nueva publicación
                </a>

            </div>

        </div>

        {{-- Lista de publicaciones --}}
        <div class="feed-list">

            @forelse($publicaciones as $publicacion)

                <article class="card post-card">

                    <div class="post-header">

                        <a
                            href="{{ route('perfiles.mostrar', $publicacion->usuario) }}"
                            class="avatar"
                            aria-label="Ver perfil de {{ $publicacion->usuario->nombre }}"
                        >
                            {{ mb_strtoupper(mb_substr($publicacion->usuario->nombre, 0, 1)) }}
                        </a>

                        <div class="post-author">

                            <a
                                href="{{ route('perfiles.mostrar', $publicacion->usuario) }}"
                                class="post-author-name"
                            >
                                {{ $publicacion->usuario->nombre }}
                            </a>

                            <div class="post-meta">

                                <span>
                                    {{ '@' . $publicacion->usuario->username }}
                                </span>

                                <span>·</span>

                                <time datetime="{{ $publicacion->created_at->toIso8601String() }}">
                                    {{ $publicacion->created_at->diffForHumans() }}
                                </time>

                            </div>

                        </div>

                        @if($publicacion->user_id === auth()->id())

                            <a
                                href="{{ route('publicaciones.editar', $publicacion) }}"
                                class="btn-icon"
                                title="Editar publicación"
                                aria-label="Editar publicación"
                            >
                                <svg class="icon icon-sm" viewBox="0 0 24 24">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L9 17l-4 1 1-4Z"/>
                                </svg>
                            </a>

                        @endif

                    </div>

                    <div class="post-content">{{ $publicacion->contenido }}</div>

                    <div class="post-footer">

                        <a
                            href="{{ route('comentarios.index', $publicacion) }}"
                            class="post-action"
                        >
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8A8.5 8.5 0 0 1 12.5 20a8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8A8.5 8.5 0 0 1 8.7 3.9a8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/>
                            </svg>

                            {{ $publicacion->comentarios_count }}
                            {{ $publicacion->comentarios_count === 1 ? 'comentario' : 'comentarios' }}
                        </a>

                        @if($publicacion->user_id === auth()->id())

                            <div class="post-actions">

                                <a
                                    href="{{ route('publicaciones.editar', $publicacion) }}"
                                    class="post-action"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('publicaciones.eliminar', $publicacion) }}"
                                    method="POST"
                                    data-confirm-delete="¿Seguro que deseas eliminar esta publicación? También se eliminarán sus comentarios."
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="post-action post-delete"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </div>

                        @endif

                    </div>

                </article>

            @empty

                <div class="card empty-state">

                    <div class="empty-icon">
                        <svg class="icon icon-xl" viewBox="0 0 24 24">
                            <path d="M8 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-3"/>
                            <path d="M8 12h6"/>
                            <path d="M8 16h4"/>
                            <path d="m16 5 3 3"/>
                            <path d="m10 14 1-4 7.5-7.5a2.12 2.12 0 0 1 3 3L14 13Z"/>
                        </svg>
                    </div>

                    <h3>Todavía no hay publicaciones</h3>

                    <p>
                        Sé la primera persona en compartir
                        un pensamiento con la comunidad.
                    </p>

                    <a
                        href="{{ route('publicaciones.crear') }}"
                        class="btn btn-primary"
                    >
                        Crear publicación
                    </a>

                </div>

            @endforelse

        </div>

        {{-- Paginación --}}
        @if($publicaciones->hasPages())

            <div class="pagination-container">
                {{ $publicaciones->links() }}
            </div>

        @endif

    </section>

    {{-- Panel lateral derecho --}}
    <aside class="feed-rightbar">

        {{-- Estadísticas --}}
        <div class="card widget">

            <h2 class="widget-title">
                Tu espacio
            </h2>

            <div class="stat-list">

                <div class="stat-row">
                    <span>Mis publicaciones</span>
                    <span class="stat-value">
                        {{ $misPublicaciones }}
                    </span>
                </div>

                <div class="stat-row">
                    <span>Publicaciones totales</span>
                    <span class="stat-value">
                        {{ $totalPublicaciones }}
                    </span>
                </div>

                <div class="stat-row">
                    <span>Personas en la comunidad</span>
                    <span class="stat-value">
                        {{ $totalUsuarios }}
                    </span>
                </div>

            </div>

        </div>

        {{-- Usuarios de la comunidad --}}
        <div class="card widget">

            <h2 class="widget-title">
                Personas en PENSARIUM
            </h2>

            @forelse($usuarios as $otroUsuario)

                <div class="widget-user">

                    <a
                        href="{{ route('perfiles.mostrar', $otroUsuario) }}"
                        class="avatar avatar-sm"
                    >
                        {{ mb_strtoupper(mb_substr($otroUsuario->nombre, 0, 1)) }}
                    </a>

                    <div class="widget-user-info">

                        <a
                            href="{{ route('perfiles.mostrar', $otroUsuario) }}"
                            class="widget-user-name"
                        >
                            {{ $otroUsuario->nombre }}
                        </a>

                        <span class="widget-user-handle">
                            {{ '@' . $otroUsuario->username }}
                        </span>

                    </div>

                </div>

            @empty

                <p class="text-muted">
                    Aún no hay otros usuarios registrados.
                </p>

            @endforelse

        </div>

        {{-- Mensaje de comunidad --}}
        <div class="card widget">

            <h2 class="widget-title">
                Sobre PENSARIUM
            </h2>

            <p class="text-muted mb-0">
                Un espacio para expresar ideas,
                compartir experiencias y descubrir
                nuevas formas de pensar.
            </p>

        </div>

    </aside>

</div>

@endsection
