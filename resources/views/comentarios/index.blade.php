
@extends('layouts.app')

@section('title', 'Comentarios | PENSARIUM')
@section('page-title', 'Conversación')
@section('page-subtitle', 'Descubre otras perspectivas y comparte la tuya.')

@section('content')

<div style="max-width: 850px; margin: 0 auto;">

    {{-- Encabezado --}}
    <div class="page-heading">

        <a
            href="{{ route('inicio') }}"
            class="post-action"
            style="margin-bottom: 15px;"
        >
            <svg class="icon icon-sm" viewBox="0 0 24 24">
                <path d="m15 18-6-6 6-6"/>
            </svg>

            Volver al inicio
        </a>

        <h1>Conversación</h1>

        <p>
            Comparte tu opinión y descubre
            lo que otras personas piensan.
        </p>

    </div>

    {{-- Publicación original --}}
    <article class="card post-card">

        <div class="post-header">

            <a
                href="{{ route('perfiles.mostrar', $publicacion->usuario) }}"
                class="avatar"
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

            <span class="post-action">

                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8A8.5 8.5 0 0 1 12.5 20a8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8A8.5 8.5 0 0 1 8.7 3.9a8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/>
                </svg>

                {{ $publicacion->comentarios()->count() }}
                comentarios

            </span>

        </div>

    </article>

    {{-- Formulario para comentar --}}
    <div class="card card-body mt-3">

        <h2 class="card-title">
            Escribe un comentario
        </h2>

        <p class="text-muted">
            ¿Qué opinas sobre este pensamiento?
        </p>

        <form
            action="{{ route('comentarios.guardar', $publicacion) }}"
            method="POST"
            data-prevent-double-submit
        >
            @csrf

            <div class="form-group">

                <label
                    for="contenido"
                    class="form-label"
                >
                    Tu comentario
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    class="form-control"
                    placeholder="Comparte tu opinión de manera respetuosa..."
                    maxlength="2000"
                    data-character-count="contador-comentario"
                    data-auto-resize
                    required
                >{{ old('contenido') }}</textarea>

                @error('contenido')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror

                <div
                    id="contador-comentario"
                    class="character-counter"
                    aria-live="polite"
                >
                    0 / 2000
                </div>

            </div>

            <div class="comment-form-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                    </svg>

                    Publicar comentario
                </button>

            </div>

        </form>

    </div>

    {{-- Lista de comentarios --}}
    <section class="card card-body mt-3">

        <h2 class="card-title" style="margin-bottom: 22px;">
            Comentarios
            <span class="text-muted">
                ({{ $comentarios->total() }})
            </span>
        </h2>

        <div class="comment-list">

            @forelse($comentarios as $comentario)

                <article class="comment-item">

                    <a
                        href="{{ route('perfiles.mostrar', $comentario->usuario) }}"
                        class="avatar avatar-sm"
                        aria-label="Ver perfil de {{ $comentario->usuario->nombre }}"
                    >
                        {{ mb_strtoupper(mb_substr($comentario->usuario->nombre, 0, 1)) }}
                    </a>

                    <div class="comment-content">

                        <div class="form-row">

                            <a
                                href="{{ route('perfiles.mostrar', $comentario->usuario) }}"
                                class="comment-author"
                            >
                                {{ $comentario->usuario->nombre }}
                            </a>

                            @if($comentario->user_id === auth()->id())

                                <form
                                    action="{{ route('comentarios.eliminar', $comentario) }}"
                                    method="POST"
                                    data-confirm-delete="¿Seguro que deseas eliminar este comentario?"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="post-action post-delete"
                                        aria-label="Eliminar comentario"
                                        title="Eliminar comentario"
                                    >
                                        <svg class="icon icon-sm" viewBox="0 0 24 24">
                                            <path d="M3 6h18"/>
                                            <path d="M8 6V4h8v2"/>
                                            <path d="M6 6l1 15h10l1-15"/>
                                            <path d="M10 10v7"/>
                                            <path d="M14 10v7"/>
                                        </svg>
                                    </button>

                                </form>

                            @endif

                        </div>

                        <p class="comment-text">{{ $comentario->contenido }}</p>

                        <div class="comment-meta">

                            <span>
                                {{ '@' . $comentario->usuario->username }}
                            </span>

                            <span>·</span>

                            <time datetime="{{ $comentario->created_at->toIso8601String() }}">
                                {{ $comentario->created_at->diffForHumans() }}
                            </time>

                        </div>

                    </div>

                </article>

            @empty

                <div class="empty-state">

                    <div class="empty-icon">
                        <svg class="icon icon-xl" viewBox="0 0 24 24">
                            <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8A8.5 8.5 0 0 1 12.5 20a8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8A8.5 8.5 0 0 1 8.7 3.9a8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/>
                        </svg>
                    </div>

                    <h3>Todavía no hay comentarios</h3>

                    <p>
                        Sé la primera persona en participar
                        en esta conversación.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Paginación --}}
        @if($comentarios->hasPages())

            <div class="pagination-container">
                {{ $comentarios->links() }}
            </div>

        @endif

    </section>

</div>

@endsection
