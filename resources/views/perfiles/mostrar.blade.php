
@extends('layouts.app')

@section('title', $usuario->nombre . ' | PENSARIUM')
@section('page-title', 'Perfil')
@section('page-subtitle', 'Conoce a las personas detrás de las ideas.')

@section('content')

<div style="max-width: 950px; margin: 0 auto;">

    {{-- Encabezado del perfil --}}
    <div class="card">

        <div class="profile-cover"></div>

        <div class="profile-info">

            <div class="profile-avatar">
                <span class="avatar avatar-xl">
                    {{ mb_strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                </span>
            </div>

            <div class="profile-name">
                <h1>{{ $usuario->nombre }}</h1>

                <p class="profile-username">
                    {{ '@' . $usuario->username }}
                </p>
            </div>

            <p class="text-muted">
                Miembro de PENSARIUM desde
                {{ $usuario->created_at->translatedFormat('F \d\e Y') }}.
            </p>

            @if($esMiPerfil)

                <p class="text-muted">
                    Este es tu espacio personal.
                    Aquí puedes consultar los pensamientos
                    que has compartido con la comunidad.
                </p>

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

            @endif

            {{-- Estadísticas --}}
            <div class="profile-stats">

                <div class="profile-stat">
                    <strong>{{ $totalPublicaciones }}</strong>
                    <span>Publicaciones</span>
                </div>

                <div class="profile-stat">
                    <strong>{{ $totalComentarios }}</strong>
                    <span>Comentarios</span>
                </div>

            </div>

        </div>

    </div>

    {{-- Encabezado de publicaciones --}}
    <div class="page-heading mt-3">

        <h2>
            @if($esMiPerfil)
                Mis publicaciones
            @else
                Publicaciones de {{ explode(' ', $usuario->nombre)[0] }}
            @endif
        </h2>

        <p>
            @if($esMiPerfil)
                Todos los pensamientos que has compartido.
            @else
                Descubre las ideas que esta persona
                ha compartido con la comunidad.
            @endif
        </p>

    </div>

    {{-- Publicaciones del usuario --}}
    <div class="feed-list">

        @forelse($publicaciones as $publicacion)

            <article class="card post-card">

                <div class="post-header">

                    <span class="avatar">
                        {{ mb_strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                    </span>

                    <div class="post-author">

                        <span class="post-author-name">
                            {{ $usuario->nombre }}
                        </span>

                        <div class="post-meta">

                            <span>
                                {{ '@' . $usuario->username }}
                            </span>

                            <span>·</span>

                            <time datetime="{{ $publicacion->created_at->toIso8601String() }}">
                                {{ $publicacion->created_at->diffForHumans() }}
                            </time>

                        </div>

                    </div>

                    @if($esMiPerfil)

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

                    @if($esMiPerfil)

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
                    @if($esMiPerfil)
                        Aún no has compartido ningún pensamiento.
                    @else
                        Esta persona todavía no ha compartido
                        ningún pensamiento.
                    @endif
                </p>

                @if($esMiPerfil)

                    <a
                        href="{{ route('publicaciones.crear') }}"
                        class="btn btn-primary"
                    >
                        Crear mi primera publicación
                    </a>

                @endif

            </div>

        @endforelse

    </div>

    {{-- Paginación --}}
    @if($publicaciones->hasPages())

        <div class="pagination-container">
            {{ $publicaciones->links() }}
        </div>

    @endif

</div>

@endsection
